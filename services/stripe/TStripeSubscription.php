<?php

namespace app\services\stripe;

use app\models\Plan as BasePlan;
use app\models\Plan;
use app\models\User;
use app\services\StripeService;
use Stripe\ApiResource;
use Stripe\Customer;
use Stripe\Event;
use Stripe\Subscription;
use Yii;

trait TStripeSubscription
{
    /**
     * @param User $user
     * @return bool
     */
    public static function getActiveSubscription(User $user)
    {
        $user = $user ?? Yii::$app->user->identity;

        $subscription = Subscription::retrieve($user->stripe_subscription_id);
        return (bool)$subscription->status;
    }

    /**
     * @param User $user
     * @return Subscription
     */
    public static function getSubscription(User $user)
    {
        $user = $user ?? Yii::$app->user->identity;

        return $subscription = Subscription::retrieve($user->stripe_subscription_id);
    }

    /**
     * @param $event
     * @throws \Exception
     */
    public static function subscriptionCreate($event)
    {
        /** @var User $user */
        $user = self::getUserModel($event);
        $planId = Plan::$stripePlanIdToDbId[$event->data->object->plan->id];

        if ($planId !== $user->plan_id) {
            $role = Plan::$rolePlans[$event->data->object->plan->id];
            StripeService::changePlan($user, $role);
        }

        $user->stripe_subscription_id = $event->data->object->id;
        $user->save();
    }

    /**
     * @param $event
     * @throws \Exception
     */
    public static function subscriptionUpdate($event)
    {
        $subscriptionStatus = $event->data->object->status ?? false;
        /** @var User $user */
        $user = self::getUserModel($event);

        // is active
        if (in_array($subscriptionStatus, StripeService::ACTIVE_SUBSCRIPTION_STATUSES)) {

            $newPlanId = $event->data->object->plan->id;
            $newPlanDbId = Plan::$stripePlanIdToDbId[$newPlanId] ?? false;

            // subscription status was been changed
            if ($newPlanDbId && isset($event->data->previous_attributes->status)) {
                $role = Plan::$rolePlans[$newPlanId];
                self::changePlan($user, $role);
            }
        // past due
        } elseif ($subscriptionStatus === Subscription::STATUS_PAST_DUE) {
            // change access without delete plan_id
            self::changeRole($user, User::ROLE_FREE);
        // cancel statuses
        } else {
            self::changePlan($user, User::ROLE_FREE);
        }
    }

    /**
     * @param User $user
     * @param array $token
     * @param null $couponCode
     * @param string $planId
     * @return ApiResource
     * @throws \Exception
     */
    public static function activateSubscription(
        User $user,
        array $token = [],
        $couponCode = null,
        $planId = BasePlan::PLAN_BASIC
    )
    {
        $plan = self::getPlan($planId);

        /** @var Customer $customer */
        $customer = self::createCustomer($user, $token);

        $subscriptionData = [
            'prorate' => false,
            'customer' => $customer->id,
            'items' => [
                [
                    'plan' => $plan->id,
                ],
            ],
            'cancel_at_period_end' => false,
            'trial_from_plan' => true
        ];

        if ($couponCode) {
            $coupon = self::retrieveCouponByCode($couponCode);

            if ($coupon) {
                $subscriptionData['coupon'] = $coupon->id;
            }
        }

        $stripeSubscription = Subscription::create($subscriptionData);

        return $stripeSubscription;
    }

    /**
     * @param User $user
     * @param bool $immediately
     * @return bool
     */
    public static function cancelSubscription(User $user, $immediately = false)
    {
        /** @var User $user */
        $user = $user ?? Yii::$app->user->identity;
        $activeSubscription = self::getActiveSubscription($user);

        if (!$activeSubscription) {
            return false;
        }

        try {
            $stripeSubscription = Subscription::retrieve($user->stripe_subscription_id);

            if ($immediately) {
                $stripeSubscription->cancel();
            } else {
                $stripeSubscription->update($user->stripe_subscription_id, ['cancel_at_period_end' => true]);
            }

            return true;
        } catch (\Exception $e) {

            return false;
        }
    }

    /**
     * @param User $user
     * @return bool
     */
    public static function reactivateSubscription(User $user)
    {
        /** @var User $user */
        $user = $user ?? Yii::$app->user->identity;
        $activeSubscription = self::getActiveSubscription($user);

        if (!$activeSubscription) {
            return false;
        }

        try {
            $stripeSubscription = Subscription::retrieve($user->stripe_subscription_id);
            $stripeSubscription->update($user->stripe_subscription_id, ['cancel_at_period_end' => false]);

            return true;
        } catch (\Exception $e) {

            return false;
        }
    }

    /**
     * @param Event $event
     * @return bool
     */
    public static function deleteSubscription($event)
    {
        try {
            $user = self::getUserModel($event);

            // is't current user subscription
            if ($user->stripe_subscription_id !== $event->data->object->id) {
                return false;
            }

            self::changePlan($user, User::ROLE_FREE);

        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public static function getSubscriptionMessage(User $user)
    {
        if (!$user->stripe_subscription_id) {

            return [
                'success' => true,
                'message' => null,
                'subscription' => null,
            ];
        }

        StripeService::setSecretApiKey();

        try {
            /** @var Subscription $stripeSubscription */
            $stripeSubscription = StripeService::getSubscription($user);
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 422;

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        $message = null;
        $success = true;

        if ($stripeSubscription->status === Subscription::STATUS_PAST_DUE) {

            $message = StripeService::getMessage(StripeService::MESSAGE_SUBSCRIPTION_STATUS_PAST_DUE);

        } elseif (in_array($stripeSubscription->status, StripeService::UNPAID_SUBSCRIPTION_STATUSES)) {

            $message = StripeService::getMessage(StripeService::MESSAGE_SUBSCRIPTION_STATUS_FAIL);

        } elseif ($stripeSubscription->status === Subscription::STATUS_CANCELED) {

            $customer = StripeService::getCustomer($user);

            if (!empty($customer->subscriptions->data)) {

                $newSubscription = $customer->subscriptions->data[0];

                if (Plan::$rolePlans[$newSubscription->plan->id] !== $user->plan_id) {
                    $user->stripe_subscription_id = $newSubscription->id;
                    self::changePlan($user, Plan::$rolePlans[$newSubscription->plan->id]);
                }

                $stripeSubscription = StripeService::getSubscription($user);

            } else {
                $message = StripeService::getMessage(StripeService::MESSAGE_SUBSCRIPTION_STATUS_CANCELED);
            }

        } elseif ($stripeSubscription->cancel_at_period_end) {
            $date = date('jS F Y', $stripeSubscription->current_period_end);
            $message = StripeService::getMessage(StripeService::MESSAGE_SUBSCRIPTION_STATUS_ACCESS_END) . $date . '.';
        }

        return [
            'success' => $success,
            'message' => $message,
            'subscription' => $stripeSubscription,
        ];
    }

    /**
     * function for testing
     * @param $subscriptionId
     * @return string
     * @throws \Throwable
     */
    public static function endTrialPeriod($subscriptionId)
    {
        if (!$subscriptionId) {
            /** @var User $user */
            $user = Yii::$app->user->getIdentity();
            if (!($subscriptionId = $user->stripe_subscription_id)) {
                return 'subscription id not found!';
            }
        }

        try {
            StripeService::setSecretApiKey();

            Subscription::update($subscriptionId, [
                'trial_end' => 'now',
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return 'success';
    }

}
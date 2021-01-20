<?php

namespace app\services\stripe;

use app\models\Agency;
use app\models\Plan as BasePlan;
use app\models\User;
use app\services\StripePostBackService;
use Stripe\Coupon;
use Stripe\Error\Base;
use Stripe\Plan;
use Stripe\Product;
use Stripe\Subscription;
use Yii;

trait TStripePlan
{
    /**
     * @param string $planId
     * @return bool|array
     */
    public static function getPlanDataByPlanId(string $planId)
    {
        $plans = BasePlan::$getPlans;
        return in_array($planId, $plans) ? $planId : false;
    }

    /**
     * @param User $user
     * @param $role
     * @param $planId
     * @return bool
     */
    public static function changePlan(User $user, $role)
    {
        $user = $user ?? \Yii::$app->user->identity;

        if (!self::changeRole($user, $role)) {
            return null;
        }

        $stripePlanId = array_flip(\app\models\Plan::$rolePlans)[$role];
        $user->plan_id = \app\models\Plan::$stripePlanIdToDbId[$stripePlanId] ?? null;

        $user->save();

        return true;
    }

    public static function changeRole(User $user, $role)
    {
        $user = $user ?? \Yii::$app->user->identity;

        try {

            $agency = Agency::findOne(['uid' => $user->id]);
            $oldAgencyType = $agency->agency_type;
            $agency->agency_type = $role;

            if (!$agency->save()) {
                return null;
            }

            // add plan
            $auth = Yii::$app->authManager;
            $oldRole = $auth->getRole($oldAgencyType);
            $newRole = $auth->getRole($role);

            if (!empty($newRole)) {
                $auth->revoke($oldRole, $user->id);
                $auth->assign($newRole, $user->id);

                // update api access_token
                if ($role === User::ROLE_RESELLER) {
                    $user->generateAccessToken();
                }
            }

        } catch (\Exception $e) {
            return null;
        }

        return true;
    }

    /**
     * @param BasePlan $dataPlan
     * @return Product $product
     */
    public static function getProduct(BasePlan $dataPlan)
    {
        try {
            /** @var Product $product */
            $product = Product::retrieve($dataPlan->product_name);

        } catch (Base $e) {

            $productData = [
                'id' => $dataPlan->product_name,
                'name' => $dataPlan->product_name,
                'type' => 'service',
            ];
            $product = Product::create($productData);
        }

        return $product;
    }

    /**
     * @param string $planId
     * @return Plan $plan
     */
    public static function getPlan($planId = BasePlan::PLAN_BASIC)
    {
        $data = BasePlan::findOne(['stripe_id' => $planId]);

        try {
            /** @var Plan $plan */
            $plan = Plan::retrieve($planId);

        } catch (Base $e) {

            $product = self::getProduct($data);

            $planeData = [
                'amount' => $data->amount,
                'currency' => $data->currency,
                'interval' => $data->interval,
                'trial_period_days' => 14,
                'id' => $planId,
                'product' => $product->id,
            ];
            $plan = Plan::create($planeData);
        }

        return $plan;
    }

    /**
     * @param $event
     */
    public static function planCreated($event)
    {
        $plan = new \app\models\Plan();
        $newPlan = $event->data->object;
        $plan->webhookSave($newPlan, $event);
    }

    /**
     * @param $event
     * @return bool
     */
    public static function planUpdated($event)
    {
        $plan = \app\models\Plan::findOne(['stripe_id' => $event->data->object->id]);

        if (isset($plan)) {
            $updatePlan = $event->data->object;
            $plan->webhookSave($updatePlan, $event);

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $event
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function planDeleted($event)
    {
        $plan = \app\models\Plan::findOne(['stripe_id' => $event->data->object->id]);
        if (isset($plan)) {
            StripePostBackService::logEventToFile($event, false);
            $plan->delete();
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $couponCode
     * @return Coupon|false
     *
     * @throws \Stripe\Error\Api
     */
    public static function retrieveCouponByCode(string $couponCode)
    {
        /** @var Coupon[] $coupons */
        $coupons = Coupon::all();

        $couponCode = strtoupper($couponCode);

        foreach ($coupons as $coupon) {
            if (strtoupper($coupon->id) === $couponCode || strtoupper($coupon->name) === $couponCode) {
                return $coupon;
            }
        }

        return false;
    }

    /**
     * @param $planId
     * @param $couponCode
     * @return float|int|mixed|null
     * @throws \Exception
     */
    public static function calcPlanPriceWithCoupon($planId, $couponCode)
    {
        /** @var BasePlan */
        $plan = BasePlan::findOne(['stripe_id' => $planId]);
        if (!$planId) {
            throw new \Exception(Yii::t('subscription', 'Plan not found.'));
        }

        if (!$couponCode) {
            return $plan->amount;
        }

        $coupon = self::retrieveCouponByCode($couponCode);

        if (!$coupon || !$coupon->valid) {
            throw new \Exception(Yii::t('subscription', 'Coupon Is Not Valid'));
        }

        $planAmount = (int) $plan->amount;

        if ($coupon->amount_off) {
            $newPrice = $planAmount - $coupon->amount_off;
        } else {
            $newPrice = $planAmount * ((100 - $coupon->percent_off) / 100);
        }

        return $newPrice;
    }

    public static function planIsAvailableToChoose($planId, Subscription $subscription = null, User $user = null)
    {
        if (Yii::$app->user->isGuest) {
            return true;
        }

        $user = $user ?? \Yii::$app->user->identity;

        if ($user->plan_id !== $planId) {
            return true;
        }

        if (empty($subscription)) {
            return true;
        }

        // @todo need to check this condition for truth e.g. why cancel_at_period_end ?
        if (
            !empty($subscription) &&
            $subscription->status !== Subscription::STATUS_CANCELED &&
            $subscription->cancel_at_period_end
        ) {
            return true;
        }

        return false;
    }

}
<?php

namespace app\services\stripe;

use app\models\Plan as BasePlan;
use app\models\User;
use Stripe\ApiResource;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Invoice;
use Stripe\InvoiceItem;
use Stripe\InvoiceLineItem;
use Stripe\Refund;
use Stripe\Subscription;
use Yii;

/**
 * Trait TStripeChangeSubscription
 * @package app\services\stripe
 *
 * Trait for only changeSubscription functionality
 */
trait TStripeChangeSubscription
{

    /**
     * @param User $user
     * @param string $planId
     * @return ApiResource
     * @throws \Exception
     */
    public static function changeSubscription(User $user, $planId = BasePlan::PLAN_BASIC)
    {
        $user = $user ?? Yii::$app->user->identity;
        $customer = self::_tcs_getCustomer($user);

        /** @var Subscription $subscription */
        $subscription = empty($customer->subscriptions->data) ? null : $customer->subscriptions->data[0];

        if (!$subscription || $subscription->status === Subscription::STATUS_CANCELED) {

            $stripeSubscription = self::_tcs_createSubscription($customer, $planId);

        } else {

            $prorationAmount = self::_tcs_calclProrationAmountForNewPlan($user, $subscription, $planId);

            // if $prorationAmount === 0 - subscription it trial period
            if ($prorationAmount > 0) {
                self::_tcs_upgradeSubscriptionInvoice($user, $prorationAmount);
            } elseif ($prorationAmount < 0) {
                self::_tcs_downgradeSubscriptionRefund($user, $prorationAmount);
            }

            $stripeSubscription = self::_tcs_updateSubscription($subscription, $planId);
        }

        $user->stripe_subscription_id = $stripeSubscription->id;
        $user->plan_id = BasePlan::$stripePlanIdToDbId[$planId];
        $user->save();

        return $stripeSubscription;
    }

    private static function _tcs_getCustomer(User $user): Customer
    {
        $customer = null;
        if ($user->stripe_customer_id) {
            $customer = Customer::retrieve($user->stripe_customer_id);

            if ($customer->isDeleted()) {
                $customer = null;
            }
        }

        if (empty($customer) || $customer['deleted']) {
            throw new \Exception(Yii::t('error', 'Customer is not found. Please register.'));
        }

        return $customer;
    }

    private static function _tcs_createSubscription(Customer $customer, string $planId): Subscription
    {
        $subscriptionData = [
            'customer' => $customer->id,
            'prorate' => false,
            'items' => [
                [
                    'plan' => $planId,
                ],
            ],
            'cancel_at_period_end' => false,
            'trial_end' => 'now',
            'trial_from_plan' => false,
        ];

        return Subscription::create($subscriptionData);
    }

    private static function _tcs_updateSubscription(Subscription $subscription, $planId): Subscription
    {
        return Subscription::update($subscription->id, [
            'cancel_at_period_end' => false,
            'prorate' => false,
            'items' => [
                [
                    'id' => $subscription->items->data[0]->id,
                    'plan' => $planId,
                ],
            ],
        ]);
    }

    private static function _tcs_upgradeSubscriptionInvoice(User $user, int $prorationAmount)
    {
        InvoiceItem::create([
            'customer' => $user->stripe_customer_id,
            'amount' => $prorationAmount,
            'currency' => 'usd',
            'description' => 'Upgrade pricing plan.',
        ]);

        $prorationInvoice = Invoice::create([
            'customer' => $user->stripe_customer_id,
            'auto_advance' => false,
        ]);

        $prorationInvoice->finalizeInvoice();
        $invoice = $prorationInvoice->pay();

        if (!$invoice->paid) {
            throw new \Exception(Yii::t('error', 'Invoice was not paid'));
        }
    }

    private static function _tcs_downgradeSubscriptionRefund(User $user, int $prorationAmount)
    {
        $prorationAmount = abs($prorationAmount);

        $chargeList = Charge::all([
            'customer' => $user->stripe_customer_id,
            'limit' => 1,
        ]);

        /** @var Charge[] $chargeList */
        $chargeList = $chargeList->data;

        if (!empty($chargeList)) {
            /** @var Charge $charge */
            $charge = reset($chargeList);

            $prorationAmount = min($prorationAmount, $charge->amount);

            if ($charge->amount <= 0) {
                throw new \Exception(Yii::t('error', 'Charge found error (amount = [' . $charge->amount . ']).'));
            }

            $refund = Refund::create([
                'charge' => $charge->id,
                'amount' => $prorationAmount,
            ]);

        } else {
            throw new \Exception(Yii::t('error', 'Charge found error.'));
        }
    }

    private static function _tcs_calclProrationAmountForNewPlan(User $user, Subscription $subscription, string $newPlanId): int
    {
        Subscription::update($user->stripe_subscription_id, [
            'cancel_at_period_end' => false,
            'prorate' => false,
            'items' => [
                [
                    'id' => $subscription->items->data[0]->id,
                    'plan' => $subscription->plan->id,
                ],
            ],
        ]);

        $invoiceItems = [[
            'id' => $subscription->items->data[0]->id,
            'plan' => $newPlanId,
        ]];

        $upcomingInvoiceTime = time();

        // get preview invoices to calculate $prorationAmount
        $upcomingInvoice = Invoice::upcoming([
            'customer' => $user->stripe_customer_id,
            'subscription' => $user->stripe_subscription_id,
            'subscription_items' => $invoiceItems,
            'subscription_proration_date' => $upcomingInvoiceTime,
        ]);

        /** @var InvoiceLineItem[] $linesData */
        $linesData = $upcomingInvoice->lines->data;
        $linesData = array_filter($linesData, function (InvoiceLineItem $invoiceLineItem) use ($upcomingInvoiceTime) {
            return $invoiceLineItem->period->start === $upcomingInvoiceTime;
        });

        $prorationAmount = 0;

        foreach ($linesData as $item) {
            $prorationAmount += $item->amount;
        }

        return $prorationAmount;
    }

}
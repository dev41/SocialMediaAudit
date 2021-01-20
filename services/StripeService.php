<?php

namespace app\services;

use app\models\User;
use app\services\stripe\TStripeChangeSubscription;
use app\services\stripe\TStripeCard;
use app\services\stripe\TStripeCustomer;
use app\services\stripe\TStripeInvoice;
use app\services\stripe\TStripeKeys;
use app\services\stripe\TStripePlan;
use app\services\stripe\TStripeSubscription;
use Stripe\Event;
use Stripe\Subscription;
use Yii;

class StripeService
{
    use TStripeSubscription;
    use TStripeChangeSubscription;
    use TStripeKeys;
    use TStripePlan;
    use TStripeInvoice;
    use TStripeCustomer;
    use TStripeCard;

    const ACTIVE_SUBSCRIPTION_STATUSES = [
        Subscription::STATUS_ACTIVE,
        Subscription::STATUS_TRIALING,
    ];

    const UNPAID_SUBSCRIPTION_STATUSES = [
        Subscription::STATUS_PAST_DUE,
        Subscription::STATUS_INCOMPLETE,
        Subscription::STATUS_INCOMPLETE_EXPIRED,
        Subscription::STATUS_UNPAID,
    ];

    const MESSAGE_SUBSCRIPTION_STATUS_FAIL = 'You subscription is over, unpaid or incomplete. You access permissions are limited.';
    const MESSAGE_SUBSCRIPTION_STATUS_ACCESS_END = 'Your subscription has been canceled but you will retain access until the end of the period on ';
    const MESSAGE_SUBSCRIPTION_STATUS_CANCELED = 'You subscription is canceled by the administrator.';
    const MESSAGE_SUBSCRIPTION_STATUS_PAST_DUE = 'You have an attempted payment which failed. Please pay this immediately to regain access.';

    public static function getMessage($message)
    {
        return Yii::t('app', $message);
    }

    /**
     * @param $event
     * @return User
     * @throws \Exception
     */
    public static function getUserModel($event)
    {
        /** @var User $user */
        try {
            if ($event->type === Event::INVOICE_MARKED_UNCOLLECTIBLE) {
                $sub = $event->data->object->subscription;
                $user = User::findOne(['stripe_subscription_id' => $sub]);
            } else {
                $cus = $event->data->object->customer;
                $user = User::findOne(['stripe_customer_id' => $cus]);
            }
        } catch (\Exception $e) {
            throw new \Exception(\Yii::t('error', 'Subscription is already exist.'));
        }

        return $user;
    }
}
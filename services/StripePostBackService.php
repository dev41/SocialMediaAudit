<?php

namespace app\services;

use app\models\Plan;
use app\models\User;
use Stripe\Event;
use Stripe\Subscription;

class StripePostBackService
{
    /**
     * @param $event
     * @throws \Exception
     */
    public static function paymentFailed($event)
    {
        $user = StripeService::getUserModel($event);
        StripeService::changePlan($user, User::ROLE_FREE);
    }

    /**
     * @param $event
     * @throws \Exception
     */
    public static function paymentSucceeded($event)
    {
        /** @var User $user */
        $user = StripeService::getUserModel($event);
        /** @var Subscription $subscription */
        $subscription = StripeService::getSubscription($user);
        $role = Plan::$rolePlans[$subscription->plan->id];

        StripeService::changePlan($user, $role);
    }

    /**
     * @param $event
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function webhookProcessEvent($event)
    {
//        self::logEventToFile($event);

        switch ($event->type) {

//            case Event::INVOICE_PAYMENT_SUCCEEDED:
//
//                self::paymentSucceeded($event);
//
//                break;
//
//            case Event::INVOICE_MARKED_UNCOLLECTIBLE:
//            case Event::INVOICE_PAYMENT_FAILED:
//
//                self::paymentFailed($event);
//
//                break;

            case Event::CUSTOMER_SUBSCRIPTION_CREATED:

                StripeService::subscriptionCreate($event);

                break;

            case Event::CUSTOMER_SUBSCRIPTION_UPDATED:

                StripeService::subscriptionUpdate($event);

                break;

            case Event::CUSTOMER_SUBSCRIPTION_DELETED:
                StripeService::deleteSubscription($event);

                break;

//            case Event::CUSTOMER_SOURCE_DELETED:
//
//                StripeService::cardDeleted($event);
//
//                break;

            case Event::PLAN_CREATED:

                StripeService::planCreated($event);

                break;

            case Event::PLAN_UPDATED:

                if (!StripeService::planUpdated($event)) {
                    return false;
                }

                break;

            case Event::PLAN_DELETED:

                if (!StripeService::planDeleted($event)) {
                    return false;
                }

                break;
        }

        return true;
    }

    /**
     * @param Event $event
     * @param bool $onlyForDev
     * @param string $fileName
     */
    public static function logEventToFile($event, $onlyForDev = true, $fileName = 'events.txt')
    {
        if ($onlyForDev && $_SERVER['HTTP_HOST'] !== 'socialmediaaudit.loc') {
            return;
        }

//        if (!empty($event->data->object->customer) && $event->data->object->customer !== 'cus_FG5VobBxmPSHhI') {
//            return;
//        }

        $path = \Yii::getAlias('@app') . '/' . $fileName;

        $debugText = str_repeat('-', 80) . PHP_EOL;
        $debugText .= 'TIME: ' . date('H:i:s', time() + 3*60*60) . PHP_EOL;
        $debugText .= 'TYPE: ' .  $event->type . PHP_EOL . PHP_EOL;
        $debugText .= json_encode($event, JSON_PRETTY_PRINT) . PHP_EOL;
        $debugText .= str_repeat('-', 80) . PHP_EOL . PHP_EOL;

        file_put_contents($path, $debugText, FILE_APPEND);
    }

}
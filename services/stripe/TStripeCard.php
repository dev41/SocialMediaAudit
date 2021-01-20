<?php

namespace app\services\stripe;

use app\models\User;
use Stripe\Card;
use Stripe\Customer;
use Yii;

trait TStripeCard
{
    /**
     * @param User $user
     * @return array|\Stripe\StripeObject
     */
    public static function getCard(User $user)
    {
        $user = $user ?? Yii::$app->user->identity;

        $customer = Customer::retrieve($user->stripe_customer_id);

        $defaultSource = $customer->default_source;

        if (!$defaultSource) {
            return null;
        }

        $sources = array_combine(
            array_column($customer->sources->data, 'id'),
            $customer->sources->data
        );

        return $sources[$defaultSource];
    }

    /**
     * @param User $user
     * @param array $token
     * @throws \Exception
     * @return bool
     */
    public static function changeCard(User $user, array $token = [])
    {
        $tokenId = $token['id'];

        if (!$user->stripe_customer_id) {
            return false;
        }

        /** @var Customer $customer */
        $customer = Customer::retrieve($user->stripe_customer_id);

        if (!$customer) {
            throw new \Exception(Yii::t('error', 'Customer is already exist.'));
        }

        /*
         * Stripe API: https://stripe.com/docs/api/cards/delete?lang=php
         * If you delete a card that is currently the default source,
         * then the most recently added source will become the new default.
         */

        /** @var Card $source */
        foreach ($customer->sources->data as $source) {
            Customer::deleteSource($user->stripe_customer_id, $source->id);
        }

        $customer->sources->create([
            'source' => $tokenId,
        ]);

        $customer->updateAttributes(
            self::getCustomerAddress($user, Yii::$app->request->post('User'))
        );
        $customer->save();

        return true;
    }

}
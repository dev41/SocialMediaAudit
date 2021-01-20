<?php

namespace app\services\stripe;

use app\models\User;
use app\services\StripeService;
use Stripe\ApiResource;
use Stripe\Customer;
use Stripe\StripeObject;
use Yii;

trait TStripeCustomer
{
    /**
     * @param User $user
     * @param bool $createIfNotExist
     * @return Customer
     */
    public static function getCustomer(User $user, $createIfNotExist = false)
    {
        $user = $user ?? Yii::$app->user->identity;

        try {
            $customer = Customer::retrieve($user->stripe_customer_id);
        } catch (\Exception $e) {
            if ($createIfNotExist) {
                return self::createCustomer($user);
            }

            return null;
        }

        return $customer;
    }

    public static function getBillingAddress(array $address): array
    {
        return [
            'city' => $address['city'] ?? '',
            'country' => $address['country'] ?? '',
            'postal_code' => $address['zip_code'] ?? '',
            'state' => $address['state'] ?? '',
            'line1' => $address['address'] ?? '',
        ];
    }

    public static function getCustomerAddress(User $user, array $address = null): array
    {
        if (empty($address)) {
            return [
                'shipping' => null,
            ];
        }

        $userName = $user->first_name;

        if ($user->last_name) {
            $userName .= ' ' . $user->last_name;
        }

        $billingAddress = self::getBillingAddress($address);

        return [
            'address' => $billingAddress,
            'shipping' => [
                'name' => $userName,
                'address' => $billingAddress,
            ],
        ];
    }

    public static function getCustomerDataByUser(User $user): array
    {
        $description = isset($user->agency) ? $user->agency->company_name : '';

        return [
            'name' => $user->getFullName(),
            'description' => $description,
            'email' => $user->email,
        ];
    }

    /**
     * @param User $user
     * @return ApiResource|false
     */
    public static function updateCustomer(User $user)
    {
        return $user->stripe_customer_id ? Customer::update($user->stripe_customer_id, self::getCustomerDataByUser($user)) : false;
    }

    public static function createCustomer(User $user, array $token = null): StripeObject
    {
        $customer = null;
        $customerAddress = self::getCustomerAddress($user, Yii::$app->request->post('User'));

        if ($user->stripe_customer_id) {
            $customer = Customer::retrieve($user->stripe_customer_id);

            if ($customer->isDeleted()) {
                $customer = null;
            } else {

                if (!empty($token)) {
                    StripeService::changeCard($user, $token);
                }

                return $customer;
            }
        }

        if (empty($customer) || $customer['deleted']) {

            $customerData = array_merge(
                self::getCustomerDataByUser($user),
                $customerAddress
            );

            if (!empty($token['id'])) {
                $customerData['source'] = $token['id'];
            }

            $customer = Customer::create($customerData);

            $user->stripe_customer_id = $customer->id;
            $user->save(false);
        }

        return $customer;
    }

}
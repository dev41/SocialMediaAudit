<?php

namespace app\services\stripe;

use Stripe\Stripe;
use Yii;

trait TStripeKeys
{
    public static function setSecretApiKey()
    {
        $secretKey = Yii::$app->params['stripe']['secret_key'];
        Stripe::setApiKey($secretKey);
    }

    public static function isTestKeys()
    {
        $secretKey = Yii::$app->params['stripe']['secret_key'];
        return strpos($secretKey, 'live') === false;
    }
}
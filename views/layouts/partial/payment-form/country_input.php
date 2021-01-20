<?php

use app\helpers\BaseHelper;
use app\models\Country;
use Stripe\Card;
use yii\helpers\Html;

/**
 * @var Card $card
 */

$card = $card ?? null;
$countries = Country::getAll();
$userCountryCode = BaseHelper::getUserCountryCode($card);
?>

<div class="col-xs-12 col-sm-6 col-md-4">
    <label><?= \Yii::t('app', 'Country'); ?></label>
    <div class="input-select">
        <?= Html::dropDownList('User[country]', $userCountryCode, $countries, ['class' => 'js-user-country', 'id' => 'country']) ?>
    </div>
</div>
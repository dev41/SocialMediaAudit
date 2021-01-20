<?php

use app\helpers\BaseHelper;
use app\models\Country;
use app\models\State;
use Stripe\Card;
use yii\web\View;

/**
 * @var View $this
 * @var Card $card
 */

$card = $card ?? null;
$states = State::getAll();
$countries = Country::getAll();
$city = BaseHelper::getCityByUserIp();

$userCountryCode = BaseHelper::getUserCountryCode($card);

if (!empty($userCountryCode)) {
    $statesList = $states[$userCountryCode] ?? null;
}

if (!empty($card->address_state)) {

    $userStateCode = $card->address_state;

} elseif (!empty($city->mostSpecificSubdivision->isoCode)) {

    if (
        is_array($statesList) &&
        in_array($city->mostSpecificSubdivision->isoCode, array_keys($statesList))
    ) {
        $userStateCode = $city->mostSpecificSubdivision->isoCode;
    }
}

BaseHelper::addJSData('states', $states);
?>

<div class="col-xs-12 col-sm-6 col-md-4">
    <label><?= \Yii::t('app', 'State / County'); ?></label>

    <?php if (!empty($statesList)): ?>

        <div class="input-select js-field-state">
            <select id="state" name="User[state]" class="js-user-state">

                <?php foreach ($statesList as $code => $name) {
                    if ($userStateCode && $code === $userStateCode) {
                        echo "<option selected value='" . $code . "'>" . $name . "</option>";
                    } else {
                        echo "<option value='" . $code . "'>" . $name . "</option>";
                    }
                } ?>

            </select>
        </div>

    <?php else: ?>

        <div class="js-field-state">
            <?= $this->render('state_input_element', ['value' => $userStateCode]); ?>
        </div>

    <?php endif; ?>

</div>

<script class="js-state-input-template" type="text/template">
    <?= $this->render('state_input_element'); ?>
</script>
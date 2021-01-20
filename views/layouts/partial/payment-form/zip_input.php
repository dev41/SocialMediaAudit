<?php

use Stripe\Card;
use yii\web\View;

/**
 * @var View $this
 * @var Card $card
 */
?>

<div class="col-xs-12 col-sm-6 col-md-4">
    <label><?= \Yii::t('app', 'Postcode / Zipcode'); ?></label>
    <input class="input-field js-stripe-card-zip"
           id="user-zip_code"
           name="User[zip_code]"
           aria-label="ZIP"
           placeholder="ZIP"
           aria-placeholder="ZIP"
           aria-invalid="false"
           maxlength="12"
           type="text"
           value="<?= $card->address_zip ?? '' ?>">
</div>
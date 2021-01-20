<?php

use Stripe\Card;

/**
 * @var Card $card
 */

?>

<div class="col-xs-12 col-sm-4">
    <label><?= \Yii::t('app', 'City'); ?></label>
    <input class="input-field js-stripe-card-city" id="user-city" maxlength="25"
           name="User[city]" placeholder="<?= \Yii::t('app', 'City'); ?>"
           type="text"
           value="<?= $card->address_city ?? '' ?>">
</div>
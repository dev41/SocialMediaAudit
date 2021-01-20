<?php

use Stripe\Card;

/**
 * @var Card $card
 */

?>

<div class="col-xs-12 col-sm-8">
    <label><?= \Yii::t('app', 'Address'); ?></label>
    <input class="input-field js-stripe-card-address" id="user-address" maxlength="150"
           name="User[address]" placeholder="<?= \Yii::t('app', 'Address'); ?>"
           type="text" value="<?= $card->address_line1 ?? '' ?>">
</div>
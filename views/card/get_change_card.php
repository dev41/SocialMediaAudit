<?php

use app\models\Country;
use app\models\State;
use yii\helpers\Html;
use app\helpers\BaseHelper;

/* @var $this yii\web\View */
/* @var $model \app\models\User */
/* @var $card Stripe\Card */
?>

<!-- cancel subscription modal -->

<div class="modal-content">
    <form action="<?= Yii::$app->urlManager->createUrl('/user-change-card') ?>"
          data-user-full-name="<?= $model->fullName ?>"
          data-stripe-public-key="<?= \Yii::$app->params['stripe']['public_key'] ?>"
          class="js-stripe-change-card-form change-card-form">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><strong><?= \Yii::t('app', 'Change Card'); ?></strong></h4>
        </div>
        <div class="modal-body">

            <div class="js-container-alert-change-card"></div>

            <div class="js-stripe-process-spinner " style="display:none">
                <svg class="loader" style="position: absolute">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#i-loader"></use>
                </svg>
            </div>

            <input type="hidden" name="token"/>

            <div class="row">

                <?= $this->render('/layouts/partial/payment-form/card_number_input'); ?>

                <?= $this->render('/layouts/partial/payment-form/expiry_date_input'); ?>

                <?= $this->render('/layouts/partial/payment-form/cvc_input'); ?>

                <?= $this->render('/layouts/partial/payment-form/address_input', [
                    'card' => $card,
                ]); ?>

                <?= $this->render('/layouts/partial/payment-form/city_input', [
                    'card' => $card,
                ]); ?>

                <?= $this->render('/layouts/partial/payment-form/country_input', [
                    'card' => $card,
                ]); ?>

                <?= $this->render('/layouts/partial/payment-form/state_input', [
                    'card' => $card,
                ]); ?>

                <?= $this->render('/layouts/partial/payment-form/zip_input', [
                    'card' => $card,
                ]); ?>

            </div>

        </div>
        <div class="modal-footer" style="padding-top: 0; border-top: none;">
            <div class="submit-loader-box">
                <button type="submit"
                        class="btn btn-danger js-change-card-submit"><?= \Yii::t('app', 'Save'); ?></button>
                <button type="button" class="btn btn--primary"
                        data-dismiss="modal"><?= \Yii::t('app', 'Close'); ?></button>
            </div>
        </div>
    </form>
</div>

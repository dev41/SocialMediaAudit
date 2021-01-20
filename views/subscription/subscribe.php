<?php

use app\models\Country;
use app\models\Plan;
use app\models\State;
use yii\helpers\Html;
use app\helpers\BaseHelper;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $user app\models\User */
/* @var $plan string */

$this->title = 'Create new user';
?>
    <script src="https://js.stripe.com/v3/"></script>
    <div id="wrapper">
        <div class="main-container">
            <section class="height-100">

                <div class="container cart-customer-details">

                    <div class="col-md-4 col-sm-4 js-amount-container" id="first_block" style="float: right">

                        <div class="col-md-12 m-0 ">
                            <div class="js-amount-container-alert"></div>

                            <div class="account-settings-loading js-amount-process-spinner">
                                <div class="account-settings-loading-center">
                                            <span class="loading-center-loader is-visible">
                                                <svg class="loader"><use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         xlink:href="#i-loader"></use></svg>
                                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="boxed boxed--border">
                            <h3 class="m-t-0 header-title"><?= Plan::findOne(['stripe_id' => $plan])->name ?></h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <span> <?= \Yii::t('app', 'Get started with a 14 day free trial.'); ?> </span>
                                    <br>
                                    <br>
                                    <h3 class="color--primary">
                                        <strong><?= \Yii::t('app', '$0'); ?> </strong> /
                                        <?= \Yii::t('app', '14 Day Free Trial'); ?>
                                    </h3>
                                    <hr>
                                    <span>
                                    Renews at <span class="js-subscription-price">$<?= Plan::getAmount($plan) ?></span> / <?= \Yii::t('app', 'month'); ?>
                                    </span>
                                    <p class="js-applied-coupon-info"></p>
                                </div>
                            </div>
                        </div>
                        <div class="js-coupon-container m-b-30"
                             data-url="<?= Yii::$app->urlManager->createUrl('/coupon/' . $plan) ?>">
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" class="input-field js-stripe-coupon" name="coupon_code"
                                           placeholder="<?= \Yii::t('app', 'Coupon Code'); ?>">
                                </div>

                                <div class="col-xs-6">
                                    <button type="button" class="btn btn-coupon-code js-btn-test-coupon"
                                            style="width: 100%;">
                                        <small><?= \Yii::t('app', 'Apply'); ?></small>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 col-sm-8">
                        <div class="boxed boxed--border">
                            <form action="<?= Yii::$app->urlManager->createUrl('/subscribe/' . $plan); ?>"

                                  data-user-full-name="<?= $user->fullName ?>"
                                  data-stripe-public-key="<?= \Yii::$app->params['stripe']['public_key'] ?>"
                                  data-plan-id="<?= $plan ?>"
                                  data-plan-price="<?= Plan::getAmount($plan) ?>"
                                  method="POST"
                                  class="js-subscription-form subscription-form">

                                <input type="hidden" name="token"/>

                                <div class="col-xs-12 col-md-12 text-center m-0">
                                    <h2><?= Yii::t('app', 'Credit Card Details') ?></h2>
                                </div>

                                <div class="row">

                                    <div class="col-xs-12 col-md-12 m-0 ">
                                        <?= \app\helpers\FormHelper::stackErrorSummary($user); ?>
                                        <div class="js-container-alert"></div>

                                        <div class="account-settings-loading js-stripe-process-spinner">
                                            <div class="account-settings-loading-center">
                                            <span class="loading-center-loader is-visible">
                                                <svg class="loader"><use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         xlink:href="#i-loader"></use></svg>
                                            </span>
                                            </div>
                                        </div>
                                    </div>

                                    <?= $this->render('/layouts/partial/payment-form/card_number_input'); ?>

                                    <?= $this->render('/layouts/partial/payment-form/expiry_date_input'); ?>

                                    <?= $this->render('/layouts/partial/payment-form/cvc_input'); ?>

                                    <?= $this->render('/layouts/partial/payment-form/address_input'); ?>

                                    <?= $this->render('/layouts/partial/payment-form/city_input'); ?>

                                    <?= $this->render('/layouts/partial/payment-form/country_input'); ?>

                                    <?= $this->render('/layouts/partial/payment-form/state_input'); ?>

                                    <?= $this->render('/layouts/partial/payment-form/zip_input'); ?>

                                    <?= $this->render('/layouts/partial/payment-form/tc_checkbox'); ?>

                                </div>

                                <button type="button"
                                        class="btn btn--primary background--warning pull-left subscribe-submit js-btn-process">
                                    <?= \Yii::t('app', 'Start Free Trial'); ?>
                                </button>

                                <div class="clearfix"></div>

                            </form>

                            <div>
                                <div class="js-stripe-msg-complete display-settings-box-item-text"></div>
                            </div>

                        </div>
                    </div>

                </div>

            </section>
        </div>
    </div>
<?= $this->render('/layouts/alert_template') ?>
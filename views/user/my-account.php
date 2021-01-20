<?php

use app\components\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model \app\models\UserCancelForm */
/* @var $user \app\models\User */

$this->title = 'My Account';
$user = Yii::$app->user->identity;

?>
    <script src="https://js.stripe.com/v3/"></script>
    <h1 class="m-t-0"><?= \Yii::t('app', 'My Accoun'); ?>t</h1>

    <p class="m-b-20"><?= \Yii::t('app', 'Here are information and options in regards to your account.'); ?></p>

    <div class="js-my-account-container">

        <?= Alert::widget() ?>
        <div class="js-container-alert"></div>

        <div class="row">
            <div class="col-md-6 my-account-page-section">
                <div class="boxed boxed--border js-subscription-container">

                    <div class="col-md-12">
                        <h3 class="m-t-0 m-b-5 header-title pull-left">
                            <?= \Yii::t('app', 'Subscription'); ?>
                        </h3>
                    </div>

                    <div class="js-stripe-process-spinner " style="display:none">
                        <svg class="loader" style="position: absolute">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#i-loader"></use>
                        </svg>
                    </div>

                    <div class="row js-subscription-body">
                        <div class="col-xs-12">
                            <div class="js-cancel-subscription-alert"></div>
                        </div>
                        <?php if (isset($user->plan)): ?>
                            <div class="m-b-20 col-xs-12 js-subscription-plan" style="display: none">
                                <div>
                                    <strong><?= \Yii::t('app', 'Current Subscription') ?></strong>
                                </div>
                                <div>
                                    <h3 class="m-b-0 color--primary"><?= $user->plan->name ?></h3>
                                </div>
                                <div>
                                <span class="js-trial-msg"
                                      style="display: none"><?= \Yii::t('app', 'Trial period (2 weeks)') ?></span>
                                </div>
                                <div>
                                    (<span data-name="sub-current_period_start"></span> -
                                    <span data-name="sub-current_period_end"></span>)
                                </div>

                            </div>
                        <?php else: ?>
                            <div class="m-b-20 col-sm-6 col-xs-12">
                                <strong><?= \Yii::t('app', 'No Subscription'); ?></strong><br>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="js-isset-subscription" style="display: none">
                        <a href="/plan" class="btn btn--primary js-button-change-plan">
                        <span class="btn__text">
                            <?= Yii::t('app', 'Change Plan') ?>
                        </span>
                        </a>

                        <button type="button"
                                data-toggle="modal"
                                data-target="#cancelSub"
                                class="btn btn--primary js-cancel-subscription-btn">
                        <span class="">
                            <?= Yii::t('app', 'Cancel Subscription') ?>
                        </span>
                        </button>
                    </div>

                    <div class="js-reactivate-subscription" style="display: none">
                        <button type="button"
                                class="btn btn--primary pull-left m-r-3 js-reactivate-subscription-btn">
                        <span class="">
                            <?= Yii::t('app', 'Reactivate') ?>
                        </span>
                        </button>
                    </div>

                    <div class="js-add-subscription" style="display: none">
                        <a href="/plan" class="btn btn--primary background--warning">
                            <span class="btn__text">
                                <?= Yii::t('app', 'Choose Plan') ?>
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 my-account-page-section ">
                <?php if ($user->stripe_subscription_id): ?>
                    <div class="boxed boxed--border js-billing-container">

                        <div class="col-md-12">
                            <h3 class="m-t-0 m-b-5 header-title pull-left">
                                <?= \Yii::t('app', 'Billing'); ?>
                            </h3>
                        </div>

                        <div class="js-stripe-process-spinner" style="display:none">
                            <svg class="loader" style="position: absolute">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#i-loader"></use>
                            </svg>
                        </div>

                        <div class="row js-stripe-card-body" style="display: none">
                            <div class="m-b-20 col-sm-6 col-xs-12">
                                <strong><?= \Yii::t('app', 'Card Number'); ?></strong><br>
                                <span>**** **** **** </span>
                                <span data-name="card-last4"> </span> (<span data-name="card-brand"> </span>)
                            </div>
                            <div class="m-b-20 col-sm-6 col-xs-12">
                                <strong><?= \Yii::t('app', 'Expires'); ?></strong><br>
                                <span data-name="card-exp_month"></span>/<span data-name="card-exp_year"> </span>
                            </div>
                            <div class="m-b-20 col-sm-12 col-xs-12">
                                <strong><?= \Yii::t('app', 'Billing address'); ?></strong><br>

                                <div class="js-address-info"></div>
                            </div>
                        </div>

                        <div class="row js-stripe-no-card" style="display: none">
                            <div class="m-b-20 col-sm-6 col-xs-12">
                                <strong><?= \Yii::t('app', 'No Credit Card'); ?></strong>
                            </div>
                        </div>

                        <button type="button"
                                data-target="#modal"
                                data-action="user-get-change-card/<?= $user->id ?>"
                                class="btn btn--primary js-change-card-btn" style="display: none">
                         <span class="">
                             <?= Yii::t('app', 'Change Credit Card') ?>
                         </span>
                        </button>

                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 my-account-page-section">
                <div class="boxed boxed--border js-profile-container">

                    <div class="col-md-12">
                        <h3 class="m-t-0 m-b-5 header-title pull-left">
                            <?= \Yii::t('app', 'Profile'); ?>
                        </h3>
                    </div>

                    <div class="js-stripe-process-spinner " style="display:none">
                        <svg class="loader" style="position: absolute">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#i-loader"></use>
                        </svg>
                    </div>

                    <div class="row js-profile-body">
                        <div class="m-b-20 col-sm-6 col-xs-12">
                            <strong><?= \Yii::t('app', 'Full Name'); ?></strong><br>
                            <span data-name="user-first_name"><?= $user->first_name ?></span> <span
                                    data-name="user-last_name"><?= $user->last_name ?></span>
                        </div>
                        <div class="m-b-20 col-sm-6 col-xs-12">
                            <strong><?= \Yii::t('app', 'Email'); ?></strong><br>
                            <span data-name="user-email"><?= $user->email ?></>
                        </div>
                        <div class="m-b-20 col-sm-6 col-xs-12">
                            <strong><?= \Yii::t('app', 'Company Name'); ?></strong><br>
                            <span data-name="agency-company_name"><?= (!isset($user->agency) || empty($user->agency->company_name)) ? "N/a" : $user->agency->company_name ?>
                        </div>
                    </div>

                    <button type="button"
                            data-target="#modal"
                            data-action="user-get-update-profile/<?= $user->id ?>"
                            class="btn btn--primary js-update-profile-btn">
                     <span class="">
                         <?= Yii::t('app', 'Update Details') ?>
                     </span>
                    </button>
                    <button type="button"
                            data-target="#modal"
                            data-action="user-get-change-password/<?= $user->id ?>"
                            class="btn btn--primary js-change-password-btn">
                     <span class="">
                         <?= Yii::t('app', 'Change Password') ?>
                     </span>
                    </button>
                </div>
            </div>
        </div>

        <?php if ($user->stripe_customer_id): ?>
            <div class="row">
                <div class="col-md-12 my-account-page-section">
                    <div class="boxed boxed--border js-stripe-billing-history">
                        <div class="col-md-12">
                            <h3 class="m-t-0 header-title">
                                <?= \Yii::t('app', 'Billing History'); ?>
                            </h3>
                        </div>

                        <div class="js-stripe-process-spinner " style="display:none">
                            <svg class="loader" style="position: absolute">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#i-loader"></use>
                            </svg>
                        </div>

                        <div class="js-stripe-billing-history-body" style="display: none">
                            <table class="js-table-body billing-history-table scrollable-table-content datatable-buttons border--round table--alternate-row m-b-0">
                                <thead>
                                <tr>
                                    <th class="dynamic"><?= \Yii::t('app', 'Invoice Number'); ?></th>
                                    <th class="dynamic"><?= \Yii::t('app', 'Date'); ?></th>
                                    <th class="dynamic"><?= \Yii::t('app', 'Amount'); ?></th>
                                    <th class="dynamic"><?= \Yii::t('app', 'Status'); ?></th>
                                    <th class="dynamic"><?= \Yii::t('app', 'PDF Invoice'); ?></th>
                                    <th class="dynamic"></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?= $this->render('modal/cancel_subscription', ['model' => $user]) ?>
        <?= $this->render('/layouts/alert_template') ?>
        <?php
        yii\bootstrap\Modal::begin([
            'id' => 'modal',
            'size' => 'modal-md',
            'options' => [
                'autofocus' => false,
            ],
        ]);
        ?>
        <div id='modal-content'>
            <div class="js-stripe-process-spinner">
                <svg class="loader" style="position: absolute">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#i-loader"></use>
                </svg>
            </div>
        </div>
        <?php yii\bootstrap\Modal::end(); ?>
        <?= $user->access_token_label ?>

<?php
$this->registerJsFile('/js/plugins/datatables/jquery.dataTables.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/datatables/dataTables.bootstrap.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/datatables/dataTables.buttons.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/datatables/buttons.bootstrap.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/datatables/vfs_fonts.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/datatables/buttons.html5.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/pages/datatables.init.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/ladda-buttons/js/spin.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/ladda-buttons/js/ladda.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/ladda-buttons/js/ladda.jquery.min.js', ['depends' => 'yii\web\JqueryAsset']);
?>
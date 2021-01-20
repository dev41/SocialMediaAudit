<?php

use app\helpers\BaseHelper;
use yii\helpers\Url;
use app\models\Plan;
use Stripe\Subscription;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $user \app\models\User */
/* @var $planBasic Plan */
/* @var $planAdvanced Plan */
/* @var $subscription Stripe\Subscription */

$this->title = 'Plan & Pricing';

$this->registerJsFile('js/dist/routes/plan.js', [
    'depends' => ['yii\web\JqueryAsset'],
]);
BaseHelper::addJSData('user', $user->toArray());
?>

<?= $this->render('/layouts/partial/_confirm_dialog') ?>

<div id="wrapper">
    <div class="main-container">
        <section class="height-100">

            <div class="container pos-vertical-center">

                <?= $this->render('partial/_plans', [
                    'user' => $user,
                    'planBasic' => $planBasic,
                    'planAdvanced' => $planAdvanced,
                    'subscription' => $subscription,
                ]) ?>

            </div>

        </section>
    </div>
</div>

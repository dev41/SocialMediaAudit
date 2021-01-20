<?php

use app\models\Plan;
use app\models\User;
use app\services\StripeService;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var User $user
 * @var Plan $planBasic
 * @var Plan $planAdvanced
 * @var bool $prefill
 * @var Stripe\Subscription $subscription
 */

$prefill = $prefill ?? false;
$basicPlanIsAvailable = StripeService::planIsAvailableToChoose($planBasic->id, $subscription ?? null);
$advancePlanIsAvailable = StripeService::planIsAvailableToChoose($planAdvanced->id, $subscription ?? null);

$planUrl = Url::to(['/plan']);

?>

<div class="row">

    <div class="col-xs-12 text-center">
        <h2><?= Yii::t('app', 'Get Started Now') ?></h2>
    </div>

    <div class="col-md-offset-2 col-md-4 col-sm-offset-0 col-sm-6 col-xs-12
        <?= $basicPlanIsAvailable ? : 'disabled' ?> ">
        <div class="pricing boxed boxed--lg boxed--border">
            <h3><?= $planBasic->name ?></h3>
            <p class="plan-description">Unlimited Social Media Audits</p>
            <span>
                <strong class="h2">$<?= Plan::getAmount($planBasic->stripe_id) ?></strong>
                <?= \Yii::t('app', 'Per Month'); ?>.
            </span>
            <br>

            <hr>

            <?= $this->render('_basic_description_plan') ?>

            <?= $this->render('_advanced_description_plan', [
                    'planType' => 'basic'
            ]) ?>

            <form action="<?= $planUrl ?>" id="form-plan-base" method="post"
                  style="position: initial;">
                <input type="hidden" name="SignupForm[agency_type]" value="<?= Plan::PLAN_BASIC ?>"/>
                <input type="hidden" name="planId" value="<?= Plan::PLAN_BASIC ?>"/>
                <input type="hidden" name="prefill" value="<?= $prefill ?>"/>
                <input type="submit"
                       title="<?= isset($user->plan_id) ? 'Purchase Plan' : 'Free Trial' ?>"
                       class="btn btn--primary m-t-0"
                       value="<?= !empty($subscription) ? (($subscription->cancel_at_period_end && !empty($user->plan_id) && $user->plan_id === $planBasic->id) ? 'Reactivate' : 'Purchase Plan') : 'Free Trial' ?>"/>
            </form>
        </div>
    </div>

    <div class="col-md-4 col-sm-offset-0 col-sm-6 col-xs-12
    <?= $advancePlanIsAvailable ? : 'disabled' ?>">
        <div class="pricing  boxed boxed--lg boxed--border">
                <h3 class="m-r-15"><?= $planAdvanced->name ?></h3>
            <p class="plan-description">Unlimited Social Media Audits</p>
            <span>
                <strong class="h2">$<?= Plan::getAmount($planAdvanced->stripe_id) ?></strong>
                <?= \Yii::t('app', 'Per Month'); ?>.
            </span>
            <br>

            <hr>

            <?= $this->render('_basic_description_plan') ?>

            <?= $this->render('_advanced_description_plan', [
                    'planType' => 'advanced'
            ]) ?>

            <form action="<?= $planUrl ?>" id="form-plan-advanced" method="post"
                  style="position: initial;">
                <input type="hidden" name="SignupForm[agency_type]" value="<?= Plan::PLAN_ADVANCED ?>"/>
                <input type="hidden" name="planId" value="<?= Plan::PLAN_ADVANCED ?>"/>
                <input type="hidden" name="prefill" value="<?= $prefill ?>"/>
                <input type="submit"
                       title="<?= isset($user->plan_id) ? 'Purchase Plan' : 'Free Trial' ?>"
                       class="btn btn--primary background--warning m-t-0"
                       value="<?= !empty($subscription) ? (($subscription->cancel_at_period_end && !empty($user->plan_id) && $user->plan_id === $planAdvanced->id) ? 'Reactivate' : 'Purchase Plan') : 'Free Trial' ?>"/>
            </form>
        </div>

    </div>

</div>
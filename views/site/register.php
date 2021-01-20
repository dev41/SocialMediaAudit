<?php

use app\helpers\FormHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;
use app\components\widgets\Alert;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\SignupForm */

$this->title = 'Create new user';
$model->email_user = app\models\SignupForm::SEND_MAIL;
$this->registerJsFile('js/dist/routes/register.js', [
    'depends' => ['yii\web\JqueryAsset'],
]);
?>

<div id="wrapper">
    <div class="main-container">
        <section class="imageblock switchable feature-large height-100">
            <div class="imageblock__content col-lg-6 col-md-4 col-sm-4 pos-right background-color-green">
                <div class="image-holder">
                    <img s src="../../img/social-media-audit-shape-logo.png">
                </div>
            </div>
            <div class="container pos-vertical-center register-form-content">
                <div class="row">
                    <div class="col-lg-5 col-md-7 col-sm-8 col-xs-12">
                        <div class="col-xs-12 p-l-30 p-r-30">
                            <div class="register-form-title">
                                <h2><?= Yii::t('app', 'Create User') ?></h2>
                            </div>

                            <?php $form = ActiveForm::begin([
                                'id' => 'register-form',
                                'options' => [
                                    'class' => 'register-form',
                                ],
                            ]); ?>

                            <div class="row">
                                <div class="col-xs-12">
                                    <?= Alert::widget() ?>
                                    <?= FormHelper::stackErrorSummary($model); ?>
                                </div>

                                <div class="col-xs-12 col-sm-6">
                                    <label><?= \Yii::t('app', 'First Name'); ?> </label>
                                    <?= $form->field($model, 'first_name')->textInput([
                                        'autofocus' => true,
                                        'placeholder' => 'First Name',
                                        'tabindex' => 1,
                                        'class' => 'form-control m-b-0'
                                    ])->label(false) ?>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <label><?= \Yii::t('app', 'Last Name'); ?> </label>
                                    <?= $form->field($model, 'last_name')->textInput([
                                        'autofocus' => true,
                                        'placeholder' => 'Last Name',
                                        'tabindex' => 2,
                                        'class' => 'form-control m-b-0'
                                    ])->label(false) ?>
                                </div>
                                <div class="col-xs-12">
                                    <label><?= \Yii::t('app', 'Email'); ?> </label>
                                    <?= $form->field($model, 'email')->input('email', [
                                        'placeholder' => 'Email',
                                        'tabindex' => 3,
                                        'class' => 'form-control m-b-0'])
                                        ->label(false) ?>
                                </div>

                                <?php if (Yii::$app->user->can(User::ROLE_ADMIN)): ?>
                                    <div class="col-xs-12">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <label><?= \Yii::t('app', 'Password'); ?> </label>
                                            </div>
                                            <div class="col-sm-7 col-xs-12">
                                                <?= $form->field($model, 'password')->passwordInput([
                                                    'placeholder' => 'Password',
                                                    'id' => 'password',
                                                    'tabindex' => 4,
                                                    'class' => 'js-field-password'
                                                ])->label(false) ?>
                                            </div>

                                            <div class="col-sm-5 col-xs-12">
                                                <div type="button"
                                                     class="btn btn--primary width100 js-auto-generate-btn"
                                                     tabindex="5">
                                                    <span class="btn__text"><?= Yii::t('app', 'AutoGenerate') ?></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-xs-12">
                                        <?= FormHelper::stackCheckbox($model, 'email_user', [
                                            'tabindex' => 6,
                                            'value' => 1,
                                            'checked' => false,
                                        ]) ?>
                                    </div>

                                <?php else: ?>

                                    <div class="col-xs-12">
                                        <label><?= \Yii::t('app', 'Password'); ?> </label>
                                        <?= $form->field($model, 'password')->passwordInput([
                                            'placeholder' => 'Password',
                                            'id' => 'password',
                                            'tabindex' => 4,
                                        ])->label(false) ?>
                                    </div>

                                    <div class="col-xs-12">
                                        <?= FormHelper::stackCheckbox($model, 'acceptedNewsSubscription', [
                                            'label' => $model->attributeLabels()['accepted'],
                                            'tabindex' => 7,
                                            'value' => 1,
                                            'checked' => false,
                                        ]) ?>
                                    </div>

                                <?php endif; ?>


                                <div class="col-xs-12">
                                    <?= Html::submitButton('Next', ['class' => 'btn btn--primary text-uppercase width100', 'tabindex' => 7,]) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

</div>

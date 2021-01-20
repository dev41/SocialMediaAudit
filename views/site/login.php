<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'SocialMediaAudit - Login to your Account';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Login on this page to access your Account Dashboard giving access to functions such as download White Label PDFs',
]);
?>
<div id="wrapper">
    <div class="main-container">
        <section class="imageblock switchable feature-large height-100">
            <div class="imageblock__content col-lg-6 col-md-4 col-sm-4 pos-right background-color-green">
                <div class="image-holder">
                    <img  src="../../img/social-media-audit-shape-logo.png">
                </div>
            </div>
            <div class="container pos-vertical-center login-form-content">
                <div class="row">
                    <div class="col-lg-5 col-md-7 col-sm-8 col-xs-12">
                        <div class="col-xs-12 p-l-30 p-r-30">
                            <div class="login-form-title">
                                <h2>Login to Social Media Audit</h2>
                                <p class="lead">Get started with a 14 day free trial, No credit card required — cancel at any time.</p>
                            </div>
                            <?php $form = ActiveForm::begin([
                                'options' => [
                                    'class' => 'login-form',
                                ],
                                'fieldConfig' => [
                                    'template' => '{input}{hint}{error}',
                                ],
                            ]); ?>
                            <div class="row">
                                <div class="col-xs-12">
                                    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'Email Address')]) ?>
                                </div>
                                <div class="col-xs-12">
                                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Password')]) ?>
                                </div>
                                <div class="col-xs-12">
                                    <div class="input-checkbox">
                                        <input id="rememberMe" type="checkbox" value="1" name="<?= Html::getInputName($model, 'rememberMe') ?>" />
                                        <label for="rememberMe"></label>
                                    </div>
                                    <span><?= Yii::t('app', $model->getAttributeLabel('rememberMe')) ?></span>
                                </div>
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn--primary type--uppercase width100"><?= Yii::t('app', 'Login') ?></button>
                                </div>
                                <div class="col-xs-12">
                                    <a href="/reset-password" class="text-dark">
                                        <i class="fa fa-lock m-r-5"></i>
                                        Forgot your password?
                                    </a>
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

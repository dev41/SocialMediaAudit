<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\PasswordResetRequestForm */
/* @var $message string */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request of new password';
?>
<div class="wrapper-page">
    <div class=" card-box">
        <?php if ( \Yii::$app->request->isMainDomain() ) { ?>
            <div class="panel-heading">
                <div class="panel_logo"></div>
            </div>
        <?php } ?>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'text-center',
                ],
            ]) ?>
            <?php if (empty($message)){ ?>
                <h3 class="text-center"> Reset Password </h3>
                <p>Please enter your account <b>email</b> address to receive password reset instructions</p>
                <div class="form-group m-b-0">
                    <?= $form->field($model, 'email')->input('email')->label(false) ?>
                    <?= Html::submitButton('Reset', ["class" => "btn btn--primary width100"]) ?>
                </div>
            <?php } else { ?>
                <br>
                <p><?= $message ?></p>
            <?php } ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>

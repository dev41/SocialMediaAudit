<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ResetPasswordForm */
/* @var $success boolean */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Set new password';
?>
<div class="wrapper-page">
	<div class="card-box">
        <?php if ( \Yii::$app->request->isMainDomain() ) { ?>
            <div class="panel-heading">
                <a href="/">
                    <div class="panel_logo"></div>
                </a>    
            </div>
        <?php } ?>
		<div class="panel-body">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'text-center',
                ],
            ]) ?>
            <?php if ($success) { ?>
                <p>Password Successfully Reset</p>
                <p class="m-t-20"><a href="/login" class="btn btn--primary" title='Login'>Login</a></p>
            <?php } else { ?>
                <h3 class="text-center"> Set New Password </h3>
                <p>Please enter a new secure password.</p>
                <div class="form-group m-b-0" style="margin-top:40px;">
                    <div class="input-group">
                        <?= Html::passwordInput('ResetPasswordForm[password]', null, [
                            'class' => 'form-control',
                        ]) ?>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn--primary w-sm waves-effect waves-light">Set New Password</button>
                        </span>
                    </div>
                    <?= Html::error($model, 'password') ?>
                </div>
            <?php } ?>
            <?php ActiveForm::end() ?>
		</div>
	</div>
</div>

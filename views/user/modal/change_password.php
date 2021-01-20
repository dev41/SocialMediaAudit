<?php

use yii\bootstrap\ActiveForm;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model \app\models\User */
/* @var $user \app\models\User */
/* @var $agency \app\models\Agency */

$model->scenario = User::SCENARIO_CHANGE_PASSWORD;

?>
<!-- cancel subscription modal -->

<div class="modal-content">
    <?php $form = ActiveForm::begin([
        'action' => '/user-change-password/' . $model->id,
        'options' => [
            'class' => "js-change-password-form"
        ]
    ]) ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><strong><?= \Yii::t('app', 'Change Password'); ?></strong>
        </h4>
    </div>
    <div class="modal-body">

        <div class="js-container-alert-profile"></div>

        <div class="js-stripe-process-spinner " style="display:none">
            <svg class="loader" style="position: absolute">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#i-loader"></use>
            </svg>
        </div>

        <div class="row">

            <div class="col-xs-12">
                <label><?= \Yii::t('app', 'New Password'); ?> </label>
                <?= $form->field($model, 'new_password')->passwordInput([
                    'placeholder' => 'New Password',
                    'tabindex' => 1,
                    'class' => 'm-b-0'
                ])->label(false) ?>
            </div>
            <div class="col-xs-12">
                <label><?= \Yii::t('app', 'Confirm Password'); ?> </label>
                <?= $form->field($model, 'confirm_password')->passwordInput([
                    'placeholder' => 'Confirm Password',
                    'tabindex' => 2,
                    'class' => 'm-b-0'
                ])->label(false) ?>
            </div>

        </div>

    </div>
    <div class="modal-footer" style="padding-top: 0; border-top: none;">
        <div class="submit-loader-box">
            <button type="submit"
                    class="btn btn-danger js-change-password-submit"><?= \Yii::t('app', 'Save'); ?></button>
            <button type="button" class="btn btn--primary"
                    data-dismiss="modal"><?= \Yii::t('app', 'Close'); ?></button>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>

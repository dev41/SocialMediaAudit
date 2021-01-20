<?php

use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\models\User */
/* @var $agency \app\models\Agency */

?>
<!-- cancel subscription modal -->

<div class="modal-content">
    <?php $form = ActiveForm::begin([
        'action' => '/user-update-profile/' . $model->id,
        'options' => [
            'class' => "js-update-profile-form",
            'method' => 'post'
        ]
    ]) ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><strong><?= \Yii::t('app', 'Update Profile'); ?></strong></h4>
    </div>
    <div class="modal-body">

        <div class="js-container-alert-profile"></div>

        <div class="js-stripe-process-spinner " style="display:none">
            <svg class="loader" style="position: absolute">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#i-loader"></use>
            </svg>
        </div>

        <input type="hidden" name="token"/>

        <div class="row">

            <div class="col-xs-12">
                <label><?= \Yii::t('app', 'First Name'); ?> </label>
                <?= $form->field($model, 'first_name')->textInput([
                    'placeholder' => 'First Name',
                    'tabindex' => 1,
                    'class' => 'm-b-0',
                    'autofocus' => true,
                ])->label(false) ?>
            </div>
            <div class="col-xs-12">
                <label><?= \Yii::t('app', 'Last Name'); ?> </label>
                <?= $form->field($model, 'last_name')->textInput([
                    'placeholder' => 'Last Name',
                    'tabindex' => 2,
                    'class' => 'm-b-0'
                ])->label(false) ?>
            </div>
            <div class="col-xs-12">
                <label><?= \Yii::t('app', 'Email'); ?> </label>
                <?= $form->field($model, 'email')->textInput([
                    'placeholder' => 'Email',
                    'tabindex' => 3,
                    'class' => 'm-b-0'
                ])->label(false) ?>
            </div>

            <div class="col-xs-12">
                <label><?= \Yii::t('app', 'Company Name'); ?> </label>
                <?= $form->field($agency, 'company_name')->textInput([
                    'placeholder' => 'Company Name',
                    'tabindex' => 4,
                    'class' => 'm-b-0'
                ])->label(false) ?>
            </div>

        </div>

    </div>
    <div class="modal-footer" style="padding-top: 0; border-top: none;">
        <div class="submit-loader-box">
            <button type="submit"
                    class="btn btn-danger js-update-profile-submit"><?= \Yii::t('app', 'Save'); ?></button>
            <button type="button" class="btn btn--primary"
                    data-dismiss="modal"><?= \Yii::t('app', 'Close'); ?></button>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>

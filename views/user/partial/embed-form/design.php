<?php

use app\helpers\FormHelper;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model \app\models\EmbeddingForm */
?>

<!--Choose Your Fields-->
<div class="boxed boxed--border"?>
    <h3 class="m-t-0 header-title"><?= Yii::t('app', 'Embed Form Design') ?></h3>
    <div class="row m-b-15">
        <div class="col-md-12">
            <label><?= Yii::t('app', 'Choose Your Fields') ?>:</label>

            <?= Html::hiddenInput('EmbeddingForm[embed_enable_email]', 0) ?>
            <?= Html::hiddenInput('EmbeddingForm[embed_enable_phone]', 0) ?>
            <?= Html::hiddenInput('EmbeddingForm[embed_enable_first_name]', 0) ?>
            <?= Html::hiddenInput('EmbeddingForm[embed_enable_last_name]', 0) ?>
            <?= Html::hiddenInput('EmbeddingForm[embed_enable_custom_field]', 0) ?>
            <?= Html::hiddenInput('EmbeddingForm[embed_enable_consent]', 0) ?>

            <div>
                <div class="m-r-15 inline-block">
                    <?= FormHelper::stackCheckbox(
                        $model,
                        'embed_enable_email',
                        [
                            'label' => 'Email',
                            'value' => 1,
                            'class' => 'enable-field',
                        ]
                    ) ?>
                </div>
                <div class="m-r-15 inline-block">
                    <?= FormHelper::stackCheckbox(
                        $model,
                        'embed_enable_phone',
                        [
                            'label' => 'Phone',
                            'value' => 1,
                            'class' => 'enable-field',
                        ]
                    ) ?>
                </div>
                <div class="m-r-15 inline-block">
                    <?= FormHelper::stackCheckbox(
                        $model,
                        'embed_enable_first_name',
                        [
                            'label' => 'First Name',
                            'value' => 1,
                        ]
                    ) ?>
                </div>
                <div class="m-r-15 inline-block">
                    <?= FormHelper::stackCheckbox(
                        $model,
                        'embed_enable_last_name',
                        [
                            'label' => 'Last Name',
                            'value' => 1,
                        ]
                    ) ?>
                </div>
                <div class="m-r-15 inline-block">
                    <?= FormHelper::stackCheckbox(
                        $model,
                        'embed_enable_custom_field',
                        [
                            'label' => 'Custom Field',
                            'value' => 1,
                            'class' => 'enable-field',
                            'data-target' => '#custom-field-value',
                        ]
                    ) ?>
                </div>
                <div class="m-r-15 inline-block">
                    <?= FormHelper::stackCheckbox(
                        $model,
                        'embed_enable_consent',
                        [
                            'label' => 'GDPR Opt In Checkbox',
                            'value' => 1,
                            'class' => 'enable-field',
                            'data-target' => '#consent-value',
                        ]
                    ) ?>
                </div>
                <?= Html::error($model, 'embed_enable_email', ['class' => "errorMessage m-b-0"]) ?>
                <?= Html::error($model, 'embed_enable_phone', ['class' => "errorMessage m-b-0"]) ?>
                <?= Html::error($model, 'embed_enable_first_name', ['class' => "errorMessage m-b-0"]) ?>
                <?= Html::error($model, 'embed_enable_last_name', ['class' => "errorMessage m-b-0"]) ?>
                <?= Html::error($model, 'embed_enable_custom_field', ['class' => "errorMessage m-b-0"]) ?>
                <?= Html::error($model, 'embed_enable_consent', ['class' => "errorMessage m-b-0"]) ?>
            </div>
        </div>
    </div>

    <div class="row m-b-15" id="custom-field-value">
        <div class="col-md-5 col-sm-6">
            <label><?= Yii::t('app', 'Custom Field Title') ?>:</label>
            <?= Html::activeTextInput($model, 'embed_custom_field', ['class' => "form-control", "placeholder" => "Your Custom Field"]) ?>
            <?= Html::error($model, 'embed_custom_field', ['class' => "errorMessage"]) ?>
        </div>
    </div>

    <div class="row m-b-15" id="consent-value">
        <div class="col-md-5 col-sm-6">
            <label><?= Yii::t('app', 'Consent Title') ?>:</label>
            <?= Html::activeTextInput($model, 'embed_consent', ['class' => "form-control", "placeholder" => "Your Custom Field", 'id' => 'embed_consent_value']) ?>
            <?= Html::error($model, 'embed_consent', ['class' => "errorMessage"]) ?>
        </div>
    </div>

    <!--Choose Form Type-->

    <div class="row m-b-15">
        <div class="col-md-12">
            <label><?= Yii::t('app', 'Choose Your Form Type') ?>:</label>
            <?= Html::activeHiddenInput($model, 'embed_form_type') ?>

            <div class="radio-btn-group">
                <div class="radio-btn">
                    <?= FormHelper::stackRadio(
                        $model,
                        'embed_form_type',
                        'row_large',
                        [
                            'label' => 'Large Row',
                            'id' => 'embed-form-type-row-large',
                        ]
                    ) ?>
                </div>
                <div class="radio-btn">
                    <?= FormHelper::stackRadio(
                        $model,
                        'embed_form_type',
                        'row_slim',
                        [
                            'label' => 'Slim Row',
                            'id' => 'embed-form-type-row-slim',
                        ]
                    ) ?>
                </div>
                <div class="radio-btn">
                    <?= FormHelper::stackRadio(
                        $model,
                        'embed_form_type',
                        'column_large',
                        [
                            'label' => 'Large Column',
                            'id' => 'embed-form-type-column-large',
                        ]
                    ) ?>
                </div>
                <div class="radio-btn">
                    <?= FormHelper::stackRadio(
                        $model,
                        'embed_form_type',
                        'column_slim',
                        [
                            'label' => 'Slim Column',
                            'id' => 'embed-form-type-column-slim',
                        ]
                    ) ?>
                </div>
            </div>

            <?= Html::error($model, 'embed_form_type', ['class' => "errorMessage"]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <label><?= Yii::t('app', 'Choose Your Colors') ?>:</label>
            <div class="row f-s-12">
                <div class="col-xs-6 col-sm-4 col-lg-2">
                    <span>Button Color</span>
                    <?= Html::activeTextInput($model, 'embed_color_btn', ['class' => "form-control colorpicker-default embed-color-btn", "placeholder" => "#25b36f"]) ?>
                    <?= Html::error($model, 'embed_color_btn', ['class' => "errorMessage embed-color-btn-error"]) ?>
                </div>
                <div class="col-xs-6 col-sm-4 col-lg-2">
                    <span>Button Text Color</span>
                    <?= Html::activeTextInput($model, 'embed_color_btn_text', ['class' => "form-control colorpicker-default embed-color-btn-text", "placeholder" => "#ffffff"]) ?>
                    <?= Html::error($model, 'embed_color_btn_text', ['class' => "errorMessage embed-color-btn-error"]) ?>
                </div>
                <div class="col-xs-6 col-sm-4 col-lg-2">
                    <span>Field Text Color</span>
                    <?= Html::activeTextInput($model, 'embed_color_text', ['class' => "form-control colorpicker-default embed-color-text", "placeholder" => "#565656"]) ?>
                    <?= Html::error($model, 'embed_color_text', ['class' => "errorMessage embed-color-btn-error"]) ?>
                </div>
                <div class="col-xs-6 col-sm-4 col-lg-2">
                    <span>Field Borders Color</span>
                    <?= Html::activeTextInput($model, 'embed_color_field_borders', ['class' => "form-control colorpicker-default embed-color-field-borders", "placeholder" => "#e3e3e3"]) ?>
                    <?= Html::error($model, 'embed_color_field_borders', ['class' => "errorMessage embed-color-btn-error"]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
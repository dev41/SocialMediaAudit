<?php

use app\helpers\FormHelper;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model \app\models\EmbeddingForm */
?>
<div class="boxed boxed--border"?>
    <h3 class="m-t-0 header-title"><?= Yii::t('app', 'Embed Form Behaviour') ?></h3>
    <div class="row m-b-15">
        <div class="col-md-12">
            <label><?= Yii::t('app', 'Choose Your Form Behaviour:') ?></label>
            <?= Html::activeHiddenInput($model, 'embed_behaviour') ?>

            <div class="radio-btn-group">
                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'embed_behaviour', 'new_tab', [
                        'title' => 'Generate Report in New Tab',
                        'label' => 'New Tab',
                        'class' => 'enable-field',
                        'data-target' => '#embed-report-type-value',
                    ]); ?>
                </div>

                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'embed_behaviour', 'modal', [
                        'title' => 'Generate Report Within Your Website as Modal Box',
                        'label' => 'Modal Box',
                        'class' => 'enable-field',
                        'data-target' => '#embed-button-value, #embed-report-type-value',
                    ]); ?>
                </div>

                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'embed_behaviour', 'be_in_touch', [
                        'title' => 'Don’t Show Report - Only ‘We’ll be in touch’ message',
                        'label' => '"We\'ll be in touch" Popup Message',
                        'class' => 'enable-field',
                        'data-target' => '#intouch-message-value',
                    ]); ?>
                </div>

                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'embed_behaviour', 'redirect', [
                        'title' => 'Redirect to target URL',
                        'label' => 'Redirect to Another Page',
                        'class' => 'enable-field',
                        'data-target' => '#embed-redirect-url-value',
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row m-b-15" id="intouch-message-value">
        <div class="col-md-5 col-sm-6">
            <label><?= Yii::t('app', 'We’ll be in touch message:') ?></label>
            <?= Html::activeTextInput($model, 'embed_intouch_message',
                [
                    'class' => 'form-control',
                    'placeholder' => 'Thank you for requesting a report. We\'ll be in touch shortly!',
                    'value' => 'Thank you for requesting a report. We\'ll be in touch shortly!',
                ]
            ) ?>
            <?= Html::error($model, 'embed_intouch_message', ['class' => "errorMessage"]) ?>
        </div>
    </div>

    <div class="row m-b-15" id="embed-redirect-url-value">
        <div class="col-md-5 col-sm-6">
            <label><?= Yii::t('app', 'Redirect URL:') ?></label>
            <?= Html::activeTextInput($model, 'embed_redirect_url', ['class' => "form-control", "placeholder" => "https://yousite.com/page"]) ?>
            <?= Html::error($model, 'embed_redirect_url', ['class' => "errorMessage"]) ?>
        </div>
    </div>

    <div id="embed-button-value">
        <div class="row m-b-15">
            <div class="col-md-12">
                <label><?= Yii::t('app', 'Call to Action Button:') ?></label>
                <?= Html::activeHiddenInput($model, 'embed_enable_button') ?>

                <div class="radio-btn-group">
                    <div class="radio-btn">
                        <?= FormHelper::stackRadio($model, 'embed_enable_button', false, [
                            'label' => 'Hide',
                            'class' => 'enable-field',
                            'id' => 'embed-hide-button',
                        ]) ?>
                    </div>

                    <div class="radio-btn">
                        <?= FormHelper::stackRadio($model, 'embed_enable_button', true, [
                            'label' => 'Show',
                            'class' => 'enable-field',
                            'id' => 'embed-show-button',
                            'data-target' => '#embed-button-fields',
                        ]) ?>
                    </div>
                </div>

                <?= Html::error($model, 'embed_enable_button', ['class' => "errorMessage"]) ?>
            </div>
        </div>

        <div id="embed-button-fields">
            <div class="row m-b-15">
                <div class="col-md-5 col-sm-6">
                    <label><?= Yii::t('app', 'Button Label:') ?></label>
                    <?= Html::activeTextInput($model, 'embed_button_text', ['class' => "form-control", "placeholder" => "Your Button Title"]) ?>
                    <?= Html::error($model, 'embed_button_text', ['class' => "errorMessage"]) ?>
                </div>
            </div>
            <div class="row m-b-15">
                <div class="col-md-5 col-sm-6">
                    <label><?= Yii::t('app', 'Button Destination URL:') ?></label>
                    <?= Html::activeTextInput($model, 'embed_button_url', ['class' => "form-control", "placeholder" => "https://yousite.com/page"]) ?>
                    <?= Html::error($model, 'embed_button_url', ['class' => "errorMessage"]) ?>
                </div>
            </div>
        </div>
    </div>

    <div id="embed-report-type-value">
        <div class="row">
            <div class="col-md-12">
                <label><?= Yii::t('app', 'Choose Your Report Type:') ?></label>
                <?= Html::activeHiddenInput($model, 'embed_report_type') ?>

                <div class="radio-btn-group">
                    <div class="radio-btn">
                        <?= FormHelper::stackRadio($model, 'embed_report_type', 'pdf', [
                            'label' => 'PDF Report',
                        ]) ?>
                    </div>

                    <div class="radio-btn">
                        <?= FormHelper::stackRadio($model, 'embed_report_type', 'web', [
                            'label' => 'Web Report',
                        ]) ?>
                    </div>
                </div>

                <?= Html::error($model, 'embed_report_type', ['class' => "errorMessage"]) ?>
            </div>
        </div>
    </div>
</div>
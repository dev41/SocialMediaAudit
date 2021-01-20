<?php

use app\helpers\FormHelper;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model \app\models\EmbeddingForm */
?>
<div id="embed-email-customer" class="m-b-30">
    <div class="boxed boxed--border">
        <h3 class="m-t-0 header-title"><?= Yii::t('app', 'Customer Email Design') ?></h3>
        <div class="row m-b-15">
            <div class="col-md-5 col-sm-6 col-xs-12">
                <label><?= Yii::t('app', 'Email Subject Line') ?>:</label>
                <?= Html::activeTextInput($model, 'embed_email_subject', ['class' => "form-control", "placeholder" => "Your Subject"]) ?>
                <?= Html::error($model, 'embed_email_subject', ['class' => "errorMessage"]) ?>
            </div>
        </div>
        <div class="row m-b-15">
            <div class="col-md-5 col-sm-6 col-xs-12">
                <label><?= Yii::t('app', 'Email Title') ?>:</label>
                <?= Html::activeTextInput($model, 'embed_email_title', ['class' => "form-control", "placeholder" => "Your Title", 'id' => 'embed-email-title']) ?>
                <?= Html::error($model, 'embed_email_title', ['class' => "errorMessage"]) ?>
            </div>
        </div>
        <div class="row m-b-15">
            <div class="col-md-5 col-sm-6 col-xs-12">
                <label><?= Yii::t('app', 'Email Content') ?>:</label>
                <?= Html::activeTextarea($model, 'embed_email_content', [
                    'class' => "form-control",
                    "placeholder" => "Your Content",
                    'cols' => 60,
                    'id' => 'embed-email-content',
                ]) ?>
                <?= Html::error($model, 'embed_email_content', ['class' => "errorMessage"]) ?>
            </div>
        </div>
        <div class="row m-b-15">

            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6">
                <label><?= Yii::t('app', 'Header Font') ?></label>
                <div class="dropup">
                    <button class="btn btn-lg btn-white dropdown-toggle m-b-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="font-preview" style="font-family: '<?= $model->embed_email_header_font ?>';"><?= $model->embed_email_header_font ?></span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu fontlist" style="max-height: 200px; overflow-y: scroll;">
                        <?= $fontList; ?>
                    </ul>
                    <?= Html::hiddenInput('EmbeddingForm[embed_email_header_font]', $model->embed_email_header_font, array("class" => "hidden-input-font", 'id' => 'embed-email-header-font')) ?>
                </div>
                <?= Html::error($model, 'embed_email_header_font', ['class' => "errorMessage"]) ?>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6">
                <label><?= Yii::t('app', 'Body Font') ?></label>
                <div class="dropup">
                    <button class="btn btn-lg btn-white dropdown-toggle m-b-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="font-preview" style="font-family: '<?= $model->embed_email_body_font ?>';"><?= $model->embed_email_body_font ?></span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu fontlist" style="max-height: 200px; overflow-y: scroll;">
                        <?= $fontList; ?>
                    </ul>
                    <?= Html::hiddenInput('EmbeddingForm[embed_email_body_font]', $model->embed_email_body_font, array("class" => "hidden-input-font", 'id' => 'embed-email-body-font')) ?>
                </div>
                <?= Html::error($model, 'embed_email_body_font', ['class' => "errorMessage"]) ?>
            </div>
        </div>
        <div class="row m-b-15">
            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6">
                <label><?= Yii::t('app', 'Header Background Color') ?></label>
                <?= Html::activeTextInput($model, 'embed_email_header_background', ["class" => "colorpicker-email form-control embed-color-text", "placeholder" => "#33c68a", 'id' => 'embed-email-header-background']) ?>
                <?= Html::error($model, 'embed_email_header_background', ['class' => "errorMessage embed-color-btn-error"]) ?>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6">
                <label><?= Yii::t('app', 'Header Text Color') ?></label>
                <?= Html::activeTextInput($model, 'embed_email_header_color', ["class" => "colorpicker-email form-control embed-color-text", "placeholder" => "#ffffff", 'id' => 'embed-email-header-color']) ?>
                <?= Html::error($model, 'embed_email_header_color', ['class' => "errorMessage embed-color-btn-error"]) ?>
            </div>
        </div>
        <div class="row m-b-15">
            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6">
                <label><?= Yii::t('app', 'Body Background Color') ?></label>
                <?= Html::activeTextInput($model, 'embed_email_body_background', ["class" => "colorpicker-email form-control embed-color-text", "placeholder" => "#fdfdfd", 'id' => 'embed-email-body-background']) ?>
                <?= Html::error($model, 'embed_email_body_background', ['class' => "errorMessage embed-color-btn-error"]) ?>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6">
                <label><?= Yii::t('app', 'Body Text Color') ?></label>
                <?= Html::activeTextInput($model, 'embed_email_body_color', ["class" => "colorpicker-email form-control embed-color-text", "placeholder" => "#737373", 'id' => 'embed-email-body-color']) ?>
                <?= Html::error($model, 'embed_email_body_color', ['class' => "errorMessage embed-color-btn-error"]) ?>
            </div>
        </div>
        <div class="row m-b-15">
            <div class="col-md-5 col-sm-6">
                <label><?= Yii::t('app', 'Display Logo') ?>:</label>
                <?= Html::activeHiddenInput($model, 'embed_email_show_logo') ?>

                <div class="radio-btn-group">
                    <div class="radio-btn">
                        <?= FormHelper::stackRadio($model, 'embed_email_show_logo', false, [
                            'id' => 'embed-email-logo-hide',
                            'label' => 'Hide',
                        ]) ?>
                    </div>

                    <div class="radio-btn">
                        <?= FormHelper::stackRadio($model, 'embed_email_show_logo', true, [
                            'id' => 'embed-email-logo-show',
                            'label' => 'Show',
                        ]) ?>
                    </div>
                </div>

                <?= Html::error($model, 'embed_email_show_logo', ['class' => "errorMessage"]) ?>
            </div>
        </div>
    </div>

    <div class="boxed boxed--border">
        <?= $this->render('@app/mail/layouts/_content_layout', [
            'content' => 'content',
            'showLogo' => empty($model->company_logo) ? false : $model->embed_email_show_logo,
            'title' => Yii::t('app', 'Customer Email Preview'),
            'logoSrc' => $model->company_logo_url,
        ]) ?>
    </div>

</div>
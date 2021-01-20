<?php

use app\helpers\FormHelper;
use yii\bootstrap\Html;
use app\models\Agency;

/* @var $this yii\web\View */
/* @var $model \app\models\BrandingForm */
?>
<div class="boxed boxed--border">
    <h3 class="m-t-0 header-title"><?= Yii::t('app', 'Report Header') ?></h3>
    <div class="row m-b-15">
        <div class="col-md-5 col-sm-6 portlets">
            <label><?= Yii::t('app', 'Company Logo') ?></label>
            <div class="dropzone company-logo-dropzone" data-preload="<?= $model->company_logo ?>">
                <div class="fallback">
                    <input name="file" type="file" />
                </div>
            </div>
            <a href="#" style="margin-top: 10px;" class="btn btn--primary background--danger remove-company-logo btn btn-danger">
                <span class="btn__text">Remove Logo</span>
            </a>
        </div>

        <div id="error-remove-logo-container">
            <a href="#" onclick="window.location.reload(); return false;" style="margin-top: 10px;" class="btn btn-warning">
                Reload page
            </a>
            <span class="error lead">Error removing logo - please reload page</span>
        </div>
    </div>
    <div class="row m-b-15">
        <div class="col-md-5 col-sm-6">
            <label><?= Yii::t('app', 'Company Name') ?></label>
            <?= Html::activeTextInput($model, 'company_name', [
                'class' => "form-control",
                "placeholder" => "Company Name",
            ]) ?>
            <?= Html::error($model, 'company_name', [
                'class' => "errorMessage",
            ]) ?>
        </div>
    </div>
    <div class="row m-b-15">
        <div class="col-md-5 col-sm-6">
            <label><?= Yii::t('app', 'Company Address') ?></label>
            <?= Html::activeTextInput($model, 'company_address', [
                'class' => "form-control",
                "placeholder" => "Company Address",
            ]) ?>
            <?= Html::error($model, 'company_address', [
                'class' => "errorMessage",
            ]) ?>
        </div>
    </div>
    <div class="row m-b-15">
        <div class="col-md-5 col-sm-6">
            <label><?= Yii::t('app', 'Company Email') ?></label>
            <?= Html::activeTextInput($model, 'company_email', [
                'class' => "form-control",
                "placeholder" => "Company Email",
            ]) ?>
            <?= Html::error($model, 'company_email', [
                'class' => "errorMessage",
            ]) ?>
        </div>
    </div>
    <div class="row m-b-15">
        <div class="col-md-5 col-sm-6">
            <label><?= Yii::t('app', 'Company Phone') ?></label>
            <?= Html::activeTextInput($model, 'company_phone', [
                'class' => "form-control",
                "placeholder" => "Company Phone",
            ]) ?>
            <?= Html::error($model, 'company_phone', [
                'class' => "errorMessage",
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-sm-6">
            <label><?= Yii::t('app', 'Company Website') ?></label>
            <?= Html::activeTextInput($model, 'company_website', [
                'class' => "form-control",
                "placeholder" => "Company Website",
            ]) ?>
            <?= Html::error($model, 'company_website', [
                'class' => "errorMessage",
            ]) ?>
        </div>
    </div>
    <div class="row m-b-15">
        <div class="col-md-12">
            <div class="hint">
                The Company Website field will display in the top right of your White
                Label report. Additionally, it will become the link for your company logo in the
                report.
            </div>
        </div>
    </div>

    <div class="row m-b-15">
        <div class="col-md-12">
            <label><?= Yii::t('app', 'Report Title Text') ?></label>
            <?= Html::activeHiddenInput($model, 'show_title') ?>

            <div class="radio-btn-group">
                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'show_title', Agency::SHOW_TITLE_DEFAULT, [
                        'label' => 'Show with Default Title',
                    ]) ?>
                </div>

                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'show_title', Agency::SHOW_TITLE_CUSTOM, [
                        'label' => 'Show with Custom Title',
                    ]) ?>
                </div>

                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'show_title', Agency::SHOW_TITLE_HIDE, [
                        'label' => 'Hide',
                    ]) ?>
                </div>
            </div>

            <?= Html::error($model, 'show_title', ['class' => "errorMessage"]) ?>
            <div class="hint"<?= $model->custom_title? '' : ' style="display: none"' ?>>
                <div style="display: none" class="default-value">Website Report for [url]</div>
                <?= Html::activeTextarea($model, 'custom_title', ['class' => "form-control m-t-10", 'rows' => 5]) ?>
                <?= Html::error($model, 'custom_title', ['class' => "errorMessage"]) ?>
            </div>
        </div>
    </div>

    <div class="row m-b-15">
        <div class="col-md-12">
            <label><?= Yii::t('app', 'Introductory Paragraph') ?></label>
            <?= Html::activeHiddenInput($model, 'show_intro') ?>

            <div class="radio-btn-group">
                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'show_intro', Agency::SHOW_INTRO_DEFAULT, [
                        'label' => 'Show with Default Text',
                    ]) ?>
                </div>

                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'show_intro', Agency::SHOW_INTRO_CUSTOM, [
                        'label' => 'Show with Custom Text',
                    ]) ?>
                </div>

                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'show_intro', Agency::SHOW_INTRO_HIDE, [
                        'label' => 'Hide',
                    ]) ?>
                </div>
            </div>

            <?= Html::error($model, 'show_intro', ['class' => "errorMessage"]) ?>
            <div class="hint"<?= $model->custom_intro ? '' : ' style="display: none"' ?>>
                <div style="display: none" class="default-value">This report grades your website based on the strength of various SEO factors such as On Page Optimization, Off Page Links, Social and more. The overall Grade is on a A+ to F- scale, with most major, industry leading websites in the A range. Improving your grade will generally make your website perform better for users and rank better in search engines. There are recommendations for improving your website at the bottom of the report. Feel free to reach out to us if you’d like us to help with improving your website’s SEO!</div>
                <?= Html::activeTextarea($model, 'custom_intro', ['class' => "form-control m-t-10", 'rows' => 5]) ?>
                <?= Html::error($model, 'custom_intro', ['class' => "errorMessage"]) ?>
            </div>
        </div>
    </div>
</div>
<?php

use app\helpers\FormHelper;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model \app\models\BrandingForm */
?>
<div class="boxed boxed--border">

    <h3 class="m-t-0 header-title"><?= Yii::t('app', 'Colors') ?></h3>

    <div class="row m-b-15 display-hide">
        <div class="col-sm-4 col-md-4">
            <label><?= Yii::t('app', 'Background Color') ?></label>
            <?= Html::activeTextInput($model, 'background_color', ['class' => "form-control colorpicker-default", "placeholder" => "#ffffff"]) ?>
            <?= Html::error($model, 'background_color', ['class' => "errorMessage"]) ?>
        </div>
    </div>

    <div class="row m-b-15">
        <div class="col-sm-4 col-md-4">
            <label><?= Yii::t('app', 'Foreground Color') ?></label>

            <?= Html::hiddenInput('BrandingForm[foreground_color]', 0) ?>

            <div>
                <?= FormHelper::stackCheckbox($model, 'foreground_color', [
                    'value' => '',
                    'id' => 'default_fg',
                    'checked' => !$model->foreground_color,
                    'label' => 'Default',
                ]) ?>
            </div>
        </div>
        <div class="col-sm-4 col-md-2">
            <label><?= Yii::t('app', 'Custom Color') ?></label>
            <?= Html::activeTextInput($model, 'foreground_color', ['class' => "form-control colorpicker-default", "placeholder" => "#ffffff", 'id' => 'custom_fg']) ?>
            <?= Html::error($model, 'foreground_color', ['class' => "errorMessage"]) ?>
        </div>
    </div>

    <div class="row display-hide">
        <div class="col-md-12">
            <label><?= Yii::t('app', 'Section Headers Background Color') ?></label>
        </div>
        <div class="col-sm-4 col-md-4">
            <?= Html::activeTextInput($model, 'section_bgcolor', ['class' => "form-control colorpicker-default", "placeholder" => "#4c5667"]) ?>
            <?= Html::error($model, 'section_bgcolor', ['class' => "errorMessage"]) ?>
        </div>
    </div>

    <div class="row m-b-15">
        <div class="col-sm-4 col-md-4">
            <label><?= Yii::t('app', 'Section Headers Text Color') ?></label>

            <?= Html::hiddenInput('BrandingForm[section_fgcolor]', 0) ?>

            <div>
                <?= FormHelper::stackCheckbox($model, 'section_fgcolor', [
                    'value' => '',
                    'id' => 'default_section_fgcolor',
                    'checked' => !$model->section_fgcolor,
                    'label' => 'Default',
                ]) ?>
            </div>
        </div>
        <div class="col-sm-4 col-md-2">
            <label><?= Yii::t('app', 'Custom Color') ?></label>
            <?= Html::activeTextInput($model, 'section_fgcolor', ['class' => "form-control colorpicker-default", "placeholder" => "#ffffff", 'id' => 'custom_section_fgcolor']) ?>
            <?= Html::error($model, 'section_fgcolor', ['class' => "errorMessage"]) ?>
        </div>
    </div>

</div>
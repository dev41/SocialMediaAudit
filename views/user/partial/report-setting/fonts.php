<?php

use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model \app\models\BrandingForm */
?>
<div class="boxed boxed--border" style="overflow: unset;" ?>
    <h3 class="m-t-0 header-title"><?= Yii::t('app', 'Fonts') ?></h3>
    <div class="row m-b-15">
        <div class="col-md-12">
            <label><?= Yii::t('app', 'Header Font') ?></label>
            <div class="dropup">
                <button class="btn btn-lg btn-white dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span class="font-preview" style="font-family: '<?= $model->header_font ?>';"><?= $model->header_font ?></span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu fontlist" style="max-height: 200px; overflow-y: scroll;">
                    <?= $fontList ?>
                </ul>
                <?= Html::hiddenInput('BrandingForm[header_font]', $model->header_font, array("class" => "hidden-input-font")) ?>
            </div>
            <?= Html::error($model, 'header_font', ['class' => "errorMessage"]) ?>
        </div>
    </div>

    <div class="row m-b-15">
        <div class="col-md-12">
            <label><?= Yii::t('app', 'Body Font') ?></label>
            <div class="dropup">
                <button class="btn btn-lg btn-white dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span class="font-preview" style="font-family: '<?= $model->body_font ?>';"><?= $model->body_font ?></span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu fontlist" style="max-height: 200px; overflow-y: scroll;">
                    <?= $fontList; ?>
                </ul>
                <?= Html::hiddenInput('BrandingForm[body_font]', $model->body_font, array("class" => "hidden-input-font")) ?>
            </div>
            <?= Html::error($model, 'body_font', ['class' => "errorMessage"]) ?>
        </div>
    </div>
</div>
<div class="row m-b-15">
    <div class="col-md-12 text-center">
        <?= Html::submitButton('Save Settings', ["class" => "btn btn--primary width100"]) ?>
    </div>
</div>
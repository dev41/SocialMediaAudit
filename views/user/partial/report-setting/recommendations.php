<?php

use app\helpers\FormHelper;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model \app\models\BrandingForm */
?>
<div class="boxed boxed--border">
    <h3 class="m-t-0 header-title"><?= Yii::t('app', 'Recommendations') ?></h3>
    <div class="row m-t-15">
        <div class="col-md-12">
<!--            <label><?= Yii::t('app', 'Recommendations') ?></label>-->
            <?= Html::activeHiddenInput($model, 'show_recommendations') ?>

            <div class="radio-btn-group">
                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'show_recommendations', false, [
                        'label' => 'Hide',
                    ]) ?>
                </div>

                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'show_recommendations', true, [
                        'label' => 'Show',
                    ]) ?>
                </div>
            </div>

            <?= Html::error($model, 'show_recommendations', ['class' => "errorMessage"]) ?>
        </div>
    </div>
</div>
<?php

use app\helpers\FormHelper;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model \app\models\EmbeddingForm */
?>
<div class="boxed boxed--border"?>
    <h3 class="m-t-0 header-title"><?= Yii::t('app', 'Embed Form Email Settings') ?></h3>
    <div class="row m-b-15">
        <div class="col-md-12">
            <label><?= Yii::t('app', 'New Lead Emails') ?>:</label>
            <?= Html::activeHiddenInput($model, 'embed_email_new_leads') ?>

            <div class="radio-btn-group">
                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'embed_email_new_leads', false, [
                        'id' => 'embed-email-new-leads-hide',
                        'class' => 'enable-field',
                        'label' => 'Disabled',
                    ]) ?>
                </div>

                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'embed_email_new_leads', true, [
                        'id' => 'embed-email-new-leads-show',
                        'class' => 'enable-field',
                        'data-target' => '#embed-new-leads-email',
                        'label' => 'Enabled',
                    ]) ?>
                </div>
            </div>

            <?= Html::error($model, 'embed_email_new_leads', ['class' => "errorMessage"]) ?>
        </div>
    </div>

    <div class="row m-b-15" id="embed-new-leads-email">
        <div class="col-md-5 col-sm-6">
            <label><?= Yii::t('app', 'New Lead Destination Email Address') ?>:</label>
            <?= Html::activeTextInput($model, 'embed_email_address', ['class' => "form-control", "placeholder" => "Your email"]) ?>
            <?= Html::error($model, 'embed_email_address', ['class' => "errorMessage"]) ?>
        </div>
    </div>

    <div class="row m-b-15">
        <div class="col-md-12">
            <label><?= Yii::t('app', 'Email Customer a Confirmation Email') ?>:</label>
            <?= Html::activeHiddenInput($model, 'embed_email_customer') ?>

            <div class="radio-btn-group">
                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'embed_email_customer', false, [
                        'id' => 'embed-email-customer-hide',
                        'label' => 'Don’t Email Customer',
                        'class' => 'enable-field',
                    ]) ?>
                </div>

                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'embed_email_customer', true, [
                        'id' => 'embed-email-customer-show',
                        'label' => 'Email Customer',
                        'class' => 'enable-field',
                        'data-target' => '#embed-email-customer',
                    ]) ?>
                </div>
            </div>

            <?= Html::error($model, 'embed_email_customer', ['class' => "errorMessage"]) ?>
        </div>
    </div>

    <div class="row m-b-15">
        <div class="col-md-5 col-sm-6">
            <label>Include a PDF Copy of the Website Audit in the Email:</label>
            <?= Html::activeHiddenInput($model, 'embed_email_pdf') ?>

            <div class="radio-btn-group">
                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'embed_email_pdf', false, [
                        'id' => 'embed-email-pdf-hide',
                        'label' => 'Don’t Include',
                    ]) ?>
                </div>

                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'embed_email_pdf', true, [
                        'id' => 'embed-email-pdf-show',
                        'label' => 'Include',
                    ]) ?>
                </div>
            </div>

            <?= Html::error($model, 'embed_email_pdf', ['class' => "errorMessage"]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-sm-6">
            <label><?= Yii::t('app', 'Email Reply-To') ?>:</label>
            <?= Html::activeTextInput($model, 'embed_email_reply_to', ['class' => "form-control", "placeholder" => "Your Email"]) ?>
            <?= Html::error($model, 'embed_email_reply_to', ['class' => "errorMessage"]) ?>
        </div>
    </div>


</div>
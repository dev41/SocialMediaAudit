<?php

use app\helpers\FormHelper;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model \app\models\EmbeddingForm */
?>
<div class="boxed boxed--border"?>
    <div class="row">
        <div class="col-md-12">
            <h3 class="header-title"><?= Yii::t('app', 'Webhook') ?></h3>
            <label><?= Yii::t('app', 'Enable Webhook') ?>:</label>

            <?= Html::activeHiddenInput($model, 'webhook_status') ?>

            <div class="radio-btn-group">
                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'webhook_status', false, [
                        'id' => 'webhook-status-hide',
                        'label' => 'Disabled',
                        'class' => 'enable-field',
                    ]) ?>
                </div>

                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'webhook_status', true, [
                        'id' => 'webhook-status-show',
                        'label' => 'Enabled',
                        'class' => 'enable-field',
                        'data-target' => '#embed-webhook-value',
                    ]) ?>
                </div>
            </div>

            <?= Html::error($model, 'webhook_status', ['class' => "errorMessage"]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="hint">Webhook functionality allows you to integrate with external systems like
                CRMs, and pass any new lead across to them. Using this functionality may
                require some basic coding knowledge.</div>
        </div>
    </div>

    <div id="embed-webhook-value">
        <div class="row">
            <div class="col-md-12">
                <label><?= Yii::t('app', 'Include link to customer\'s PDF Report') ?>:</label>
                <?= Html::activeHiddenInput($model, 'webhook_pdf') ?>

                <div class="radio-btn-group">
                    <div class="radio-btn">
                        <?= FormHelper::stackRadio($model, 'webhook_pdf', false, [
                            'id' => 'webhook-pdf-hide',
                            'label' => 'Disabled',
                        ]) ?>
                    </div>

                    <div class="radio-btn">
                        <?= FormHelper::stackRadio($model, 'webhook_pdf', true, [
                            'id' => 'webhook-pdf-show',
                            'label' => 'Enabled',
                        ]) ?>
                    </div>
                </div>

                <?= Html::error($model, 'webhook_pdf', ['class' => "errorMessage m-b-0"]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="hint">Please note, this may delay the Webhook call by a minute while the PDF is generated.</div>
            </div>
        </div>
        <div class="row m-b-15">
            <div class="col-md-12">
                <label><?= Yii::t('app', 'Webhook Handler URL') ?></label>
                <div class="row m-b-15">
                    <div class="col-md-5 col-sm-6">
                        <?= Html::activeTextInput($model, 'webhook_url', ["class" => "form-control agency-settings-webhook_url", "placeholder" => "https://your-website.com/handler.php"]) ?>
                        <?= Html::error($model, 'webhook_url', ['class' => "errorMessage agency-settings-webhook_url-error"]) ?>
                    </div>
                </div>
                <div class="hint">Please input the destination file
                    name to be called by our logic. We will pass all lead details as a POST
                    request including these fields - email, website, phone number (if used),
                    key (your unique SEOptimer API key listed below that you can use to ensure
                    that the request is only coming from SEOptimer).</div>
                <div>
                    <button id="test-call" class="btn btn--primary background--warning">Test Call</button>
                    <span id="call-results">Call results will be shown here</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label><?= Yii::t('app', 'API Key') ?>: <span id="apikey"><?= md5($model->uid.'jh5jgt54jgh')?></span></label>
            </div>
        </div>
    </div>
</div>
<?php

use app\helpers\FormHelper;
use yii\bootstrap\Html;
use app\models\Agency;

/* @var $this yii\web\View */
/* @var $model \app\models\BrandingForm */
?>

<div class="boxed boxed--border" style="overflow: unset;"?>
    <h3 class="m-t-0 header-title"><?= Yii::t('app', 'General Settings') ?></h3>
    <div class="row m-b-15">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-12">
                    <label><?= Yii::t('app', 'Report Language') ?></label>

                    <div class="dropup">
                        <button class="btn btn-lg btn-white dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <span class="font-preview"><?= Agency::LANGUAGES[$model->language] ?></span>
                            <span class="caret"></span>
                        </button>
                        <ul id="language-dropdown" class="dropdown-menu" style="max-height: 200px; overflow-y: scroll;">
                            <?php foreach (Agency::LANGUAGES as $code => $language) { ?>
                                <li>
                                    <a href="#" data-language="<?= $code ?>" ><?= $language ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                        <?= Html::hiddenInput('BrandingForm[language]', $model->language, [
                            "id" => "language",
                        ]) ?>
                    </div>

                    <?= Html::error($model, 'language', [
                        'class' => "errorMessage",
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="hint">
                        This language selection will be used on all White Label reports produced, as well as the Embeddable Audit Tool.
                    </div>
                </div>
            </div>
            <div class="row m-t-15">
                <div class="col-lg-3 col-sm-6">
                    <label><?= Yii::t('app', 'Subdomain') ?></label>
                    <div class="input-group">
                        <?= Html::activeTextInput($model, 'subdomain', ['class' => "form-control", 'style' => "min-width: 150px", "placeholder" => "Subdomain"]) ?>
                        <div class="input-group-addon">.websiteauditserver.com</div>
                    </div>
                    <?= Html::error($model, 'subdomain', ['class' => "errorMessage"]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row m-b-15">
        <div class="col-md-12">
            <label><?= Yii::t('app', 'Check Detail') ?></label>
            <?= Html::activeHiddenInput($model, 'show_details') ?>

            <div class="radio-btn-group">
                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'show_details', false, [
                        'id' => 'AgencyProfile_show_details_0',
                        'label' => 'Hide',
                    ]) ?>
                </div>

                <div class="radio-btn">
                    <?= FormHelper::stackRadio($model, 'show_details', true, [
                        'id' => 'AgencyProfile_show_details_1',
                        'label' => 'Show',
                    ]) ?>
                </div>
                <?= Html::error($model, 'show_details', [
                    'class' => "errorMessage m-b-0",
                ]) ?>
            </div>

            <div class="hint">
                Many checks provide a more detailed explanation of what needs to be improved on the page, via 'More Details' buttons.
                These details can include tables of information, such as images missing ALT tags.
                You generally may not want to show this level of detail to your customer, so this is disabled by default.
            </div>
        </div>
    </div>


</div>

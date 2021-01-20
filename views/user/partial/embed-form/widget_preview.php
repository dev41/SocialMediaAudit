<?php
use yii\bootstrap\Html;
?>
<div class="boxed boxed--border"?>
    <div class="row">
        <div class="col-md-12">
            <h3 class="header-title"><?= Yii::t('app', 'Widget Preview') ?></h3>
            <div class="embed-preview m-t-15">
                <input type="text" id="widget-preview-field-website-to-analyze" placeholder="<?= Yii::t('report','Enter website') ?>" style="background-color: #FFFFFF; border-radius: 4px; padding: 7px 12px; height: 45px; font-size: 18px; width: 300px;">
                <input type="text" id="widget-preview-field-first-name" placeholder="<?= Yii::t('report','Your First Name') ?>" style="background-color: #FFFFFF; border-radius: 4px; padding: 7px 12px; height: 45px; font-size: 18px; width: 300px;">
                <input type="text" id="widget-preview-field-last-name" placeholder="<?= Yii::t('report','Your Last Name') ?>" style="background-color: #FFFFFF; border-radius: 4px; padding: 7px 12px; height: 45px; font-size: 18px; width: 300px;">
                <input type="text" id="widget-preview-field-customer-email" placeholder="<?= Yii::t('report','Your e-mail') ?>" style="background-color: #FFFFFF; border-radius: 4px; padding: 7px 12px; height: 45px; font-size: 18px; width: 300px;">
                <input type="text" id="widget-preview-field-customer-phone" placeholder="<?= Yii::t('report','Your phone') ?>" style="background-color: #FFFFFF; border-radius: 4px; padding: 7px 12px; height: 45px; font-size: 18px; width: 300px;">
                <input type="text" id="widget-preview-field-custom" placeholder="" style="background-color: #FFFFFF; border-radius: 4px; padding: 7px 12px; height: 45px; font-size: 18px; width: 300px;">

                <!-- //seoptimerSubmitWebsite 19.09.2018 @merge_new_seospytool -->
                <input type="submit" id="widget-preview-submit-button" value="<?= Yii::t('report','Check') ?>" onclick="return soSubmitWebsite(this)" style="border-radius: 3px; padding: 8px 50px; font-size: 19px; text-decoration: none; display: block; margin: 5px auto;">

                <div>
                    <label id="widget-preview-field-consent" style="font-size: 18px; font-weight: normal">
                        <input type="checkbox" />
                        <span></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row m-b-30">
    <div class="col-md-12">
        <?= Html::submitButton('Save & Generate Widget Code', ["class" => "btn btn--primary"]) ?>
    </div>
</div>
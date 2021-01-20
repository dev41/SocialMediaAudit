<?php
/* @var $this yii\web\View */
/* @var $model \app\models\EmbeddingForm */
/* @var $processEmbeddedUrl string */

$field_styles = "height: 45px; \n\twidth: 300px; ";
$wrap_styles = "width: 100%; ";
$button_styles = "font-size: 19px; \n\tdisplay: inline; \n\twidth: 130px; \n\tpadding: 8px 20px; ";
if ($model->embed_form_type == "row_slim") {
    $field_styles = "height: 38px; \n\twidth: 250px; ";
    $button_styles = "font-size: 18px; \n\twidth: 150px; \n\tpadding: 8px 20px; ";
} elseif ($model->embed_form_type == "column_large") {
    $field_styles = "height: 45px; \n\twidth: 100%; \n\tdisplay: block; \n\tmargin-top: 5px; ";
    $wrap_styles = "width: 300px; ";
    $button_styles = "font-size: 19px; \n\tdisplay: block; \n\tpadding: 8px 50px; \n\tmargin: 5px auto;";
} elseif ($model->embed_form_type == "column_slim") {
    $field_styles = "height: 38px; \n\twidth: 100%; \n\tdisplay: block; \n\tmargin-top: 5px; ";
    $wrap_styles = "width: 300px; ";
    $button_styles = "font-size: 18px; \n\tdisplay: block; \n\tpadding: 8px 30px; \n\tmargin-top: 5px;";
}
$baseUrl = 'https://' .  Yii::$app->params['auditDomain'] . '/';
$id = 'so'.time();
?>
<style type="text/css">
    /* Please move these styles to your css file or just keep them here */
    #so-form {
        margin: 10px;
    }
    #so-fieldswrap<?= $id ?> {
    <?= $wrap_styles ?>

    }
    .so-field<?= $id ?> {
        background-color: #FFFFFF;
        border: 1px solid <?= $model->embed_color_field_borders ?>;
        border-radius: 4px; color: <?= $model->embed_color_text ?>;
        padding: 7px 12px;
        font-size: 18px;
        <?= $field_styles ?>
    }
    #so-submit<?= $id ?> {
        background-color: <?= $model->embed_color_btn ?>;
        border: 1px solid <?= $model->embed_color_btn ?>;
        color: <?= $model->embed_color_btn_text ?>;
        border-radius: 3px;
        text-decoration: none;
        cursor: pointer;
        <?= $button_styles ?>
    }
<?php if ($model->embed_enable_consent) { ?>
    #so-consent<?= $id ?> input {
        -webkit-appearance: none;
        background-color: #fafafa;
        border: 1px solid <?= $model->embed_color_field_borders ?>;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
        padding: 9px;
        border-radius: 3px;
        display: inline-block;
        position: relative;
        top: 6px;
    }
    #so-consent<?= $id ?> input:active, #so-consent<?= $id ?> input:checked:active {
        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);
    }

    #so-consent<?= $id ?> input:checked {
        background-color: #e9ecee;
        border: 1px solid #adb8c0;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1);
        color: #99a1a7;
    }
    #so-consent<?= $id ?> input:checked:after {
        content: '\2714';
        font-size: 14px;
        position: absolute;
        top: 0px;
        left: 3px;
        color: #99a1a7;
    }
    #so-consent<?= $id ?> span {
        font-size: 18px;
        color: <?= $model->embed_color_text ?>;
    }
<?php } ?>

</style>
<form class="so-widget-form" id="<?= $id ?>" action="<?= $processEmbeddedUrl ?>" target="so-iframe" data-behaviour="<?= $model->embed_behaviour ?>" data-title="<?= Yii::t('report','Website Report for ') ?>" data-touch="<?= $model->embed_intouch_message? $model->embed_intouch_message : Yii::t('report','Thank you for requesting a report. We\'ll be in touch shortly!') ?>" onsubmit="return soSubmit(this)">
    <input id="so-type<?= $id ?>" type="hidden" name="type" value="<?= $model->embed_report_type ?>">
    <input type="hidden" name="uid" value="<?= $model->uid ?>">
    <input type="hidden" name="behaviour" value="<?= $model->embed_behaviour ?>">

    <?php if ($model->embed_behaviour == 'redirect') { ?>
        <input id="so-redirect<?= $id ?>" type="hidden" name="redirect" value="<?= $model->embed_redirect_url ?>">
    <?php } ?>
    <?php if ($model->embed_behaviour == 'modal' && $model->embed_enable_button) { ?>
        <input id="so-button<?= $id ?>" type="hidden" name="button" value="<?= $model->embed_button_url ?>" title="<?= $model->embed_button_text ?>">
    <?php } ?>

    <div id="so-fieldswrap<?= $id ?>">
        <input type="text" name="domain" id="so-domain<?= $id ?>" class="so-field<?= $id ?>" placeholder="<?= Yii::t('report','Enter website') ?>" data-validation="<?= Yii::t('report','Please enter a correct website domain') ?>">
        <?php if ($model->embed_enable_first_name) { ?>
            <input type="text" name="first_name" id="so-first-name<?= $id ?>" class="so-field<?= $id ?>" placeholder="<?= Yii::t('report','Your First Name') ?>" data-validation="<?= Yii::t('report','Please enter your First Name') ?>">
        <?php } ?>
        <?php if ($model->embed_enable_last_name) { ?>
            <input type="text" name="last_name" id="so-last-name<?= $id ?>" class="so-field<?= $id ?>" placeholder="<?= Yii::t('report','Your Last Name') ?>" data-validation="<?= Yii::t('report','Please enter your Last Name') ?>">
        <?php } ?>
        <?php if ($model->embed_enable_email) { ?>
            <input type="text" name="email" id="so-email<?= $id ?>" class="so-field<?= $id ?>" placeholder="<?= Yii::t('report','Your e-mail') ?>" data-validation="<?= Yii::t('report','Please enter your email') ?>">
        <?php } ?>
        <?php if ($model->embed_enable_phone) { ?>
            <input type="text" name="phone" id="so-phone<?= $id ?>" class="so-field<?= $id ?>" placeholder="<?= Yii::t('report','Your phone') ?>" data-validation="<?= Yii::t('report','Please enter your phone') ?>">
        <?php } ?>
        <?php if ($model->embed_enable_custom_field) { ?>
            <input type="text" name="custom_field" id="so-custom-field<?= $id ?>" class="so-field<?= $id ?>" placeholder="<?= $model->embed_custom_field ?>" data-validation="<?= Yii::t('report','Please enter your ').$model->embed_custom_field ?>">
        <?php } ?>
        <input type="submit" id="so-submit<?= $id ?>" value="<?= Yii::t('report','Check') ?>">
        <?php if ($model->embed_enable_consent) { ?>
            <div><label id="so-consent<?= $id ?>">
                    <input id="so-consent-value<?= $id ?>" name="consent" value="1" type="checkbox" data-validation="<?= Yii::t('report','Please give your consent') ?>" />
                    <span><?= $model->embed_consent ?></span>
                </label>
            </div>
        <?php } ?>
    </div>
</form>
<script type="text/javascript" src="<?= $baseUrl ?>js/embed/widget-2.2.js"></script>


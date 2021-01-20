<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use app\models\Agency;

/* @var $this yii\web\View */
/* @var $model \app\models\EmbeddingForm */

$this->title = 'Embedding Settings';
$fonts = $model->getFontsUrls();
foreach ($fonts as $font) {
    $this->registerCssFile($font);
}
$fontList = Agency::generateHtmlFontList();
?>
<h1 class="m-t-0">Embedding Settings</h1>
<p class="m-b-20">Here you can choose whether to generate a PDF or standard Web-Page based report for your customers, as well as download the HTML code to insert into your website.</p>

<?php if ( \Yii::$app->request->isMainDomain() ) { ?>
    <p><a href="/blog/how-to-embed-audit-form" target="_blank">How to add white-labelled SocialMediaAudit form to my website?</a></p>
<?php } ?>

<?php $form = ActiveForm::begin([
    'id' => 'agency-settings-form',
    //'fieldConfig' => [
    //    'template' => "{input}\n{error}\n{hint}",
    //]
]); ?>
<div class="row m-b-15">
    <div class="col-md-12">
        <p class="m-0">Language for Report & Audit Form:</p>
        <div id="embed-language"><?= Agency::LANGUAGES[$model->language] ?></div>
        <div class="hint">
            Change language on the <a href="/report-settings">Report Settings</a> tab
        </div>
    </div>
</div>

<?= $this->render('partial/embed-form/behaviour', ['model' => $model]) ?>

<?= $this->render('partial/embed-form/design', ['model' => $model]) ?>

<?= $this->render('partial/embed-form/widget_preview', ['model' => $model]) ?>

<?= $this->render('partial/embed-form/widget_code', ['model' => $model]) ?>

<?= $this->render('partial/embed-form/email_settings', ['model' => $model]) ?>

<?= $this->render('partial/embed-form/email_customer', ['model' => $model, 'fontList' => $fontList]) ?>

<?= $this->render('partial/embed-form/webhook', ['model' => $model]) ?>

<div class="row m-b-15">
    <div class="col-md-12 text-center">
        <?= Html::submitButton('Save Settings', ["class" => "btn btn--primary width100"]) ?>
    </div>
</div>

<?php
ActiveForm::end();

$this->registerJsFile('/js/clipboard.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerCssFile('/js/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css');
$this->registerJsFile('/js/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJs("
$('.colorpicker-default').colorpicker({ format: 'hex' });
renderWidgetPreview();
renderEmailTemplatePreview();
$('#agency-settings-form input, #agency-settings-form textarea').change(function(){ 
    renderWidgetPreview();
    renderEmailTemplatePreview();
});
$('.embed-color-btn, .embed-color-text, .embed-color-btn-text, .embed-color-field-borders').colorpicker({ format: 'hex' }).on('changeColor', renderWidgetPreview);
$('#test-call').on('click', function () {
    $.post('/ajax-testcall.inc',
        {'url' : $('#embeddingform-webhook_url').val(), 'key' : $('#apikey').text() },
        function (data) {
            $('#call-results').text(data);
        }
    );
    return false;
});
var clipboard = new Clipboard('.btn-embed-code-copy');
clipboard.on('success', function (e) {
    var notice = $('.notice-embed-code-copied');
    notice.show();
    setTimeout(function () {
        notice.fadeOut(1000);
    }, 200);
    e.clearSelection();
});

$('.enable-field').change(function(){
    var target = $(this).attr('data-target');
    if ($(this).attr('type') === 'radio') {
        $('input[name=\"'+$(this).attr('name')+'\"]').each(function(){
            $($(this).attr('data-target')).hide();
        });
    }
    if ($(this).prop('checked')) $(target).show();
    else $(target).hide();
}).trigger('change');
$('input.enable-field:checked').trigger('change');
$('.colorpicker-email').colorpicker({ format: 'hex' }).on('changeColor', function(ev){
    renderEmailTemplatePreview();
});
");
?>
<script type="text/javascript">
function renderWidgetPreview() {
    var fields = $('#widget-preview-field-website-to-analyze, #widget-preview-field-customer-email, #widget-preview-field-customer-phone, #widget-preview-field-first-name, #widget-preview-field-last-name, #widget-preview-field-custom');
    var button = $('#widget-preview-submit-button');
    var form_type = $('#embed-form-type-row-large, #embed-form-type-row-slim, #embed-form-type-column-large, #embed-form-type-column-slim').filter(':checked').val();
    var number_of_fields = 1;
    if ($('#embed-enable-email:checked').length > 0) {
        number_of_fields++;
    }
    if ($('#embed-enable-phone:checked').length > 0) number_of_fields++;
    if ($('#embed-enable-first-name:checked').length > 0) {
        number_of_fields++;
    }
    if ($('#embed-enable-last-name:checked').length > 0) {
        number_of_fields++;
    }
    if ($('#embed-enable-custom-field:checked').length > 0) {
        number_of_fields++;
    }
    var row_width;
    switch (number_of_fields) {
        case 1: row_width = '305px'; break;
        case 2: row_width = '610px'; break;
        case 3: row_width = '910px'; break;
        case 4: row_width = '910px'; break;
        case 5: row_width = '910px'; break;
        case 6: row_width = '910px'; break;
    }
    if (form_type == 'row_large') {
        $('.embed-preview').css('width', '100%');
        fields.css({'height': '45px', 'width': '300px', 'display': 'inline', 'margin-top': '0'});
        button.css({'font-size': '19px', 'width': '130px', 'display': 'inline', 'padding': '8px 20px'});
    } else if (form_type == 'row_slim') {
        $('.embed-preview').css('width', '100%');
        fields.css({'height': '38px', 'width': '250px', 'display': 'inline', 'margin-top': '0'});
        button.css({'font-size': '18px', 'width': '150px', 'display': 'inline', 'padding': '8px 20px'});
    } else if (form_type == 'column_large') {
        $('.embed-preview').css('width', '300px');
        fields.css({'height': '45px', 'width': '100%', 'display': 'block', 'margin-top': '5px'});
        button.css({'font-size': '19px', 'width': 'auto', 'display': 'block', 'margin': '5px auto', 'padding': '8px 50px'});
    } else if (form_type == 'column_slim') {
        $('.embed-preview').css('width', '300px');
        fields.css({'height': '38px', 'width': '100%', 'display': 'block', 'margin-top': '5px'});
        button.css({'font-size': '18px', 'width': 'auto', 'display': 'block', 'margin': '5px auto', 'padding': '8px 20px'});
    }
    var field_border_color = $('.embed-color-field-borders').val();
    if ($('#embed-enable-email:checked').length > 0) {
        $('#widget-preview-field-customer-email').show();
    } else {
        $('#widget-preview-field-customer-email').hide();
    }
    if ($('#embed-enable-phone:checked').length > 0) {
        $('#widget-preview-field-customer-phone').show();
    } else {
        $('#widget-preview-field-customer-phone').hide();
    }
    if ($('#embed-enable-first-name:checked').length > 0) {
        $('#widget-preview-field-first-name').show();
    } else {
        $('#widget-preview-field-first-name').hide();
    }
    if ($('#embed-enable-last-name:checked').length > 0) {
        $('#widget-preview-field-last-name').show();
    } else {
        $('#widget-preview-field-last-name').hide();
    }
    if ($('#embed-enable-custom-field:checked').length > 0) {
        $('#widget-preview-field-custom').show().attr('placeholder', $('#embeddingform-embed_custom_field').val());
    } else {
        $('#widget-preview-field-custom').hide();
    }
    if ($('#embed-enable-consent:checked').length > 0) {
        $('#widget-preview-field-consent').show().find('span').html($('#embed_consent_value').val());
        // styling
        $('#widget-preview-field-consent input').css({'border':'1px solid '+field_border_color});
    } else {
        $('#widget-preview-field-consent').hide();
    }
    fields.css('border', '1px solid '+field_border_color);
    var field_text_color = $('.embed-color-text').val();
    fields.css('color', field_text_color);
    var button_color = $('.embed-color-btn').val();
    button.css('background-color', button_color);
    button.css('border', '1px solid '+button_color);
    var button_text_color = $('.embed-color-btn-text').val();
    button.css('color', button_text_color);
}

String.prototype.stripcslashes = function(){
    return this.replace(/\\(.)/g, function (match, char) {
        return {'t': '\t', 'r': '\r', 'n': '\n', '0': '\0'}[char] || match;
    });
};


function renderEmailTemplatePreview() {
    $('.js-email-template-title').html($('#embed-email-title').val()).css('font-family', $('#embed-email-header-font').val());

    $('.js-email-template-content > div').html( $('#embed-email-content').val() ).css('font-family', $('#embed-email-body-font').val());

    // colors
    $('.js-email-template-header').css('background-color', $('#embed-email-header-background').val());
    $('.js-email-template-title').css('color', $('#embed-email-header-color').val());
    $('.js-email-template-content').css('background-color', $('#embed-email-body-background').val());
    $('.js-email-template-content').css('color', $('#embed-email-body-color').val());

    if ($('#embed-email-logo-show:checked').length === 1) {
        $('.js-email-template-header img').show();
    } else {
        $('.js-email-template-header img').hide();
    }
}
</script>

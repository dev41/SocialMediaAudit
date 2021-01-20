<?php

use app\helpers\FormHelper;
use yii\bootstrap\ActiveForm;
use app\models\Agency;

/* @var $this yii\web\View */
/* @var $model \app\models\BrandingForm */

$this->title = 'White Label Report Settings';
$fonts = $model->getFontsUrls();
foreach ($fonts as $font) {
    $this->registerCssFile($font);
}
$fontList = Agency::generateHtmlFontList();
$fontSample = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.';
?>
<h1 class="m-t-0">Report Settings</h1>
<p class="m-b-20">In the Report Settings section you can customize various features of your report's look, feel and function, such as Colors, Fonts, Fields to Display as well as Company Logo and Branding settings.</p>

<?php $form = ActiveForm::begin([
    'id' => 'agency-settings-form',
    'fieldConfig' => [
        'template' => "{input}\n{error}\n{hint}",
    ]
]); ?>

    <?= FormHelper::stackErrorSummary($model); ?>

    <?= $this->render('partial/report-setting/general', ['model' => $model]) ?>

    <?= $this->render('partial/report-setting/report_header', ['model' => $model]) ?>

    <?= $this->render('partial/report-setting/checks', ['active' => $model->checks]) ?>

    <?= $this->render('partial/report-setting/recommendations', ['model' => $model]) ?>

    <?= $this->render('partial/report-setting/colors', ['model' => $model]) ?>

    <?= $this->render('partial/report-setting/fonts', ['model' => $model, 'fontList' => $fontList]) ?>

<?php
ActiveForm::end();
$this->registerCssFile('/js/plugins/dropzone/dist/dropzone.css');
$this->registerJsFile("/js/plugins/dropzone/dist/dropzone.js", ['depends' => 'yii\web\JqueryAsset']);
$this->registerCssFile('/js/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css');
$this->registerJsFile('/js/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJs("
    Dropzone.autoDiscover = false;

    var \$removeBtn = $('.remove-company-logo');
    $('.colorpicker-default').colorpicker({ format: 'hex' });

    logoDropzoneInit();

    $('#default_fg').change(function () {
        $('#custom_fg').prop('disabled', $(this).prop('checked'));
    });
    
    $('#default_section_fgcolor').change(function () {
        $('#custom_section_fgcolor').prop('disabled', $(this).prop('checked'));
    });
    
    $('#default_fg').change();
    $('#default_section_fgcolor').change();
    
    $(\".dropup a\").click(function (e) {
        var droper = $(this).closest('.dropup');
        droper.find(\".hidden-input-font\")
            .val($(this).data('font')).trigger('change');
        droper.find(\".font-preview\")
            .css(\"font-family\", $(this).data('font'))
            .text($(this).text());
        e.preventDefault();
    });
    $('input[name=\"BrandingForm[show_title]\"]').change(function(){previewCustomText(this)});
    $('input[name=\"BrandingForm[show_title]\"]:checked').trigger('change');
    $('input[name=\"BrandingForm[show_intro]\"]').change(function(){previewCustomText(this)});
    $('input[name=\"BrandingForm[show_intro]\"]:checked').trigger('change');
    $('.fontlist li').hide();
    $('.'+$('#language').val()).show();
    $('#language').change(function(){
        var lang = $(this).val();
        var fontName; 
        $('.fontlist li').hide();
        $('.'+lang).show();
        $('.fontlist').each(function(){
            fontName = $(this).closest('div').find('input').val();
            if ($(this).find('.'+lang).filter(function(){
                return $(this).text() === fontName;
            }).length === 0) $(this).find('.'+lang+' a:first').trigger('click');
        });
    });
    $('#language-dropdown a').on('click touch', function(){
        $('#language').val($(this).attr('data-language')).trigger('change');
    });
");
?>
<script type="text/javascript">
    function preloadLogo(self) {
        var preload = $('.company-logo-dropzone').data('preload');
        if (preload.length > 0) {
            var mock = {
                name: preload,
                url: '/upload/'+preload,
                accepted: true
            };
            self.files.push(mock);
            self.emit('addedfile', mock);
            //self.createThumbnailFromUrl(mock, mock.url);
            self.emit('complete', mock);
            self._updateMaxFilesReachedClass();
            $('.dz-image img').attr('src', mock.url);
        } else {
            $('.remove-company-logo').hide();
        }
    }

    function logoDropzoneInit() {
        var uploadLogoUrl = "upload-logo.inc";
        var $errorRemoveCont = $('#error-remove-logo-container').hide();
        var logoDZ = new Dropzone('.company-logo-dropzone', {
            url: uploadLogoUrl,
            paramName: 'company_logo',
            uploadMultiple: false,
            maxFiles: 1,
            acceptedFiles: 'image/jpeg,image/png',
            thumbnailWidth: null,
            thumbnailHeight: 80,
            init: function () {
                this.on('maxfilesexceeded', function (file) {
                    this.removeAllFiles();
                    this.addFile(file);
                    $('.remove-company-logo').show();
                });
                this.on('success', function () {
                    $('.remove-company-logo').show();
                });
                this.on('removedfile', function () {
                    var self = this;
                    $('.remove-company-logo').hide();
                    $.post(uploadLogoUrl, {remove: 1}, function (r) {
                        if (!r.success) {
                            $errorRemoveCont.show();
                            preloadLogo(self);
                        }
                    }, 'json');
                });

                preloadLogo(this);
            }
        });
        $('.remove-company-logo').on('click', function () {
            logoDZ.removeAllFiles(true);
            return false;
        })
    }

    function previewCustomText(el) {
        var value = parseInt($(el).val());
        var parent = $(el).closest('div.row');

        if (value === 2) {
            parent.find('.hint').show();
            if (parent.find('textarea').val() === '') {
                parent.find('textarea').val(parent.find('.default-value').text());
            }
        } else {
            parent.find('.hint').hide();
        }
    }
</script>
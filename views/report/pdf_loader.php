<?php

/* @var $agency \app\models\Agency */
/* @var $website \app\models\Website */
/* @var $leadId integer */

$postParams = [
    'wid' => $website->id,
    '_csrf' => "$('meta[name=csrf-token]').prop('content')",
];
if ( !empty($leadId) ) {
	$postParams['leadId'] = $leadId;
}
?>
<?= $this->render('partial/_report_styles', ['agency' => $agency]) ?>

<div class="pdf-loader-container">
    <div class="pdf-loader-content">
        <div class="progress">
            <div class="progress-bar progress-bar-primary progress-bar-striped active h5 progress-label report-fg-color--bg"
                 role="progressbar"
                 aria-valuenow="100"
                 aria-valuemin="0"
                 aria-valuemax="100"
                 style="width:100%">
                <?= Yii::t('report', 'Generating your PDF Report now...') ?>
            </div>
        </div>
        <p id="answer" class="text-under-progress-bar"><?= Yii::t('report', 'This should take less than a minute.') ?></p>
    </div>
</div>

<script type='text/javascript' src='https://code.jquery.com/jquery-1.12.4.min.js'></script>
<script type="text/javascript">
    $ = jQuery;
    $(function () {
        $.post('/prepare-pdf.inc', <?= json_encode($postParams) ?>, function (response) {
            if (response.success) {
                $('.radial').addClass('radial--active');
                window.location = '/download-pdf.inc/'+response.pdf;
            } else {
                window.location = response.link;
                //$('#answer').html('<strong>There’s been an issue in PDF generation for this particular website.</strong> Please <a href="/<?= $website->domain ?>">proceed to the Web-Page version</a> of this report.');
            }
        });
    });
</script>
<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model \app\models\Agency */

$this->title = 'Leads';
$user = Yii::$app->user->identity;
$baseUrl = '/';
if ( !empty($user->agency->subdomain) ) $baseUrl = '//'.$user->agency->subdomain.'.'.Yii::$app->params['auditDomain'].'/website/';
?>
<h1 class="m-t-0">Leads</h1>
<p class="m-b-20">Here you can see the list of leads that have run a report from your website. You will also receive an email notification at the point that the lead arrived.</p>

<div class="row" id="leads">
    <div class="col-md-12 ">
        <table class="datatable-buttons table-agency-leads border--round table--alternate-row scrollable-table-content">
            <thead>
            <tr>
                <?php
                if ($model->embed_enable_email) echo '<th>'.\Yii::t('app', 'Email').'</th>';
                if ($model->embed_enable_phone) echo '<th>'.\Yii::t('app', 'Phone').'</th>';
                if ($model->embed_enable_first_name) echo '<th>'.\Yii::t('app', 'First Name').'</th>';
                if ($model->embed_enable_last_name) echo '<th>'.\Yii::t('app', 'Last Name').'</th>';
                if ($model->embed_enable_custom_field) echo '<th>'.$model->embed_custom_field.'</th>';
                if ($model->embed_enable_consent) echo '<th>'.\Yii::t('app', 'Consent').'</th>';
                ?>
                <th><?= \Yii::t('app', 'IP'); ?></th>
                <th><?= \Yii::t('app', 'Website'); ?></th>
                <th><?= \Yii::t('app', 'Arrived'); ?></th>
                <th class="text-center no-sort" width="260">Report</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ( $user->getAgencyLeads()->where(['uid' => $user->id])->batch(100) as $leads ){ ?>
                <?php foreach ($leads as $lead) { ?>
                    <tr>
                        <?php
                        if ($model->embed_enable_email) echo '<td>'.$lead->email.'</td>';
                        if ($model->embed_enable_phone) echo '<td>'.$lead->phone.'</td>';
                        if ($model->embed_enable_first_name) echo '<td>'.$lead->first_name.'</td>';
                        if ($model->embed_enable_last_name) echo '<td>'.$lead->last_name.'</td>';
                        if ($model->embed_enable_custom_field) echo '<td>'.$lead->custom_field.'</td>';
                        echo '<td>'.($lead->consent? 'Yes' : 'No').'</td>';
                        ?>
                        <td><?= $lead->ip ?></td>
                        <td><?= $lead->domain ?></td>
                        <td><?= $lead->arrived ?></td>
                        <td class="no-sort">
                            <a href="<?= $baseUrl.$lead->domain ?>" target="_blank" class="btn btn--sm btn--primary">View</a>
                            <a href="<?= $baseUrl.$lead->domain ?>" data-website="<?= $lead->domain ?>" onClick="return requestPdf(this)" class="btn btn--sm btn--primary">PDF</a>
                            <a onClick="removeLeadViaAjax($(this));return false" href="<?= $lead->domain ?>" data-lead-id="<?= $lead->id ?>" title="Remove Lead" class="btn btn--sm btn--primary background--danger">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?= Html::beginForm($baseUrl.'request-pdf.inc', 'post', [
    'id' => 'pdf-form',
    'target' => '_blank',
]) ?>
    <input name="domain" value="" type="hidden">
<?= Html::endForm() ?>
<script type="text/javascript">
    function removeLeadViaAjax(el) {
        $.post('/delete-lead.inc', {'id' : el.data('lead-id')});
        el.closest('tr').fadeOut(250, function () {
            $('.table-agency-leads').DataTable().row(el.closest('tr')).remove().draw();
        });
        return false;
    }
    function requestPdf(el) {
        $('#pdf-form input[name="domain"]').val($(el).attr('data-website'));
        $('#pdf-form').submit();
        return false;
    }
</script>
<?php

$this->registerJsFile('/js/plugins/datatables/jquery.dataTables.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/datatables/dataTables.bootstrap.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/datatables/dataTables.buttons.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/datatables/buttons.bootstrap.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/datatables/jszip.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/datatables/pdfmake.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/datatables/vfs_fonts.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/datatables/buttons.html5.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/datatables/buttons.print.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/pages/datatables.init.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/ladda-buttons/js/spin.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/ladda-buttons/js/ladda.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/ladda-buttons/js/ladda.jquery.min.js', ['depends' => 'yii\web\JqueryAsset']);
$js = <<<JS
var dtAudits = TableManageButtons.init('.datatable-buttons.table-agency-leads');;
dtAudits.order([0, 'desc']).draw();

$('.table-agency-leads th.dynamic').css('width', 'auto');
$('.table-agency-leads th.text-center').width(180);
JS;
$this->registerJs($js);
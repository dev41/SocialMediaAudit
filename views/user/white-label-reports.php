<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $this yii\web\View */

$this->title = 'White Label Reports';
$user = Yii::$app->user->identity;
$baseUrl = '/';
$auditBaseUrl = '/';
$auditUrl = '/';
if (!empty($user->agency->subdomain)) {
    $auditUrl = '//'.$user->agency->subdomain.'.'.Yii::$app->params['auditDomain'].'/website/';
    $auditBaseUrl = '//'.$user->agency->subdomain.'.'.Yii::$app->params['auditDomain'].'/';
    $baseUrl  = '//'.$user->agency->subdomain.'.'.Yii::$app->params['domain'].'/';
}

//$auditUrl = $baseUrl;
?>
<h1 class="m-t-0">White Label Reports</h1>
<p class="m-b-20">You can run a Website Audit by entering a website into the field below. You’ll have the option to view the Report in PDF form or as a basic web-page. Reports will use your company’s logo and branding settings as defined in the next tab. You can share these reports with your prospects or customers.</p>
<p>Please complete details in the Report Settings tab to White Label your reports.</p>
<div class="row m-b-20">
    <form class="agency-audit">
        <div class="col-xs-8">
            <input name="website" type="text" value="" placeholder="Example.com" class="form-control search-box input-hg">
        </div>
        <div class="col-md-1">
            <a href="#" class="btn btn--primary btn-do-audit">Check!</a>
        </div>
    </form>
</div>
<div class="row" id="audits">
    <div class="col-md-12">
        <table class="datatable-buttons table-agency-audits border--round table--alternate-row">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th class="dynamic">Website</th>
                    <th class="text-center" width="260" style="min-width: 200px">Report</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $n = 1;
                foreach ($user->agencyAudits as $audit) { ?>
                    <tr>
                        <td><?= $n++ ?></td>
                        <td><?= $audit->domain ?></td>
                        <td>
                            <a href="<?= $auditUrl.$audit->domain ?>" target="_blank" class="btn btn--sm btn--primary">View</a>
                            <a href="<?= $auditUrl.$audit->domain ?>" data-website="<?= $audit->domain ?>" onClick="return requestPdf(this)" class="btn btn--sm btn--primary">PDF</a>
                            <a href="<?= $auditUrl.$audit->domain ?>" data-website="<?= $audit->domain ?>" onClick="return refreshReport(this)" class="btn btn--sm btn--primary background--warning btn-ajax-refresh ladda-button" title="Refresh Results" data-style="zoom-in">
                                <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                            </a>
                            <a href="<?= $audit->domain ?>" data-website="<?= $audit->domain ?>" onClick="removeViaAjax($(this));return false" title="Remove website" class=" btn btn--sm btn--primary background--danger">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

<?php //echo Html::beginForm($baseUrl.'request-pdf.inc', 'post', [ //@toddo @merge 03.09.2018 ?>
<?= Html::beginForm($auditBaseUrl.'request-pdf.inc', 'post', [
    'id' => 'pdf-form',
    'target' => '_blank',
]) ?>
    <input name="domain" value="" type="hidden">
<?= Html::endForm() ?>
<?php //echo  Html::beginForm($baseUrl, 'post', [ //@todo @merge 03.09.2018 ?>
<?= Html::beginForm($auditUrl, 'post', [
    'id' => 'refresh-form',
]) ?>
    <input name="domain" value="" type="hidden">
    <input name="refresh" value="1" type="hidden">
<?= Html::endForm() ?>
    <script type="text/javascript">
        function removeViaAjax(el) {
            $.post('/ajax-delete.inc', {'domain' : el.attr('href')});
            el.closest('tr').fadeOut(250, function () {
                $('.table-agency-audits').DataTable().row(el.closest('tr')).remove().draw();
            });
            return false;
        }
        function requestPdf(el) {
            $('#pdf-form input[name="domain"]').val($(el).attr('data-website'));
            $('#pdf-form').submit();
            return false;
        }
        function refreshReport(el) {
            var ladda = Ladda.create(el);
            ladda.start();
            $.post('/refresh-audit.inc', {'domain' : $(el).attr('data-website')}, function () {
                ladda.stop();
                return false;
            });
            return false;
        }
    </script>
<?php
;
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
TableManageButtons.init('.datatable-buttons.table-agency-audits');
var auditUrl = "{$auditUrl}";
var dtAudits = $('.table-agency-audits').DataTable();
dtAudits.order([0, 'desc']).draw();
$('.table-agency-audits th.dynamic').css('width', 'auto');
$('.table-agency-audits th.text-center').width(180);
$('form.agency-audit').on('submit', function (e) {
    e.preventDefault();
    var input = $('[name=website]', this);
    input.val(input.val().toLowerCase().replace(/^https?:\/\//i,'').replace(/\/$/i, ''));
    var website = input.val();
    if (website.length == 0 || website.match(/^[a-z\d-]{1,62}\.[a-z\d-]{1,62}(.[a-z\d-]{1,62})*$/) == null) {
        alert('Please enter a correct domain');
        return false;
    }
    input.val('');
    var n = 1;
    var exists = false;
    dtAudits.data().each(function (row) {
        if (row[1] == website)
            exists = true;
        var nRow = parseInt(row[0]);
        if (nRow >= n)
            n = nRow+1;
    });
    if (exists) {
        return false;
    }

    var buttons = '<a href="' + auditUrl + website.replace("www.", "") + '" target="_blank" class="ladda-button ladda-button-n' + n + ' btn btn--sm btn--primary" data-style="zoom-in">View</a>';
    buttons += ' <a href="' + auditUrl + website.replace("www.", "") + '" data-website="' + website.replace("www.", "") + '"  onClick="return requestPdf(this)" class="ladda-button ladda-button-n' + n + ' btn btn--sm btn--primary" data-style="zoom-in">PDF</a>';
    buttons += ' <a href="' + auditUrl + website.replace("www.", "") + '" data-website="' + website.replace("www.", "") + '"  onClick="return refreshReport(this)" class="ladda-button ladda-button-n' + n + ' btn btn--sm btn--primary background--warning btn-ajax-refresh " data-style="zoom-in" title="Refresh Results"  onClick="return false;"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></a>';
    buttons += ' <a href="' + website.replace("www.", "") + '" data-website="' + website.replace("www.", "") + '" onClick="removeViaAjax($(this));return false" class="ladda-button ladda-button-n' + n + ' btn btn--sm btn--primary background--danger" data-style="zoom-in" title="Remove website"  onClick="return false;"><span class="glyphicon glyphicon-trash" aria-hidden="true"></a>';
    dtAudits.row.add([n, website, buttons]);
    dtAudits.order([0, 'desc']).draw();
    var ladda = Ladda.create($('.table-agency-audits .ladda-button-n'+n)[0]);
    var ladda2 = Ladda.create($('.table-agency-audits .ladda-button-n'+n)[1]);
    var ladda3 = Ladda.create($('.table-agency-audits .ladda-button-n'+n)[2]);
    var ladda4 = Ladda.create($('.table-agency-audits .ladda-button-n'+n)[3]);
    ladda.start();
    if (typeof ladda2 != 'undefined')
        ladda2.start();
    if (typeof ladda3 != 'undefined')
        ladda3.start();
     if (typeof ladda4 != 'undefined')
        ladda4.start();
    $.post('ajax-agency-audit.inc', {'domain': website}, function (result) {
        if (result.success) {
            ladda.stop();
            if (typeof ladda2 != 'undefined')
                ladda2.stop();
            if (typeof ladda3 != 'undefined')
                ladda3.stop();
             if (typeof ladda4 != 'undefined')
                ladda4.stop();
        } else {
            dtAudits.row($('.ladda-button-n'+n).closest('tr')).remove().draw();
        }
    }, 'json');
    return false;
});
$('.agency-audit .btn-do-audit').on('click', function (e) {
    e.preventDefault();
    $(this).closest('form').submit();
});
JS;
$this->registerJs($js);
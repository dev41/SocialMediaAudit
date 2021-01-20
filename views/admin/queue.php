<?php

/* @var $this yii\web\View */
/* @var $jobs array */

$this->title = 'Queue Status';
?>
<h1 class="m-t-0">Queue Jobs</h1>
<div class="row m-t-20" id="administration">
    <div class="col-md-12">
        <table class="datatable-buttons table-scans border--round table--alternate-row">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th>Job</th>
                    <th width="100">Created At</th>
                    <th width="100">Delayed To</th>
                    <th width="100">Reserved At</th>
                    <th>Attempt</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($jobs as $job) { ?>
                    <tr>
                        <td><?= $job['id'] ?></td>
                        <td><?= print_r(unserialize($job['job']), true); ?></td>
                        <td><?= date('Y-m-d H:i', $job['pushed_at']) ?></td>
                        <td><?= $job['delay']? date('Y-m-d H:i', $job['pushed_at']+$job['delay']) : '' ?></td>
                        <td><?= $job['reserved_at']? date('Y-m-d H:i', $job['reserved_at']) : '' ?></td>
                        <td><?= $job['attempt'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
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
$this->registerJs("
$.fn.dataTable.Api.register( 'order.neutral()', function () {
    return this.iterator( 'table', function ( s ) {
        s.aaSorting.length = 0;
        s.aiDisplay.sort( function (a,b) {
            return a-b;
        } );
        s.aiDisplayMaster.sort( function (a,b) {
            return a-b;
        } );
    } );
} );

TableManageButtons.init('.table-scans');
var dt = $('.table-scans').DataTable();
dt.order.neutral().draw();
");
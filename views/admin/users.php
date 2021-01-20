<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use app\components\widgets\Alert;

/* @var $this yii\web\View */
/* @var $users \app\models\User[] */

$this->title =  \Yii::t('app', 'User Administration - SocialMediaAudit');
$isAdministrator = Yii::$app->user->can(app\models\User::ROLE_ADMIN);
?>
<?= Alert::widget() ?>
<?= Html::a('<span class="btn__text">'. \Yii::t('app', 'Create User').' </span>', ['site/signup'], ['class' => 'btn btn--primary pull-right m-b-10']) ?>
<h1 class="m-t-0"><?= \Yii::t('app', 'User Administration'); ?></h1>
<div class="row m-t-20" id="administration">
    <div class="col-md-12">
        <table class="datatable-buttons table-users border--round table--alternate-row scrollable-table-content">
            <thead>
                <tr>
                    <th width="5%"><?= \Yii::t('app', 'ID'); ?></th>
                    <th><?= \Yii::t('app', 'Email'); ?></th>
                    <th><?= \Yii::t('app', 'First Name'); ?></th>
                    <th><?= \Yii::t('app', 'Last Name'); ?></th>
                    <th><?= \Yii::t('app', 'Status'); ?></th>
                    <?= $isAdministrator? '<th>'. \Yii::t('app', 'Reseller') .'</th>' : '' ?>
                    <th class="text-center" style="min-width: 100px;"></th>
                </tr>
            </thead>
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
var dtUsers = $('.table-users').DataTable({
    dom: 'Bfrtip',
    buttons: [{
        extend: 'copy',
        className: '',
    }, {
        extend: 'csv',
        className: ''
    }, {
        extend: 'excel',
        className: ''
    }, {
        extend: 'pdf',
        className: ''
    }, {
        extend: 'print',
        className: ''
    }],
    buttonLiner: {
      extend: 'copy',
            tag: 'span',
            className: 'btn__text',
        },
    responsive: !0,
    processing: true,
    serverSide: true,
    ajax: {
        url: '".Url::to(['admin/users-search'])."',
        type: 'POST'
    },
    columns: [
        { 
            data: 'id',
            searchable: false
        },
        { data: 'email' },
        { data: 'first_name'},
        { data: 'last_name'},
        { 
            data: 'active',
            searchable: false
        },
        ". ($isAdministrator? '{ 
            data: \'reseller_id\',
            searchable: false
        },' : ''). "
        { 
            data: 'other',
            searchable: false,
            orderable: false
        }
    ],
    order: [[ 0, 'desc' ]]
});
");
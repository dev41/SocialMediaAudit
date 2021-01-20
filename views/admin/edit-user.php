<?php

use app\helpers\FormHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use app\models\User;

/* @var $this yii\web\View */
/* @var $user \app\models\User */
/* @var $model \app\models\UserEditForm */

$this->title = 'Editing '.$user->email.' - SocialMediaAudit';
$roleItems = [
    0 => 'Please Choose Role',
];
foreach (Yii::$app->authManager->getRoles() as $role) {
    if (
        in_array($role->name, [
            User::ROLE_ADMIN,
            User::ROLE_SUPER_ADMIN,
        ]) &&
        !Yii::$app->user->can(User::ROLE_SUPER_ADMIN)
    ) {
        continue;
    }
    $roleItems[$role->name] = $role->description;
}
$isReseller = Yii::$app->user->can(User::ROLE_RESELLER);
$detailViewColumns = [
    'id',
    'email',
    [
        'attribute' => 'Full Name',
        'value' => function($user) {
            return $user->fullName;
        },
    ],
    [
        'attribute' => 'last_login',
        'value' => function($model) {
            return $model->last_login? $model->last_login : '';
        },
    ],
    'active:boolean',
    'date_suspend_ymd_his',
    [
        'attribute' => 'date_delete',
        'label' => 'Cancel Date',
        'value' => function($model) {
            return $model->date_delete? date('Y-m-d H:i:s', $model->date_delete) : '';
        },
    ],
    'note',
    'access_token:text:API Token',
];
if (Yii::$app->user->can(User::ROLE_ADMIN)) {
    $detailViewColumns[] = [
        'label' => 'Reseller',
        'value' => function($model) {
            return $model->reseller ? $model->reseller->email : '';
        },
    ];
}
?>
<h4 class="m-t-0 header-title"><b><?= 'Editing '.$user->email ?></b></h4>
<div class="row m-t-20" id="user-edit">
    <div class="col-md-6">

        <div class="user-crud-buttons">
            <form action="<?= Url::to(['admin/switch-identity']) ?>" method="post" style="display: inline-block">
                <input type="hidden" name="email" value="<?= $user->email ?>" />
                <input type="submit" title="Login as User" class="btn btn--primary m-t-0" value="Login as User" />
            </form>
            <form onsubmit="return sendResetPassword(this)" action="<?= Url::to(['site/request-password-reset']) ?>" class="inline-block m-t-0" method="post">
                <input type="hidden" name="PasswordResetRequestForm[email]" value="<?= $user->email ?>" />
                <input data-toggle="modal" data-target="#user-modal" type="submit" title="Reset Password for User" class="btn btn--primary m-t-0" value="Reset Password for User"<?= $user->active === User::STATUS_DELETED? ' disabled="true"' : '' ?> />
            </form>

            <?php if (!$isReseller) { ?>
                <a href="<?= Url::to(['admin/users']) ?>" class="btn btn--primary background--danger" data-user-id="<?= $user->id ?>" onclick="return removeUserViaAjax(this)">
                    <span class="btn__text">Delete User</span>
                </a>
            <?php } ?>
        </div>

        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'subdomain') ?>

            <?= FormHelper::stackActiveDropDown($form->field($model, 'status')->dropDownList([
                0 => 'Cancelled',
                1 => 'Active',
            ])); ?>

        <?php if (!$isReseller) { ?>
            <?= $form->field($model, 'date_suspend')->widget(DatePicker::className(), [
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control',],
            ]) ?>
            <?= $form->field($model, 'cancel_date')->widget(DatePicker::className(), [
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control',],
            ]) ?>
            <?= $form->field($model, 'scan_limit') ?>
            <?= $form->field($model, 'scan_page_limit') ?>
            <?= FormHelper::stackActiveDropDown($form->field($model, 'reseller_id')->dropDownList(ArrayHelper::merge(
                [
                    '0' => 'Not Set',
                ],
                ArrayHelper::map(
                    User::find()
                        ->where([
                            'id' => Yii::$app->authManager->getUserIdsByRole(app\models\User::ROLE_RESELLER),
                        ])
                        ->all(),
                    'id',
                    'email'
                )
            ))) ?>

            <h4>User Roles</h4>
            <div class="table-responsive">
                <table class="table-roles table--round datatable-buttons border--round table--alternate-row dataTable no-footer">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (Yii::$app->authManager->getRolesByUser($user->id) as $role) {
                            echo '<tr><td>'.$role->description.'</td><td>'.date('Y-m-d H:i:s', $role->createdAt).'</td></tr>';
                        } ?>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="col-md-6">
                        <?= FormHelper::stackActiveDropDown($form->field($model, 'role_name')->dropDownList($roleItems)) ?>
                    </div>
                    <div class="col-md-6">
                        <?= FormHelper::stackActiveDropDown($form->field($model, 'role_action')->dropDownList([
                            0 => 'Please Choose Action',
                            'assign' => 'Assign',
                            'revoke' => 'Revoke',
                        ])) ?>
                    </div>
                </div>
            </div>
        <?php } ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn--primary width100']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="col-md-6"><?= \yii\widgets\DetailView::widget([
        'model' => $user,
        'attributes' => $detailViewColumns,
        'options' => [
            'class' => 'border--round table--alternate-row',
        ],
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
    ]) ?></div>
</div>
<div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button>
                Reset password email has been sent.
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function sendResetPassword(form) {
        $.post($(form).attr('action'), $(form).serialize());
        return false;
    }
    function removeUserViaAjax(el) {
        var result = confirm("Are you sure you want to delete this user and their data?");
        if (result) {
            $.post('/delete-user.inc', {'id' : $(el).data('user-id')});
        }
        return result;
    }
</script>
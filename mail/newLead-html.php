<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model \app\models\AgencyLead */
/* @var $agency \app\models\Agency */
/* @var $title string */
$this->title = $title;
?>
<p>You've received a New Lead via the embedded form on your website. Lead details are below:</p>
<table style="border: none">
    <tr><td><b>Website:</b></td><td style="padding-left: 10px"><?= $model->domain ?></td></tr>
    <?= $model->email ? "<tr><td><b>Email:</b></td><td style='padding-left: 10px'>{$model->email}</td></tr>" : '' ?>
    <?= $model->phone ? "<tr><td><b>Phone:</b></td><td style='padding-left: 10px'>{$model->phone}</td></tr>" : '' ?>
    <?= $model->first_name ? "<tr><td><b>First Name:</b></td><td style='padding-left: 10px'>{$model->first_name}</td></tr>" : '' ?>
    <?= $model->last_name ? "<tr><td><b>Last Name:</b></td><td style='padding-left: 10px'>{$model->last_name}</td></tr>" : '' ?>
    <?= $model->custom_field ? "<tr><td><b>{$agency->embed_custom_field}:</b></td><td style='padding-left: 10px'>{$model->custom_field}</td></tr>" : '' ?>
</table>

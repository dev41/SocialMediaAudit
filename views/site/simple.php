<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

if (empty($name)) {
    $name = 'Page not found';
}
$this->title = $name;
?>
<div class="container" style="margin-top: 100px;">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet">
                <div class="portlet-heading bg-brown">
                    <h2 class="section-title"><?= Html::encode($this->title) ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="portlet-body">
                    <?= $message ?>
                </div>
            </div>
        </div>
    </div>
</div>
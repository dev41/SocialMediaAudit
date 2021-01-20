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
<div class="col-md-12">
    <?= $message ?>
</div>

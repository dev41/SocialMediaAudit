<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $password string */

$this->title = 'Welcome to SocialMediaAudit';
?>
<div>
    <p>Hi <?= Html::encode($user->fullName) ?>,</p>

    <p>An account has been created for you at <a href="https://www.socialmediaaudit.io" target="_blank">socialmediaaudit.io</a>. You can login using the following details:</p>
    <p>User Email: <?= Html::encode($user->email) ?><br>
    User Password: <?= Html::encode($password) ?></p>
</div>
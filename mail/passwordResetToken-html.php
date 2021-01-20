<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $title string */
$this->title = $title;
/* $resetLink = 'https://'.Yii::$app->params['domain'].Yii::$app->urlManager->createUrl([ @todo @merge 03.09.2018 */
$resetLink = 'https://'.Yii::$app->request->getCorrectDomain().Yii::$app->urlManager->createUrl([
    'site/reset-password',
    'token' => $user->token,
]);
$this->title = 'Password reset';
?>
<div class="password-reset">
    <p>Hi <?= Html::encode($user->fullName) ?>,</p>

    <p>Please click the following link to reset your password:</p>

    <p style="margin-bottom: 0;"><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
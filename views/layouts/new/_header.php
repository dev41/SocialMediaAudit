<?php

use app\helpers\FormHelper;
use app\models\ReportForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use app\models\User;
/**
 * @var View $this
 * @var $reportForm \app\models\ReportForm
 */

$reportForm = new ReportForm();
?>

<div class="bg--dark sma-navbar">

    <div class="sma-logo-container">
        <div class="sma-logo"></div>
    </div>

    <div class="sma-navbar-audit-form-container">
        <?php $form = ActiveForm::begin(['id' => 'report-form', 'layout' => 'inline', 'action' => '/']); ?>
        <?= FormHelper::stackActiveDropDown($form->field($reportForm, 'mode')->dropDownList([
            'website' => 'Website',
            'facebook' => 'Facebook Profile',
            'twitter' => 'Twitter Profile',
            'youtube' => 'YouTube Profile',
            'instagram' => 'Instagram Profile',
            'linkedin' => 'LinkedIn Profile',
        ])->label(false)) ?>
        <?= $form->field($reportForm, 'value', ['options' => ['class' => 'audit-search-field'],
            'template' => '{input}
                <a href="" class="audit-search-button" onclick="$(this).closest(\'form\').submit();return false">
                    <i class="fa fa-search"></i>
                </a>',
            ])->textInput([
                'placeholder' => 'Run a Quick Audit...',
            ])->label(false) ?>

        <?php ActiveForm::end(); ?>
    </div>

    <?php if (Yii::$app->user->isGuest): ?>
        <div class="">
            <ul class="sma-navbar-menu-links">
                <li>
                    <a href="/features"><?= Yii::t('app', 'Features') ?></a>
                </li>
                <li>
                    <a href="/pricing"><?= Yii::t('app', 'Pricing') ?></a>
                </li>
            </ul>

            <div class="sma-navbar-login-buttons">
                <?= Html::a('<span class="btn__text">' . Yii::t('app', 'Log In') . '</span>', Url::to('/login'), [
                    'class' => 'btn btn--sm type--uppercase',
                ]) ?>

                <?= Html::a('<span class="btn__text">' . Yii::t('app', 'Register') . '</span>', Url::to('/register'), [
                    'class' => 'btn btn--primary btn--sm type--uppercase',
                ]) ?>
            </div>
        </div>
    <?php endif; ?>

    <?= $this->render('/layouts/partial/_navbar_user_menu') ?>

</div>
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

<div class="sma-navbar navbar--white border">

    <a href="/">
        <div class="sma-logo-container">
            <div class="sma-dark-logo"></div>
        </div>
    </a>

    <?php if (Yii::$app->user->isGuest): ?>

        <div class="sma-navbar-login-buttons">
            <?= Html::a('<span class="btn__text">' . Yii::t('app', 'Log In') . '</span>', Url::to('/login'), [
                'class' => 'btn btn--sm type--uppercase',
            ]) ?>

            <?= Html::a('<span class="btn__text">' . Yii::t('app', 'Sign Up - Free Trial') . '</span>', Url::to('/register'), [
                'class' => 'btn btn--primary background--warning btn--sm type--uppercase',
            ]) ?>
        </div>

        <ul class="menu-horizontal sma-navbar-menu-auth d-none float-right m-t-4">
            <li class="dropdown">
                <i class="icon icon--sm stack-interface stack-menu"></i>
                <div class="dropdown__container">
                    <div class="dropdown__content">
                        <ul class="menu-vertical">
                            <li>
                                <?= Html::a('<span class="btn__text">' . Yii::t('app', 'Log In') . '<span>',
                                    Url::to('/login'),
                                    ['class' => 'waves-block']
                                ) ?>
                            </li>
                            <li>
                                <?= Html::a('<span class="btn__text">' . Yii::t('app', 'Sign up - Free Trial') . '</span>',
                                    Url::to('/register'),
                                    ['class' => 'waves-block']
                                ) ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>


    <?php endif; ?>

        <?= $this->render('/layouts/partial/_navbar_user_menu') ?>

    <?php

    ?>

</div>
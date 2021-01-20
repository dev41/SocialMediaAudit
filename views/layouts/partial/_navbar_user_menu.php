<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View @this
 * @var \yii\web\User $webUser
 */

$webUser = Yii::$app->user;
?>

<?php if (!$webUser->isGuest): ?>

<div class="sma-navbar-user-menu">

    <?php if ($webUser->can(User::ROLE_FREE)): ?>
        <?= Html::a('<span class="btn__text">' . Yii::t('app', 'Choose Plan') . '</span>', Url::to('/plan'), [
            'class' => 'sma-navbar-button-free btn btn--primary background--warning m-r-15',
        ]) ?>
    <?php endif; ?>

    <ul class="menu-horizontal sma-navbar-menu">
        <li class="dropdown">
            <span class="dropdown__trigger js-full-name">
                <i class="stack-interface stack-users"></i>
                <?= $webUser->identity->username ?? $webUser->identity->fullName ?>
            </span>
            <div class="dropdown__container">
                <div class="dropdown__content">
                    <ul class="menu-vertical">
                        <li>
                            <?= Html::a('<span class="btn__text">' . Yii::t('app', 'Account') . '</span>',
                                Url::to('/my-account'),
                                ['class' => 'waves-block']
                            ) ?>
                        </li>
                        <li>
                            <?= Html::a('<span class="btn__text">' . Yii::t('app', 'Logout') . '</span>',
                                Url::to('/logout'),
                                ['class' => 'waves-block']
                            ) ?>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>

</div>

<?php endif; ?>
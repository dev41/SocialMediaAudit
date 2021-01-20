<?php

use yii\helpers\Url;
use app\models\User;

$currentUrl = Yii::$app->request->url;
$currentUser = Yii::$app->user;
?>
<div class="left side-menu small-menu">
    <div class="sidebar-inner slimscrollleft">
        <div id="sidebar-menu">
            <ul>
                <?php if ( !$currentUser->identity->isSuspended() ) { ?>
                    <?php if ($currentUser->can(User::ROLE_BASIC)) { ?>
                        <li id="report-settings">
                            <a href="/report-settings" class="<?= $currentUrl == '/report-settings' ? 'active' : ''?>">
                                <i class="ti-pencil-alt"></i><span>Report Settings</span>
                            </a>
                        </li>
                        <li id="whitelabel-reports-settings">
                            <a href="/white-label-reports" class="<?= $currentUrl == '/white-label-reports'? 'active' : ''?>">
                                <i class="ti-files"></i><span>Whitelabel Reports</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($currentUser->can(User::ROLE_ADVANCED)) { ?>
                        <li id="embedding-settings">
                            <a href="/embedding-settings" class="<?= $currentUrl == '/embedding-settings' ? 'active' : ''?>">
                                <i class="ti-layout-cta-center"></i><span>Embedding Settings</span>
                            </a>
                        </li>
                        <li id="leads-settings">
                            <a href="/leads" class="<?= $currentUrl == '/leads' ? 'active' : ''?>">
                                <i class="ti-email"></i><span>Leads</span>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
                <?php if ( Yii::$app->request->isMainDomain() ){ ?>
                    <li id="account-settings">
                        <a href="<?= Url::to(['user/account']) ?>" class="<?= $currentUrl == Url::to(['user/account']) ? 'active' : ''?>"><i class="ti-settings"></i><span>My Account</span></a>
                    </li>
                <?php }else{
                    echo '<li my-account="'.Yii::$app->request->getSecondLevelDomain().'"></li>';
                } ?>
                <li><a href="/logout"><i class="ti-export"></i><span>Logout</span></a></li>
                <?php if (
                    $currentUser->can(User::ROLE_ADMIN) ||
                    $currentUser->can(User::ROLE_RESELLER)
                ) { ?>
                    <li class="subtitle">Administration</li>
                    <li><a href="/users" class="<?= $currentUrl == '/users' ? 'active' : ''?>"><i class="ti-user"></i><span>Users</span></a></li>
                    <?php if ($currentUser->can(User::ROLE_ADMIN)) { ?>
                        <li><a href="/queue" class="<?= $currentUrl == '/queue' ? 'active' : ''?>"><i class="ti-server"></i><span>Queue</span></a></li>
                    <?php } ?>
                <?php } ?>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
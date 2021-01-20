<?php
use yii\helpers\Json;
use app\models\Agency;

/* @var $this yii\web\View */
/* @var $profile string */
/* @var $activity array */

if ($activity !== false) {
    $exist = true;
    $existTitle = 'Profile exist';
    $existMessage = 'Profile is really exist with provided link.';

    if ($activity['subscribers'] >= 100) {
        $subscribers = true;
        $subscribeMessage = 'You have a strong level of activity on Profile.';
    } else {
        $subscribers = false;
        $subscribeMessage = 'You have a low level of activity on Profile';
    }
} else {
    $exist = false;
    $existTitle = 'Profile doesn\'t exist';
    $existMessage = 'Profile is not accessible or doesn\'t exist with provided link.';
}
?>

<div class="wrapper report-wrapper">

    <div class="container block tab-social" style="display: block">

        <div id="social" class="m-t-30">

            <h2><?= $profile. '\'s Result' ?></h2>


            <div class="row">
                <div class="col-xs-6 js-social-card-container">
                    <div class="boxed boxed--border boxed--lg">
                        <div class="faq-box field-hasTwitter">
                            <div class="row">

                                <div class="col-xs-11 col-sm-10">
                                    <div class="avoid-break-inside">
                                        <h4 class="report-section-fg-color report-header-font question" data-wow-delay=".1s"> <?= $existTitle ?></h4>
                                        <div class="answer field-value"><?= $existMessage ?></div>
                                    </div>
                                </div>
                                <div class="col-xs-1 padding-0 col-sm-2">
                                    <div class="widget-bg-color-icon">
                                        <div class="bg-icon pull-left bg-icon-<?= $exist? 'success' : 'danger' ?>">
                                            <i class="md"></i>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php if ($exist) { ?>
                <div class="col-xs-6 js-social-card-container">
                    <div class="boxed boxed--border boxed--lg">
                        <div class="faq-box field-twitterActivity">
                            <div class="row">

                                <div class="col-xs-11 col-sm-10">
                                    <div class="avoid-break-inside">
                                        <h4 class="report-section-fg-color report-header-font question" data-wow-delay=".1s"><?= Yii::t('report', 'Profile Activity')?></h4>
                                        <div class="answer field-value">
                                            <?= $subscribeMessage ?>
                                            <br><br>
                                            <div class="activity-item" align="center">
                                                <div class="item-content">
                                                    <p class="value-item"><?= $activity['subscribers'] ?></p>
                                                    <p class="title-item">Subscribers</p></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-1 padding-0 col-sm-2">
                                    <div class="widget-bg-color-icon">
                                        <div class="bg-icon pull-left bg-icon-<?= $subscribers? 'success' : 'danger' ?>">
                                            <i class="md"></i>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


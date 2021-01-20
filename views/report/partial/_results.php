<?php

use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $agency \app\models\Agency */
/* @var $website \app\models\Website */

$domain = $website->domain;

$guestAccount = Yii::$app->user->isGuest;
$suspendedAccount = false;
$pdf = false;
$popover = "popover";
$shareUrl = Yii::$app->urlManager->createAbsoluteUrl('').$domain;

if (($identity = Yii::$app->user->identity) && $identity->isSuspended()){
    $suspendedAccount = true;
}

if ( $guestAccount || $suspendedAccount) {
    $fullAccount = false;
} else {
    $fullAccount = true;
}

if (Yii::$app->user->can(\app\models\User::ROLE_BASIC)) {
    $popover = "";
    $pdf = '//'.Yii::$app->user->identity->agency->subdomain.'.'.Yii::$app->params['domain'];
}

?>

<h2 class="m-l-10 report-section-fg-color report-header-font" data-origin='<?= $website->originalDomain ?>'>
    <?= Yii::t('report', '{domain}\'s Result', ['domain' => $website->originalDomain]) ?>
</h2>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="boxed boxed--border boxed--md audit-result-box">

                <div class="row m-l-15 m-r-15">

                    <div class="col-xs-4 text-center">
                        <div class="js-website-result-chart radial" data-value="0" data-timing="1000" data-color="<?= $this->params['chartColor'] ?>" data-size="200" data-bar-width="10">
                            <span class="h3 radial__label">0%</span>
                        </div>
                        <strong class="website-score-message"></strong>
                    </div>

                    <div class="col-xs-8 p-0">

                        <div class="row result-radials">
                            <div class="col-lg-2_4 col-md-4 col-sm-6 col-xs-6 js-social-card-container m-b-30">
                                <div class="text-center">
                                    <div class="js-facebook-result-chart m-b-5 radial" data-value="0" data-size="110" data-color="<?= $this->params['chartColor'] ?>">
                                        <span class="h4 radial__label">0%</span>
                                    </div>
                                    <div><?= Yii::t('report', 'Facebook')?></div>
                                </div>
                            </div>
                            <div class="col-lg-2_4 col-md-4 col-sm-6 col-xs-6 js-social-card-container m-b-30">
                                <div class="text-center">
                                    <div class="js-twitter-result-chart m-b-5 radial" data-value="0" data-size="110" data-color="<?= $this->params['chartColor'] ?>">
                                        <span class="h4 radial__label">0%</span>
                                    </div>
                                    <div><?= Yii::t('report', 'Twitter')?></div>
                                </div>
                            </div>
                            <div class="col-lg-2_4 col-md-4 col-sm-6 col-xs-6 js-social-card-container m-b-30">
                                <div class="text-center">
                                    <div class="js-youtube-result-chart m-b-5 radial" data-value="0" data-size="110" data-color="<?= $this->params['chartColor'] ?>">
                                        <span class="h4 radial__label">0%</span>
                                    </div>
                                    <div><?= Yii::t('report', 'YouTube')?></div>
                                </div>
                            </div>
                            <div class="col-lg-2_4 col-md-4 col-sm-6 col-xs-6 js-social-card-container m-b-30">
                                <div class="text-center">
                                    <div class="js-instagram-result-chart m-b-5 radial" data-value="0" data-size="110" data-color="<?= $this->params['chartColor'] ?>">
                                        <span class="h4 radial__label">0%</span>
                                    </div>
                                    <div><?= Yii::t('report', 'Instagram')?></div>
                                </div>
                            </div>
                            <div class="col-lg-2_4 col-md-4 col-sm-6 col-xs-6 js-social-card-container m-b-30">
                                <div class="text-center">
                                    <div class="js-linkedin-result-chart m-b-5 radial" data-value="0" data-size="110" data-color="<?= $this->params['chartColor'] ?>">
                                        <span class="h4 radial__label">0%</span>
                                    </div>
                                    <div><?= Yii::t('report', 'LinkedIn')?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <a href="#recommendation"
                                   class="scroll alert btn-improve-recommendations"
                                   style="<?= $agency && !$agency->show_recommendations? 'display:none;' : '' ?>">
                                    <?= Yii::t('report', 'You have {number} Recommendations', [
                                            'number' => '<span id="recommendation_count" count="0">0</span>'
                                    ]) ?>
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 text-right block-time">
                                <?= Html::beginForm('', 'post', ['class' => 'd-inline-block']) ?>
                                <input name="refresh" value="1" type="hidden">
                                <input name="wid" value="<?= $website->id ?>" type="hidden">
                                <strong>Report Generated: <span id="refresh_time"><?= $website->modified_report_format ?></span></strong>
                                <button type="submit" class="btn btn--primary btn-refresh-results report-fg-color--bg">
                                    Refresh Results Now
                                </button>
                                <?= Html::endForm() ?>
                            </div>
                        </div>

                    </div>

                </div>

                <?php if (!$agency): ?>
                    <div class="audit-result-buttons">
                    <div class="--left-buttons">

                            <?= \app\widgets\downloadPdf\DownloadPdfWidget::widget([
                                'website' => $website,
                            ]) ?>

                            <a id="embed-btn" type="button" class="btn btn--primary report-fg-color--bg" title="Embed Into Your Website"
                               data-visibility="hidden" href="#"
                                <?= $suspendedAccount ? 'disabled' : '' ?>
                                <?= $suspendedAccount ? '' : "href='/dashboard#embedding' " ?>
                               data="<?= !Yii::$app->user->can(\app\models\User::ROLE_ADVANCED) ? 'popover' : '' ?>">
                            <span class="btn__text">
                                <?= Yii::t('app', 'Embed Into Your Website') ?>
                            </span>
                            </a>
                    </div>

                    <div class="--right-buttons">

                        <a class="btn btn--primary-2 btn-shared_link" id="copy_link" href="#" data-clipboard-text="<?= $shareUrl ?>">
                            <span class="btn__text">
                                <?= Yii::t('app', 'Copy Report URL') ?>
                            </span>
                        </a>

                        <i class="shared_link_error" style="display:none;">Your link was copied to clipboard</i>

                        <a class="btn btn--icon bg--facebook" target="_blank"
                           href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>&amp;src=sdkpreparse">
                            <div class="btn__text"
                                 data-href="<?= $shareUrl ?>" data-layout="button"
                                 data-size="large" data-mobile-iframe="true">
                                <i class="socicon socicon-facebook"></i>
                                <?= Yii::t('app', 'Facebook') ?>
                            </div>
                        </a>

                        <a class="btn btn--icon bg--twitter"
                           href="https://twitter.com/share"
                           data-size="large"
                           data-text="custom share text"
                           data-url="<?= $shareUrl ?>"
                           data-hashtags="example,demo"
                           data-via="twitterdev"
                           target="_blank"
                           data-related="twitterapi,twitter">
                        <span class="btn__text">
                            <i class="socicon socicon-twitter"></i>
                            <?= Yii::t('app', 'Twitter') ?>
                        </span>
                        </a>

                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

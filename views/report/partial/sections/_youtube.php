<?php

/* @var $this yii\web\View */
/* @var $agency \app\models\Agency */


?>
<div id="youtube" class="container tab-youtube nowrap js-content-tab hidden">
    <div class="col-xs-12">
        <h2 class="report-section-fg-color report-header-font"><?= Yii::t('report', 'YouTube Results')?></h2>
    </div>

    <div class="col-xs-12 display-hide js-social-card-container m-b-30">

        <div class="col-xs-4 text-center">
            <div class="js-youtube-result-chart radial" data-value="0" data-timing="1000" data-color="<?= $this->params['chartColor'] ?>" data-size="200" data-bar-width="10">
                <span class="h3 radial__label">0%</span>
            </div>
        </div>

        <div class="col-xs-8  field-youtubeActivity">
            <h5 class="answer social-score-message"></h5>
            <p class="social-score-description"></p>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-hasYoutube">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="report-section-fg-color report-header-font question" data-wow-delay=".1s"><?= Yii::t('report', '{serviceName} Connected', ['serviceName' => 'YouTube'])?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-1 padding-0 col-sm-2">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <h3><?= Yii::t('report', 'Profile')?></h3>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-youtubeTitle">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Channel Title')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-1 padding-0 col-sm-2">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-youtubeDescription">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Description Text')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-1 padding-0 col-sm-2">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-youtubeCountry">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Channel Country')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-1 padding-0 col-sm-2">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <h3><?= Yii::t('report', 'Content')?></h3>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-youtubeVideos">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Number of Videos')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-1 padding-0 col-sm-2">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-youtubeRecentVideosFrequency">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Posting Frequency')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-1 padding-0 col-sm-2">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="youtube-recent-details"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-youtubeRecentVideoCompletion">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Video Completeness')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-1 padding-0 col-sm-2">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <p></p>
                    <div class="youtube-recent-details"></div>
                    <?= !$agency || $agency->show_details ? '<div class="field-details"></div>' : '' ?>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <h3><?= Yii::t('report', 'Engagement')?></h3>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-youtubeSubscribers">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Channel Subscribers')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-1 padding-0 col-sm-2">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-youtubeRecentVideosViews">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Average Video Views')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-1 padding-0 col-sm-2">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="youtube-recent-details"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-youtubeRecentVideosLikes">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="report-section-fg-color report-header-font question" data-wow-delay=".1s"><?= Yii::t('report', 'Average Video Likes')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-1 padding-0 col-sm-2">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="youtube-recent-details"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-youtubeRecentVideosComments">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Average Video Comments')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-1 padding-0 col-sm-2">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="youtube-recent-details"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-youtubeRecentBestVideos">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Best Videos')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-1 padding-0 col-sm-2">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row field-details"></div>
                    <div class="youtube-recent-details"></div>
                </div>
            </div>
        </div>
    </div>

</div>
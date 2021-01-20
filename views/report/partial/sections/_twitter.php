<?php

/* @var $this yii\web\View */
/* @var $agency \app\models\Agency */


?>
<div id="twitter" class="container tab-twitter nowrap js-content-tab hidden">
    <div class="col-xs-12">
        <h2 class="report-section-fg-color report-header-font"><?= Yii::t('report', 'Twitter Results')?></h2>
    </div>

    <div class="col-xs-12 display-hide js-social-card-container m-b-30">
        <div class="col-xs-4 text-center">
            <div class="js-twitter-result-chart radial" data-value="0" data-timing="1000" data-color="<?= $this->params['chartColor'] ?>" data-size="200" data-bar-width="10">
                <span class="h3 radial__label">0%</span>
            </div>
        </div>

        <div class="col-xs-8 field-twitterActivity">
            <h5 class="answer social-score-message"></h5>
            <p class="social-score-description"></p>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 display-hide js-social-card-container">

            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-hasTwitter">
                    <div class="row">

                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="report-section-fg-color report-header-font question" data-wow-delay=".1s"><?= Yii::t('report', '{serviceName} Connected', ['serviceName' => 'Twitter'])?></h4>
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
                <div class="faq-box field-twitterDescription">
                    <div class="row">

                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'About Blurb')?></h4>
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
                <div class="faq-box field-twitterExternalUrl">
                    <div class="row">

                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="report-section-fg-color report-header-font question" data-wow-delay=".1s"><?= Yii::t('report', 'External Url')?></h4>
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
                <div class="faq-box field-twitterProfilePicture">
                    <div class="row">

                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Profile Picture')?></h4>
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
                <div class="faq-box field-twitterHeaderPicture">
                    <div class="row">

                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Header Picture')?></h4>
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
                <div class="faq-box field-twitterLocation">
                    <div class="row">

                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Location')?></h4>
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
                <div class="faq-box field-twitterTweetsNumber">
                    <div class="row">

                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Number of Tweets')?></h4>
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
                <div class="faq-box field-twitterRecentPostsFrequency">
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
                    <div class="twitter-recent-details"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <h3><?= Yii::t('report', 'Engagement')?></h3>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-twitterFollowers">
                    <div class="row">

                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Number of Followers')?></h4>
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
                <div class="faq-box field-twitterLikesNumber">
                    <div class="row">

                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Number of Likes')?></h4>
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
                <div class="faq-box field-twitterRecentPostsLength">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Average Post Length')?></h4>
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
                    <div class="twitter-recent-details"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-twitterRecentPostsLikes">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Post Likes')?></h4>
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
                    <div class="twitter-recent-details"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-twitterRecentPostsRetweets">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Recent Posts Retweets')?></h4>
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
                    <div class="twitter-recent-details"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-twitterRecentPostsVariety">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Recent Posts Variety')?></h4>
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
                    <div class="field-details"></div>
                    <div class="twitter-recent-details"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-twitterRecentBestPosts">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Recent Best Posts')?></h4>
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
                    <div class="twitter-recent-details"></div>
                </div>
            </div>
        </div>


    </div>

</div>
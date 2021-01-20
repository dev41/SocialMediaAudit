<?php

/* @var $this yii\web\View */
/* @var $agency \app\models\Agency */


?>
<div id="instagram" class="container tab-instagram nowrap js-content-tab hidden">
    <div class="col-xs-12">
        <h2 class="report-section-fg-color report-header-font"><?= Yii::t('report', 'Instagram Results')?></h2>
    </div>

    <div class="col-xs-12 display-hide js-social-card-container m-b-30">
        <div class="col-xs-4 text-center">
            <div class="js-instagram-result-chart radial" data-value="0" data-timing="1000" data-color="<?= $this->params['chartColor'] ?>" data-size="200" data-bar-width="10">
                <span class="h3 radial__label">0%</span>
            </div>
        </div>

        <div class="col-xs-8 field-instagramActivity">
            <h5 class="answer social-score-message"></h5>
            <p class="social-score-description"></p>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-hasInstagram">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="report-section-fg-color report-header-font question" data-wow-delay=".1s"><?= Yii::t('report', '{serviceName} Connected', ['serviceName' => 'Instagram'])?></h4>
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
                <div class="faq-box field-instagramActivity">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="report-section-fg-color report-header-font question" data-wow-delay=".1s"><?= Yii::t('report', '{serviceName} Activity', ['serviceName' => 'Instagram'])?></h4>
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
                <div class="faq-box field-instagramUsername">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Username')?></h4>
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
                <div class="faq-box field-instagramVerified">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Is verified')?></h4>
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
                <div class="faq-box field-instagramProfilePicture">
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
                <div class="faq-box field-instagramTitle">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Description Title')?></h4>
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
                <div class="faq-box field-instagramDescription">
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
                <div class="faq-box field-instagramExternalUrl">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'External Url')?></h4>
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
                <div class="faq-box field-instagramPostsNumber">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Posts Number')?></h4>
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
                <div class="faq-box field-instagramRecentPostsFrequency">
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
                    <div class="instagram-recent-details"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-instagramRecentPostsLength">
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
                    <div class="instagram-recent-details"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <h3><?= Yii::t('report', 'Engagement')?></h3>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-instagramFollowers">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Followers Number')?></h4>
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
                <div class="faq-box field-instagramFollowings">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Followings Number')?></h4>
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
                <div class="faq-box field-instagramRecentPostsLikes">
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
                    <div class="instagram-recent-details"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-instagramRecentPostsComments">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Post Comments')?></h4>
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
                    <div class="instagram-recent-details"></div>
                </div>
            </div>
        </div>

    </div>

</div>
<?php

/* @var $this yii\web\View */
/* @var $agency \app\models\Agency */


?>
<div id="facebook" class="container tab-facebook nowrap js-content-tab hidden">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="report-section-fg-color report-header-font"><?= Yii::t('report', 'Facebook Results')?></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 display-hide js-social-card-container m-b-30">
            <div class="col-xs-4 text-center">
                <div class="js-facebook-result-chart radial" data-value="0" data-timing="1000" data-color="<?= $this->params['chartColor'] ?>" data-size="200" data-bar-width="10">
                    <span class="h3 radial__label">0%</span>
                </div>
            </div>

            <div class="col-xs-8 field-facebookActivity">
                <h5 class="answer social-score-message"></h5>
                <p class="social-score-description"></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-hasFacebook">
                    <div class="col-xs-10">
                        <div class="avoid-break-inside">
                            <h4 class="report-section-fg-color report-header-font question"
                                data-wow-delay=".1s"><?= Yii::t('report', '{serviceName} Connected', ['serviceName' => 'Facebook']) ?></h4>
                            <div class="answer field-value"></div>
                        </div>
                    </div>
                    <div class="col-xs-2 padding-0">
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

    <div class="row">
        <div class="col-xs-12">
            <h3><?= Yii::t('report', 'Cover page')?></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookProfilePicture">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Profile Picture')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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

        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookCoverPhoto">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Cover Photo')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookUsername">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Username')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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

        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookVerified">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Verified')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3><?= Yii::t('report', 'About')?></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookContactPhone">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="report-section-fg-color report-header-font question" data-wow-delay=".1s"><?= Yii::t('report', 'Contact phone')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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

        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookContactWebsite">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Contact website')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookContactEmail">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Contact email')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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

        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookAboutText">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'About text')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookCompanyOverviewText">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Company Overview text')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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

        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookProductsText">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Products text')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookMissionText">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Mission text')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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

        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookMilestonesText">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Milestones text')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookLocation">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Location')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3><?= Yii::t('report', 'Content')?></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookRecentPostsFrequency">
                    <div class="row">
                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Posting Frequency')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="facebook-recent-details"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookRecentPostsLength">
                    <div class="row">
                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Average Post Length')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="facebook-recent-details"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3><?= Yii::t('report', 'Engagement')?></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookLikes">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Likes')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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

        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookFollows">
                    <div class="row">

                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Follows')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
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
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookRecentPostsLikes">
                    <div class="row">
                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Post Likes')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="facebook-recent-details"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookRecentPostsComments">
                    <div class="row">
                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Post Comments')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="facebook-recent-details"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-facebookRecentPostsVariety">
                    <div class="row">
                        <div class="col-xs-10">
                            <div class="avoid-break-inside">
                                <h4 class="question" data-wow-delay=".1s"><?= Yii::t('report', 'Post Variety')?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-2 padding-0">
                            <div class="widget-bg-color-icon">
                                <div class="bg-icon pull-left">
                                    <i class="md"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="field-details"></div>
                    <div class="facebook-recent-details"></div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php

/* @var $this yii\web\View */
/* @var $agency \app\models\Agency */


?>
<div id="linkedin" class="container tab-linkedin nowrap js-content-tab hidden">

    <div class="col-xs-12">
        <h2 class="report-section-fg-color report-header-font"><?= Yii::t('report', 'LinkedIn Results')?></h2>
    </div>

    <div class="col-xs-12 display-hide js-social-card-container m-b-30">
        <div class="col-xs-4 text-center">
            <div class="js-linkedin-result-chart radial" data-value="0" data-timing="1000" data-color="<?= $this->params['chartColor'] ?>" data-size="200" data-bar-width="10">
                <span class="h3 radial__label">0%</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 display-hide js-social-card-container">
            <div class="boxed boxed--border boxed--lg">
                <div class="faq-box field-hasLinkedIn avoid-break-inside">
                    <div class="row">
                        <div class="col-xs-11 col-sm-10">
                            <div class="avoid-break-inside">
                                <h4 class="report-section-fg-color report-header-font question" data-wow-delay=".1s"><?= Yii::t('report', '{serviceName} Connected', ['serviceName' => 'LinkedIn'])?></h4>
                                <div class="answer field-value"></div>
                            </div>
                        </div>
                        <div class="col-xs-1 padding-0">
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

</div>
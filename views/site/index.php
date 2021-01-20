<?php

use app\helpers\FormHelper;
use app\models\Plan;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/**
 * @var $this yii\web\View
 * @var $model \app\models\ReportForm
 * @var Plan $planBasic
 * @var Plan $planAdvanced
 */

$this->title = 'Social Media Audit';
?>

<?= $this->render('/layouts/new/_main_header') ?>

<div class="site-index">
    <div class="main-container">
        <section class="text-center">
                <div class="row">
                    <div class="col-md-12 m-r-15 m-l-15">
                        <h1>Social Media Audit & Lead Gen Tool</h1>
                        <p class="lead">Review a Prospect’s Social Profiles in seconds and Win More Business</p>
                        <p class="lead">
                            Enter a Company's Website or Social Profile to <b>Try it Now</b>
                        </p>
                    </div>
                    <br>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                        <br class="hidden-xs hidden-sm" />
                        <?php $form = ActiveForm::begin(['id' => 'report-form', 'layout' => 'inline']); ?>
                        <div>
                            <div class="row">
                                <div class="col-sm-5 col-xs-12 p-0 p-r-15 m-b-10 p-xs-0">
                                    <?= FormHelper::stackActiveDropDown($form->field($model, 'mode',
                                        [
                                            'options' => [
                                                'class' => 'required has-success h-45 width100',
                                            ]
                                        ])->dropDownList([
                                            'website' => 'Website',
                                            'facebook' => 'Facebook Profile',
                                            'twitter' => 'Twitter Profile',
                                            'youtube' => 'YouTube Profile',
                                            'instagram' => 'Instagram Profile',
                                            'linkedin' => 'LinkedIn Profile',
                                        ], [
                                            'class' => 'h-45 default-height'
                                        ])->label(false))
                                    ?>
                                </div>

                                <div class="col-sm-5 col-xs-12 p-0 p-r-15 m-b-10 p-xs-0">
                                    <?= $form->field($model, 'value', [
                                        'options' => ['class' => 'h-45 width100'],
                                    ])->textInput([
                                        'class' => 'h-45 width100',
                                    ])->label(false) ?>
                                </div>

                                <div class="col-sm-2 col-xs-12 p-0">
                                    <?= Html::submitButton('Go', [
                                        'class' => 'btn btn--lg btn--primary m-t-0 h-45 width100',
                                    ]) ?>
                                </div>

                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
        </section>

        <section class="text-center" style="margin-bottom: 15px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-9">
                        <div class="bg--dark box-shadow-wide">
                            <img alt="Image" src="http://trystack.mediumra.re/img/software-1.jpg" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="switchable feature-large pb-on-small p-r-30 p-l-30">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-5 pt-on-small">
                        <div class="switchable__text">
                            <h2>What does it do?</h2>
                            <p class="lead">
                                Social Media Audit reviews a brand’s Facebook, Twitter, Instagram and YouTube profiles, providing a comprehensive one-page report and audit score in around 20 seconds.
                            </p>
                            <p class="lead">
                                Simply enter a Company’s Website URL, and we’ll automatically extract all the Social Profiles we can find. Alternatively, you can run audits on specific Social Profiles.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <img alt="Image" class="border--round custom-gif-align" src="https://promosimple.com/frontend/img/cloud.png" />
                    </div>
                </div>
            </div>
        </section>

        <section class="switchable feature-large pb-on-small p-r-30 p-l-30">
            <div class="container">
                <div class="row d-flex-column flex-column">
                    <div class="col-sm-6 order-md-2 order-2">
                        <img alt="Image" src="https://promosimple.com/frontend/img/character-functions1.png" class="character-functions"/>
                    </div>
                    <div class="col-sm-6 col-md-5 order-md-1 order-1">
                        <div class="switchable__text">
                            <h2>What do we Audit?</h2>
                            <p class="lead">
                                We’ll comprehensively assess every Social Media Profile for:
                            </p>
                            <p class="lead">
                                <b>Completeness</b> - Is the profile complete with brand imagery, contact information and website links?
                            </p>
                            <p class="lead">
                                <b>Content</b> - Is your content diverse and frequent enough to gain attention?
                            </p>
                            <p class="lead">
                                <b>Engagement</b> - Are users sufficiently engaging with your content in the way of likes and comments?
                            </p>
                            <p class="lead">
                                <b>Missing Profiles</b> - Are all your Social Profiles present and linked on your website?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="switchable feature-large pb-on-small p-r-30 p-l-30">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-5 pt-on-small">
                        <div class="switchable__text">
                            <h2>Beautiful, Branded White Label PDF Reports </h2>
                            <p class="lead">
                                Get a comprehensive Social Media Audit in PDF in seconds.
                            </p>
                            <p class="lead">
                                Brand it as your own by uploading your logo, adding company details and adjusting styling to suit.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <img alt="Image" class="border--round custom-gif-align" src="https://promosimple.com/frontend/img/cloud.png" />
                    </div>
                </div>
            </div>
        </section>

        <section class="switchable feature-large pb-on-small p-r-30 p-l-30">
            <div class="container">
                <div class="row d-flex-column">
                    <div class="col-sm-6 order-2">
                        <img alt="Image" src="https://promosimple.com/frontend/img/character-functions1.png" class="character-functions"/>
                    </div>
                    <div class="col-sm-6 col-md-5 order-1">
                        <div class="switchable__text">
                            <h2>Full Report Customizability</h2>
                            <p class="lead">
                                Don’t want to include something in the report? No problem - you can choose to add or remove specific checks and pieces of content from the report
                            </p>
                            <p class="lead">
                                Add your own title and introductory text content.
                            </p>
                            <p class="lead">
                                Reports are professionally presented and written in simple language that inspires action.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="switchable feature-large pb-on-small p-r-30 p-l-30">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-5 pt-on-small">
                        <div class="switchable__text">
                            <h2>Embed a Social Media Audit Tool into your Website</h2>
                            <p class="lead">
                                10x Your Leads with our simple Lead Generation Widget.
                            </p>
                            <p class="lead">
                                Design a beautiful Audit Form that matches your website’s styling and colors.
                            </p>
                            <p class="lead">
                                Instantly present a branded Social Media Audit which inspires action, within your site.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <img alt="Image" class="border--round custom-gif-align" src="https://promosimple.com/frontend/img/cloud.png" />
                    </div>
                </div>
            </div>
        </section>

        <section class="switchable feature-large pb-on-small p-r-30 p-l-30">
            <div class="container">
                <div class="row d-flex-column">
                    <div class="col-sm-6 pb-on-small order-2">
                        <img alt="Image" src="https://promosimple.com/frontend/img/character-functions1.png" class="character-functions"/>
                    </div>
                    <div class="col-sm-6 col-md-5 order-1">
                        <div class="switchable__text">
                            <h2>The Ultimate Lead Generator</h2>
                            <p class="lead">
                                Get notified of new leads and their details straight to your mailbox.
                            </p>
                            <p class="lead">
                                Access all your leads in our Dashboard, or export them in Excel, CSV and PDF.
                            </p>
                            <p class="lead">
                                Use our Web Hook technology to send your leads and their Audits straight to any other CRM, mail tool like Hubspot, MailChimp or Salesforce as they arrive.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="home-info-block p-t-25 p-b-25 m-t-25 bg--primary">
            <div class="container bg--primary">
                <div class="row justify-content-around">
                    <div class="text-left">
                        <div class="m-l-35 m-r-35">
                            <h1 class="color--white">Who’s it for</h1>
                            <h4 class="color--white">
                                <b>Social Media Agencies, Digital Agencies & Freelancers</b> - Stop doing manual, time-consuming audits.
                                Engage more prospects with a conversation starter and win more clients.
                            </h4>
                            <h4 class="color--white">
                                <b>Business Owners</b> - Fill the gaps in your Social Profiles and maximise your Social Presence for business
                                success.
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <section class="height">
                <div class="container pos-vertical">

                    <?= $this->render('/plan/partial/_plans', [
                        'planBasic' => $planBasic,
                        'planAdvanced' => $planAdvanced,
                        'prefill' => true,
                    ]) ?>

                </div>
            </section>

        <?= $this->render('/layouts/new/_footer') ?>

    </div>
</div>


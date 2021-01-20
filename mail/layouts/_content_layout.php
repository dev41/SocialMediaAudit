<?php

use app\helpers\BaseHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var View $this */
/* @var string $content */

$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
$homeUrl = $protocol . 'www.' . Yii::$app->params['domain'];

$params = empty($this->params) ? [] : (array) $this->params;

$title = Html::encode($title ?? $this->title);

$showLogo = $showLogo ?? !isset($params['show_logo']) || $params['show_logo'] == 1;

$headerBackground = empty($params['header_background']) ? '#fff' : $params['header_background'];
$headerColor = empty($params['header_color']) ? '#252525' : $params['header_color'];

$headerFont = empty($params['header_font']) ? '' : "'" . $params['header_font'] . "', ";
$headerFont .= "'Open Sans', 'Roboto', 'Helvetica', Sans-Serif";

$bodyBackground = empty($params['body_background']) ? '#fff' : $params['body_background'];
$bodyColor = empty($params['body_color']) ? '#666666' : $params['body_color'];
$bodyPadding = '25px 5px 30px 5px';

$bodyFont = empty($params['body_font']) ? '' : "'" . $params['body_font'] . "', ";
$bodyFont .= "'Open Sans', 'Roboto', 'Helvetica', Sans-Serif";

$logoSrc = $params['logo'] ?? $logoSrc ?? ($protocol . Yii::$app->params['domain'] . '/img/social-media-audit-logo.png');
$logoSrc = BaseHelper::getFullUrl($logoSrc);

$isCustomerEmail = $params['isCustomerEmail'] ?? false;
?>

<div id="mailsub">

    <div id="wrapper" dir="ltr" style="background-color: #f5f5f5; margin: 0; padding: 70px 0 70px 0; width: 100%;">

        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" bgcolor="#f5f5f5"
               style="border-spacing: 0; background: #f5f5f5; margin: 0 auto;">
            <tr>
                <td align="center" valign="top">

                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_container"
                           bgcolor="#fff"
                           style="max-width:602px; border-spacing: 0; background: #fff; margin: 0 auto; border: 1px solid #ececec; border-radius: 6px; ">
                        <tr>
                            <td align="center" valign="top" style="padding: 0">
                                <!-- Header -->
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header"
                                       bgcolor="#fff"
                                       class="js-email-template-header"
                                       style="margin: 0; max-width:922px; border-spacing: 0; border-radius: 6px 6px 0 0;
                                               padding-bottom: 15px;
                                               background: <?= $headerBackground ?>;">
                                    <tr>
                                        <td id="header_wrapper" width="100%" style="padding-top:0!important;"
                                            align="right">
                                            <?php if (\Yii::$app->request->isMainDomain() || $isCustomerEmail) { ?>
                                                <?php if ($showLogo) { ?>
                                                    <img src="<?= $logoSrc ?>"
                                                         alt="Logo SocialMediaAudit" width="200"
                                                         style="width:200px; border: 0; display: block; margin-top:56px; margin-right:58px;"/>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <br>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <h2 class="js-email-template-title"
                                                    style="padding: 20px 0 0 0; text-align: center;
                                                    margin-bottom: 0;
                                                    color:<?= $headerColor ?>;
                                                    font-family: <?= $headerFont ?>; font-size: 30px; font-weight: 300;">
                                                <?= $title ?>
                                            </h2>
                                        </td>
                                    </tr>
                                </table>
                                <!-- End Header -->
                            </td>
                        </tr>

                        <tr>
                            <td align="center" valign="top" style="padding: 0;">
                                <!-- Body -->
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_body"
                                       style="min-height: 160px;max-width:922px; border-spacing: 0; margin: 0 auto;
                                       border-radius: 0 0 6px 6px; background: <?= $bodyBackground ?>;">
                                    <tr>
                                        <td valign="top" id="body_content" class="js-email-template-content"
                                            style="font-size: 14px;
                                            border-radius: 0 0 6px 6px;
                                            font-family: <?= $bodyFont ?>;
                                            color: <?= $bodyColor ?>;
                                            padding: <?= $bodyPadding ?>;">
                                            <!-- Content -->
                                            <div style="padding: 5px 35px;">
                                                <?= $content ?>
                                            </div>
                                            <!-- End Content -->
                                        </td>
                                    </tr>
                                </table>
                                <!-- End Body -->
                            </td>
                        </tr>

                    </table>

                </td>
            </tr>
        </table>

    </div>

</div>

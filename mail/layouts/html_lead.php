<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */

//$homeUrl = \yii\helpers\Url::home(true); //this throw error in console app
$homeUrl = 'http://www.'.Yii::$app->params['domain'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>"/>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
<?php $this->beginBody() ?>
<div id="wrapper" dir="ltr" style="background-color: #f5f5f5; margin: 0; padding: 70px 0 70px 0; width: 100%;">
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="background-color: <?= isset($this->params['body_background'])? $this->params['body_background'] : '#fdfdfd' ?>;border: 1px solid #dcdcdc;border-radius: 3px !important;">
                    <tr>
                        <td align="center" valign="top">
                            <!-- Header -->
                            <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header">
                                <tr>
                                    <td id="header_wrapper" style="padding: 36px 48px; <?= isset($this->params['header_font']) ? 'background-color: '.(isset($this->params['header_background']) ? $this->params['header_background'] : '#66a1e9') : "background-color: #66a1e9" ?>; padding-top:0!important;">
                                        <div style="width:100%; text-align:right;">
                                            <?php if (isset($this->params['show_logo'])) { ?>
                                                <?php if (($this->params['show_logo'] == 1) && $this->params['logo'] ) { ?>
                                                    <img data-home='<?= urlencode($homeUrl) ?>' src="<?= str_replace(' ','%20',$homeUrl.$this->params['logo']) ?>" alt="logo" style="width: 210px; margin-top: 30px; margin-right: 0px; border: none; display: inline; font-size: 14px; font-weight: bold; height: auto; line-height: 100%; outline: none; text-decoration: none; text-transform: capitalize;">
                                                <?php }else{ ?>
                                                    <br >
                                                <?php } ?>
                                            <?php } else { ?>
                                                <br>
                                            <?php } ?>
                                        </div>

                                        <h1 style="padding:36px 48px; margin:0; color:<?= isset($this->params['header_color']) ? $this->params['header_color'] : '#ffffff' ?>; font-family: <?= isset($this->params['header_font']) ? "'{$this->params['header_font']}', " : '' ?>'helvetica neue', helvetica, roboto, arial, sans-serif; font-size: 30px; font-weight: 300;"><?= Html::encode($this->title) ?></h1>
                                    </td>
                                </tr>
                            </table>
                            <!-- End Header -->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- Body -->
                            <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                                <tr>
                                    <td valign="top" id="body_content">
                                        <!-- Content -->
                                        <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                            <tr>
                                                <td valign="top" style="padding-bottom:0;">
                                                    <div id="body_content_inner" style="padding-left: 18px; padding-right: 18px; padding-top: 18px; padding-bottom:0; font-family: <?= isset($this->params['body_font'])? "'".$this->params['body_font']."', " : '' ?>'helvetica neue', helvetica, roboto, arial, sans-serif; font-size: 14px;color: <?= isset($this->params['body_color'])? $this->params['body_color'] : '#737373' ?>;">
                                                        <?= $content ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- End Content -->
                                    </td>
                                </tr>
                            </table>
                            <!-- End Body -->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- Footer -->
                            <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
                                <tr>
                                    <td valign="top">
                                        <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                            <tr>
                                                <td colspan="2" valign="middle" id="credit" style="padding: 0 48px 48px 48px;border: 0;color: #99b1c7;font-family: Arial;font-size: 12px;line-height: 125%;text-align: center;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <!-- End Footer -->
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

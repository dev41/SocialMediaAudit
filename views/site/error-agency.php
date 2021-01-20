<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */
/* @var $agency \app\models\Agency */

use yii\helpers\Html;

if ($name == 'Not Found (#404)') $name = 'Page not found';
$this->title = $name;
$padding = 0;
    if (empty($agency->company_logo)) {
        $textHeight = 25;
        $noTextCount = empty($agency->company_name) + empty($agency->company_phone)
            + empty($agency->company_email) + empty($agency->company_website);
        $padding = - ($noTextCount * $textHeight);
    }
    ?>
    <style type="text/css">
        body {
            <?= $agency->body_font? "font-family: '".$agency->body_font."' !important;" : '' ?>
            background: <?php echo $agency->background_color; ?> !important;
        }
        h1, h2, h3, h4, h5, h6 {
            <?= $agency->header_font? "font-family: '".$agency->header_font."' !important;" : '' ?>
        }
        .bg-primary {
            background-color: <?php echo $agency->foreground_color; ?> !important;
        }
        .btn--primary, .btn--primary:hover, .btn--primary:focus, .btn--primary:active, .btn--primary.active, .btn--primary.focus, .btn--primary:active, .btn--primary:focus, .btn--primary:hover, .open > .dropdown-toggle.btn--primary {
            background-color: <?php echo $agency->foreground_color; ?> !important;
            border-color: <?php echo $agency->foreground_color; ?> !important;
        }
        .progress-bar-primary {
            background-color: <?php echo $agency->foreground_color; ?> !important;
        }
        .portlet-heading, .panel-heading {
            background-color: <?= $agency->section_bgcolor? $agency->section_bgcolor : '#4c5667' ?> !important;
        }
        .section-title, .panel-title {
            color: <?= $agency->section_fgcolor ?> !important;
        }
        .wrapper {padding-top: 50px}
        .tab-results {margin-top: <?= $padding ?>px}
        .navbar-custom, .progress {display: none}
    </style>
<?php
$this->registerJs('
if ('. json_encode((bool) $agency->foreground_color) .') {
    $(".knob").trigger(
        "configure",
        {
            "fgColor":"'. $agency->foreground_color.'",
            "inputColor":"'. $agency->foreground_color.'",
        }
    );
    overviewChartColors = hexToRgb("'. $agency->foreground_color.'");
}');
    $fonts = $agency->getFontsUrls(true);
    foreach ($fonts as $font) {
        $this->registerCssFile($font);
    }
?>
<?= $this->render('../report/partial/_agency_guest_header', ['agency' => $agency]) ?>

<div class="container" style="margin-top: 100px;">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet">

                <div class="portlet-heading bg-brown">
                    <h2 class="section-title"><?= Html::encode($this->title) ?></h2>
                    <div class="clearfix"></div>
                </div>

                <div class="portlet-body">
                        <p><?= nl2br(Html::encode($message)) ?></p>
                </div>

            </div>
        </div>
    </div>
</div>
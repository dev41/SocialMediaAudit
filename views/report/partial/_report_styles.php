<?php

use app\models\Agency;
use app\models\Website;
use yii\web\View;

/**
 * @var View $this
 * @var Website $website
 * @var Agency $agency
 * @var array $sections
 */

$foregroundColor = $agency && !empty($agency->foreground_color) ? $agency->foreground_color : '#33c68a';
$this->params['chartColor'] = $foregroundColor;
?>

<style type="text/css">

    /* general marks */

    <?php if($agency && !empty($agency->header_font) && Agency::FONTS[$agency->header_font] === 'google') { ?>
        @import url('https://fonts.googleapis.com/css?family=<?= $agency->header_font ?>');
    <?php } ?>

    <?php if($agency && !empty($agency->body_font) && Agency::FONTS[$agency->body_font] === 'google') { ?>
        @import url('https://fonts.googleapis.com/css?family=<?= $agency->body_font ?>');
    <?php } ?>

    .report-section-fg-color {
        color: <?= $agency && !empty($agency->section_fgcolor) ? $agency->section_fgcolor : '#333;' ?>;
    }

    .report-fg-color:active,
    .report-fg-color:focus,
    .report-fg-color:hover,
    .report-fg-color {
        color: <?= $foregroundColor ?>;
    }

    .report-fg-color--bg:active,
    .report-fg-color--bg:focus,
    .report-fg-color--bg:hover,
    .report-fg-color--bg {
        background-color: <?= $foregroundColor ?>;
    }

    .report-header-font {
        <?= $agency && !empty($agency->header_font) ? 'font-family: ' . $agency->header_font . ';' : '' ?>;
    }

    body,
    .report-body-font {
        <?= $agency && !empty($agency->body_font) ? 'font-family: ' . $agency->body_font . ';' : '' ?>;
        font-size: 15px;
    }

    /* customize special styles */

    /* PDF report button */
    #pdf-btn.btn.report-fg-color--bg,
    input[type="submit"].report-fg-color--bg {
        background-color: <?= $foregroundColor ?>;
        border-color: <?= $foregroundColor ?>;

    }

    /* navbar active item */
    .tabs li.active .tab__title {
        color: <?= $foregroundColor ?>;
    }
    .tabs li.active .tab__title span {
        color: <?= $foregroundColor ?>;
    }

</style>

<?php if ($agency) {
    Yii::$app->i18n->register($this, 'js', $agency->language);

    $this->render('_agency_guest_header', [
        'agency' => $agency,
    ]);
} ?>

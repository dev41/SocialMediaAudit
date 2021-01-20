<?php
use app\models\Agency;
use app\models\Website;
use yii\web\View;

/**
 * @var View $this
 * @var Website $website
 * @var Agency $agency
 */
?>

<?= $this->render('_agency_custom_title', [
    'agency' => $agency,
    'website' => $website,
]); ?>

<div class="wrapper report-wrapper">
    <?= $this->render('_alerts') ?>

    <div id="results" class="container block tab-results active p-0">
        <?= $this->render('_results', ['agency' => $agency, 'website' => $website]) ?>
    </div>

    <?php if (!$agency && Yii::$app->user->isGuest) {
        echo $this->render('_banner_top');
    }

    echo $this->render('_social_sections', ["agency" => $agency]);
    ?>

    <?= (!$agency || $agency->show_recommendations) ? $this->render('sections/_recommendations', ['agency' => $agency]) : '' ?>

    <?php if (!$agency && Yii::$app->user->isGuest) {
        echo $this->render('_banner_bottom');
    } ?>

</div>
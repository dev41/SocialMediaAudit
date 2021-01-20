<?php

use app\models\Agency;
use yii\web\View;

/**
 * @var View $this
 * @var Agency $agency
 */
?>

<script type="text/template" class="js-recommendation-template">
    <div class="col-sm-4 voh">
        <div class="feature feature-4 boxed boxed--lg boxed--border">
            <h4 class="report-section-fg-color report-header-font">{title}</h4>
            <hr>
            <p>{content}</p>
            <?php if (!$agency): ?>
                <a class="btn btn--primary report-fg-color--bg" href="#">
                    <span class="btn__text">
                        Learn More
                    </span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</script>

<div id="recommendation"
     class="fluid-container block tab-recommendations boxed--lg bg--secondary nowrap js-content-tab">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-xs-12 text-center">
            <h2 class="report-header-font report-section-fg-color"><?= Yii::t('report', 'Recommendations') ?></h2>
        </div>
    </div>
    <!-- Page-Title -->

    <div class="container">
        <div class="row js-recommendation-container">

        </div>
    </div>
</div>
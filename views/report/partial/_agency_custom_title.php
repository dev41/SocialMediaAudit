<?php
use app\models\Agency;
use app\models\Website;

/**
 * @var Agency $agency
 * @var Website $website
 */
?>

<?php if ($agency && ($agency->show_title || $agency->show_intro)): ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">

                <?php if ($agency->show_title): ?>
                    <h2 class="m-l-10 report-section-fg-color report-header-font" data-origin="cryptosided.com">
                         <?= str_replace('[url]', $website->domain, $agency->custom_title_filtered) ?>
                    </h2>
                <?php endif; ?>

                <div class="boxed boxed--border boxed--lg report-custom-title">
                    <?= $agency->show_intro ? '<p>' . $agency->custom_intro_filtered . '</p>' : '' ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

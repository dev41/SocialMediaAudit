<?php

use app\models\Agency;
use yii\helpers\BaseUrl;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $agency Agency
 */

$companyWebsite = false;
if ($agency && $agency->company_website) {
    $companyWebsite = BaseUrl::isRelative($agency->company_website) ? "http://{$agency->company_website}" : $agency->company_website;
}

$isSuspended = ($identity = Yii::$app->user->identity) && $identity->isSuspended();

$isAgencyShow = ($agency &&
    ($agency->company_logo || $agency->company_name || $agency->company_address || $agency->company_phone || $agency->company_email || $agency->company_website)
);
?>

<?php if ($isAgencyShow): ?>
<div class="company-navbar">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 company-navbar-content">
                <div class="company-logo">
                    <?php if ($agency && $agency->company_logo):
                    $image = Html::img('/upload/' . $agency->company_logo, ['style' => 'max-height: 100px;']);

                    if ($companyWebsite) {
                        echo Html::a($image, $companyWebsite);
                    } else {
                        echo $image;
                    }
                    ?>

                    <?php endif; ?>
                </div>

                <div class="company-info">
                    <?php if ($agency->company_name): ?> <p><?= $agency->company_name ?></p> <?php endif; ?>
                    <?php if ($agency->company_address): ?> <p><?= $agency->company_address ?></p> <?php endif; ?>

                    <?php if ($agency->company_phone): ?>
                        <p><a class="report-fg-color" href="tel:<?= $agency->company_phone ?>"><?= $agency->company_phone ?></a></p>
                    <?php endif; ?>

                    <?php if ($agency->company_email): ?>
                        <p><a class="report-fg-color" href="mailto:<?= $agency->company_email ?>"><?= $agency->company_email ?></a></p>
                    <?php endif; ?>

                    <?php if ($agency->company_website): ?>
                        <p><a class="report-fg-color" target="_blank" href="<?= $companyWebsite ?>" title="<?= $agency->company_name ?? '' ?>">
                                <?= $agency->company_website ?>
                        </a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

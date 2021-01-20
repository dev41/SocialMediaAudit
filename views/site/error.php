<?php

use app\models\Agency;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var Agency $agency */
/* @var $exception Exception */

$this->title = "{$name} - SocialMediaAudit";
?>

<div id="wrapper" class="bg--dark">
    <div class="main-container">
        <?php if(Yii::$app->requestedAction->id !== 'embed-callback') {
            echo $this->render('/layouts/new/_header');
        } ?>
        <section class="text-center">
            <div class="container" style="top: 50%; transform: translate(0, 100%);">
                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="h1--large"><?= Html::encode( $code ) ?></h1>
                        <p data-view-name="<?= $code ?>" class="lead">
                            <?= nl2br(Html::encode($message)) ?>
                        </p>
                        <form role="search" class="top-search-form search-404page hidden" onsubmit="window.location='/'+$(this).find('input').val().toLowerCase().replace(/^https?:\/\//i,'').replace(/\/$/i, '');return false">
                            <input type="text" name="Website[domain]" placeholder="Search..." class="form-control">
                            <a href="" onclick="$(this).closest('form').submit();return false"><i class="fa fa-search"></i></a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

</div>
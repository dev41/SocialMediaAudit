<?php

/* @var $this \yii\web\View */

use app\helpers\FormHelper;

/* @var $content string */

$this->registerJsFile('/js/plugins/slimscroll/jquery.slimscroll.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJs("
    setTimeout(function () {
        $('.successMessage').fadeOut('slow');
    }, 5000);
    $('.slimscrollleft').slimScroll({
        height: 'auto',
        position: 'right',
        size: \"5px\",
        color: '#98a6ad',
        wheelStep: 5
    });
");
$this->beginContent('@app/views/layouts/main.php');
?>
    <div id="wrapper">

        <?= $this->render('/layouts/new/_header') ;?>
        <?= $this->render('/layouts/new/_sidebar') ;?>

        <div class="content-page agency-dashboard">
            <div class="content<?= isset($this->params['hiddenContent'])? ' hidden' : '' ?>">
                <?= FormHelper::stackSessionMessage(); ?>

                <?= $content ?>
            </div>
        </div>
    </div>
<?php echo app\widgets\intercom\IntercomWidget::widget() ?>
<?php $this->endContent(); ?>
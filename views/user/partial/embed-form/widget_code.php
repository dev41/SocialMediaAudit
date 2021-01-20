<?php

use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model \app\models\EmbeddingForm */
?>

<?php if ($model->widget_code) { ?>
    <div class="boxed boxed--border"?>
        <div class="row">
            <div class="col-md-12">
                <?php if ($model->subdomain) { ?>
                    <h3 class="header-title">Embeddable Search Widget HTML</h3>
                    <i class="notice-embed-code-copied" style="display: none; padding: 20px 40px; background: lightgoldenrodyellow; position: fixed; top: 50%; left: 49%; margin-left: -150px; z-index: 99999;">The code was copied to clipboard</i>
                    <textarea class="form-control agency-embed-code-snippet" readonly="readonly" style="width:100% !important; height: 260px; cursor: initial;"><?= $model->widget_code ?></textarea>
                    <button type="button" class="btn btn--primary btn-embed-code-copy m-t-5 pull-right" data-clipboard-target=".agency-embed-code-snippet" >Copy to Clipboard</button>
                <?php } else { ?>
                    <p>Please specify subdomain under Branding tab and save the settings. Then your HTML code snippet will appear here.</p>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
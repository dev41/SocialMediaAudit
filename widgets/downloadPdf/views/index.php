<?php
use yii\bootstrap\Html;
?>
<?php if ($isPdfAllowed) { ?>
    <?= Html::beginForm($downloadUrl, 'post', ['class' => 'd-inline-block']) ?>
    <input name="wid" value="<?= $website->id ?>" type="hidden">
    <input id="pdf-btn" data-visibility="hidden" data="" type="submit" value="Download as PDF" class="btn btn--primary report-fg-color--bg">
    <?= Html::endForm() ?>
<?php } elseif(\Yii::$app->user->isGuest) { ?>
    <a id='pdf-btn' href='#pdf' data-visibility='hidden' data='popover' class='btn btn--primary report-fg-color--bg'>
        <span class="btn__text">
            <?= Yii::t('app', 'Download as PDF') ?>
        </span>
    </a>
<?php }else{ ?>
    <a id='pdf-btn' href='#pdf' disabled data-visibility='hidden' class='btn btn--primary report-fg-color--bg'>
        <span class="btn__text">
            <?= Yii::t('app', 'Download as PDF') ?>
        </span>
    </a>
<?php } ?>
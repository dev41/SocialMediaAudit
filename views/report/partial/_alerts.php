<?php
$messages = Yii::$app->session->getFlash('alert');
if ( !empty($messages) ) {

    if ( !is_array($messages) ){
        $messages = array($messages);
    }

    foreach ($messages as $key => $message) { ?>
        <div class="container">
            <div class="alert bg--error">
                <div class="alert__body"><?= $message ?></div>
                <div class="alert__close">×</div>
            </div>
        </div>
    <?php } ?>
<?php } ?>

<div class="container js-ajax-alert hidden">
    <div class="alert bg--error">
        <div class="alert__body"></div>
        <div class="alert__close">×</div>
    </div>
</div>
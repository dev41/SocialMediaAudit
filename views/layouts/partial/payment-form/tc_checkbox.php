<?php

use yii\web\View;

/**
 * @var View $this
 */
?>

<div class="col-xs-12 col-md-12 m-b-10">
    <div class="input-checkbox">
        <input class="js-user-tc-accept" type="checkbox" id="user-tc_accept"
               name="User[tc_accept]" value="0">
        <label for="accept"></label>
    </div>
    <span class="js-user-tc-accept-label tc-accept-checkbox-label"><?= \Yii::t('app', 'I accept the'); ?>
        <a target="_blank" href="/terms-and-conditions"><?= \Yii::t('app', 'Terms & Conditions'); ?></a>
    </span>
</div>

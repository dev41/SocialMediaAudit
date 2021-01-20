<?php

/* @var $this yii\web\View */
/* @var $model \app\models\User */

?>
<!-- cancel subscription modal -->
<div class="modal fade" id="cancelSub" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= Yii::$app->urlManager->createUrl('/user-cancel-sub') ?>"
                  data-user-id="<?= $model->id ?>"
                  class="js-cancel-sub-form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        <strong><?= \Yii::t('app', 'Cancel Subscription'); ?></strong></h4>
                </div>
                <div class="modal-body">

                    <div class="js-stripe-process-spinner " style="display:none">
                        <svg class="loader" style="position: absolute">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#i-loader"></use>
                        </svg>
                    </div>

                    <input type="hidden" name="token"/>

                    <?= \Yii::t('app', 'Are you sure you want to delete this user and their data?'); ?>
                </div>
                <div class="modal-footer" style="padding-top: 0; border-top: none;">
                    <div class="submit-loader-box">
                        <button type="button"
                                class="btn btn-danger js-cancel-sub-submit"><?= \Yii::t('app', 'Ok'); ?></button>
                        <button type="button" class="btn btn--primary"
                                data-dismiss="modal"><?= \Yii::t('app', 'Close'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
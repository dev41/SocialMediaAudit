<?php

use yii\helpers\Html;
use yii\mail\MessageInterface;
use yii\web\View;

/* @var View $this */
/* @var MessageInterface $message */
/* @var string $content */

?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html dir="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title><?= Html::encode($this->title); ?></title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Use the latest (edge) version of IE rendering engine -->
        <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->
        <link href="http://socialmediaaudit.io/css/stack/theme.css" rel="stylesheet">
        <link href="http://socialmediaaudit.io/css/stack/custom.css" rel="stylesheet">
        <?php $this->head() ?>
    </head>

    <body style="margin:0; padding:0;"
          bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"
          width="100%" offset="0">

    <?php $this->beginBody() ?>

    <?= $this->render('_content_layout', [
        'content' => $content,
    ]) ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
<?php
$local = include(__DIR__ . '/../../config/local.php');
if (empty($local)) die('config/local.php not found');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../config/api.php'),
    $local
);

// remove unwanted params
//$config['components']['user']['enableAutoLogin'] = false;
//$config['components']['user']['enableSession'] = false;

(new yii\web\Application($config))->run();

<?php

if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
    $nonWwwUrl = 'https://' . substr($_SERVER['HTTP_HOST'], 4);
    if (!empty($_SERVER['REQUEST_URI'])) {
        $nonWwwUrl .= $_SERVER['REQUEST_URI'];
    }
    header('Location: ' . $nonWwwUrl);
    exit;
}

$local = include_once(__DIR__ . '/../config/local.php');
$web = require_once(__DIR__ . '/../config/web.php');
if (empty($local)) {
    die('config/local.php not found');
}

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = yii\helpers\ArrayHelper::merge(
    $web,
    $local
);

(new yii\web\Application($config))->run();
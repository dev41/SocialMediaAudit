<?php

namespace app\assets;

use yii\web\AssetBundle;

class SocialReportAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/report-social.js',
    ];
    public $depends = [
        '\app\assets\ReportAsset',
    ];
}

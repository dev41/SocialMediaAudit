<?php

namespace app\assets;

use yii\web\AssetBundle;

class WebsiteReportAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/report.js',
    ];
    public $depends = [
        '\app\assets\ReportAsset',
    ];
}

<?php

namespace app\assets;

use yii\web\AssetBundle;

class ReportAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'css/stack/polyfill_7.min.js',
        'css/stack/easypiechart.min.js',
        'js/plugins/Chart.js/Chart.min.js',
        'js/pages/chartjs.init.js',
        'js/rgraph/rgraph.common.core.js',
        'js/rgraph/rgraph.common.dynamic.js',
        'js/rgraph/rgraph.common.tooltips.js',
        'js/rgraph/rgraph.common.key.js',
        'js/rgraph/rgraph.meter.js',
        'js/rgraph/rgraph.pie.js',
        'js/clipboard.min.js',
        'js/report-common.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        '\app\assets\AppAsset',
    ];
}

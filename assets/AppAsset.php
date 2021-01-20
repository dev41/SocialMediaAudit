<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $publishOptions = [
        'forceCopy' => true,
    ];

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/app.css',
        'css/seochecker.css',
        'css/custom-searchbox.css',
        'css/components.css',
        'css/icons.css',
        'css/pages.css',
        'css/menu.css',
        'css/responsive.css',
        'css/stack/theme.css',
        'css/stack/stack-interface.css',
        'css/stack/socicon.css',
        'css/stack/custom.css',
        'css/stack/paymentfont.min.css',

        'js/plugins/datatables/buttons.bootstrap.min.css',
        'js/plugins/ladda-buttons/css/ladda-themeless.min.css',
        'js/plugins/datatables/jquery.dataTables.min.css',
        'js/plugins/datatables/dataTables.bootstrap.min.css'
    ];
    public $js = [
        'js/dist/routes/my-account.js',
        'css/stack/scripts.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}

<?php
// ********************************************************************************************
// USE local.php FOR SETTING DOMAIN RELATED VALUES AND OVERRIDING CONFIG, SEE local.php.example
// ********************************************************************************************
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'timeZone' => 'UTC',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'sourceLanguage' => 'en-US',
    'language' => 'en-US',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'class' => 'app\components\Request',
            //'class' => 'yii\web\Request',
            'enableCsrfValidation' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'cacheVars' => [
            'class'     => 'yii\caching\FileCache',
            'cachePath' => '@runtime/vars'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                // common
                'site/test-email-welcome' => 'site/test-email-welcome',
                'site/test-email-customer' => 'site/test-email-customer',
                'site/test-email-reset-password' => 'site/test-email-reset-password',
                'subscription-end-trial' => 'subscription/end-trial',
                'webhook' => 'webhook/index',
                '' => 'site/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'register' => 'site/signup',
                'plan' => 'plan/change',
                'subscribe/<planId:[\w]+>' => 'subscription/subscribe',
                'coupon/<planId:[\w]+>' => 'site/coupon',
                'reset-password' => 'site/request-password-reset',
                'set-new-password'  => 'site/reset-password',
                'switch-identity'   => 'admin/switch-identity',
                'check-billing-form'=> 'user/check-billing-form',

                'user-reactivate'  => 'user/reactivate',
                'my-account' => 'user/account',
                'user-profile' => 'user/profile',
                'user-billing' => 'user/billing',
                'user-subscription' => 'subscription/get-info',
                'user-billing-history' => 'user/billing-history',
                'user-change-card' => 'card/change-card',
                'user-update-profile/<id:[\d]+>' => 'user/update-profile',
                'user-change-password/<id:[\d]+>' => 'user/change-password',
                'user-cancel-subscription/<id:[\d]+>' => 'subscription/cancel-subscription',
                'user-pay-now' => 'user/pay-now',
                'user-reactivate-subscription' => 'user/reactivate-subscription',
                'user-get-update-profile/<id:[\d]+>' => 'user/get-update-profile',
                'user-get-change-card/<id:[\d]+>' => 'card/get-change-card',
                'user-get-change-password/<id:[\d]+>' => 'user/get-change-password',

                // dashboard
                'dashboard' => 'user/index',
                'report-settings' => 'user/report-settings',
                'white-label-reports' => 'user/white-label-reports',
                'embedding-settings' => 'user/embedding-settings',
                'leads' => 'user/leads',
                'users' => 'admin/users',
                'users/search' => 'admin/users-search',
                'user/<id:[\d]+>' => 'admin/edit-user',
                'upload-logo.inc' => 'user/upload-logo',
                'ajax-testcall.inc' => 'user/test-webhook',
                'ajax-delete.inc' => 'user/delete-audit',
                'delete-lead.inc' => 'user/delete-lead',
                'delete-user.inc' => 'admin/delete-user',
                'ajax-agency-audit.inc' => 'user/create-audit',
                'refresh-audit.inc' => 'user/refresh-audit',
                'tour.inc' => 'user/refresh-tour',
                'redirect.php'  => 'site/blank',
                'queue' => 'admin/queue',

                // reports
                'process-embedded.inc' => 'site/embed-callback',
                'request-pdf.inc' => 'report/request-pdf',
                'prepare-pdf.inc' => 'report/prepare-pdf',
                'download-pdf.inc/<name:[\w\d-_]+>' => 'report/download-pdf',
                '<type:(facebook|twitter|youtube|instagram|linkedin)>/<value:[\w\d-_]+>' => 'report/social-profile',
                '<action:check-[a-z0-9-]+>.inc' => 'report/<action>',
                'website/<value:[\w\d\-]+\..+>' => 'report/website',
            ],
        ],
        'i18n' => [
            'class' => 'app\models\yii2i18njs\I18N',
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
            ],
        ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'ttr' => 5 * 60, // Max time for anything job handling
            'attempts' => 2, // Max number of attempts
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex that used to sync queries
            'as log' => \yii\queue\LogBehavior::class,
            //'attempts' => 3,
        ],
        'geoip2' => [
            'class' => 'overals\GeoIP2\GeoIP2',
            'mmdb' => '@app/components/GeoIP2/GeoLite2-City.mmdb',
            'lng' => 'en',
        ],
    ],
    'params' => $params
];

if (YII_DEBUG && 0) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'traceLine' => '<a href="phpstorm://open?url={file}&line={line}">{file}:{line}</a>',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '85.174.227.138'],
        'panels' => [
            'user' => [
                'class'=>'yii\debug\panels\UserPanel',
                'ruleUserSwitch' => [
                    'allow' => true,
                    'roles' => ['administrator'],
                ]
            ],
            'queue' => 'yii\queue\debug\Panel',
        ],
        'enableDebugLogs' => false,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

?>

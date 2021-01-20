<?php
// API DOCS HERE https://documenter.getpostman.com/view/1513509/RWaC3CbQ
$params = require(__DIR__ . '/params.php');

return [
    'id' => 'basic-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'class' => 'app\components\Request',
            'parsers' => [
              'application/json' => 'yii\web\JsonParser',
            ],
            'enableCsrfValidation' => false
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'data' => $response->data,
                    ];
                    $response->statusCode = 200;
                }
            },
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            //'enableAutoLogin' => false,
            //'enableSession' => false,
            'loginUrl' =>'',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [   // do not change array index
                    'class' => 'yii\log\FileTarget',
                    'logFile' =>  "@runtime/logs/api.log",
                    'levels' => ['info'],
                    'categories' => ['api'],
                    'logVars' => [],
                    'maxFileSize' => 1024,
                    'maxLogFiles' => 1,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                //'v1/page/info/<id:\d+>' => 'v1/page/info',
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'modules' => [
        'v1' => [
            'class' => 'app\api\modules\v1\Module',
            // ... other configurations for the module ...
        ],
    ],
    'params' => $params,
];

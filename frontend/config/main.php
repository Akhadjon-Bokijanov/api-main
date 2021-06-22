<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
//        'jwt' => [
//            'class' => \bizley\jwt\Jwt::class,
////            'signer' => "shodlik", // Signer ID
////            'signingKey' => "factura-main-auth" // Secret key string or path to the signing key file
//        ],
        'jwt' => [
            'class' => \sizeg\jwt\Jwt::class,
            'key'   => 'secret',
        ],
        'request' => [
//            'csrfParam' => '_csrf-frontend',
//            'enableCsrfValidation' => false,
//            'application/json' => 'yii\web\JsonParser',
            'parsers' => [
                'enableCsrfValidation' => false,
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            // ...
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                    'sourceLanguage' => 'eh',
                    'fileMap' => [
                        'app' => 'app.php',
                        'yii' => 'yii.php',
                    ],
                ],
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'languages' => ['uz', 'oz', 'ru'],
            'rules' => [
            ],
        ],

    ],
    'params' => $params,
];

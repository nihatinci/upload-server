<?php

$params = require(__DIR__ . '/params.php');

$config = [
  'id' => 'basic',
  'basePath' => dirname(__DIR__),
  'bootstrap' => ['log'],
  'components' => [
    'request' => [
      // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
      'cookieValidationKey' => 'tQ3WVx0sg_DwiKLGt_rbbYtXXimcjN-Q',
    ],
    'cache' => [
      'class' => 'yii\caching\FileCache',
    ],
    'user' => [
      'identityClass' => 'app\models\User',
      'enableAutoLogin' => true,
    ],
    'errorHandler' => [
      'errorAction' => 'site/error',
    ],
    'mailer' => [
        'class'            => 'zyx\phpmailer\Mailer',
        'viewPath'         => '@common/mail',
        'useFileTransport' => false,
        'config'           => [
          'mailer'     => 'smtp',
          'host'       => 'smtp.gmail.com',
          'port'       => '465',
          'smtpsecure' => 'ssl',
          'smtpauth'   => true,
          'username' => $params['smtp']['username'],
          'password' => $params['smtp']['password'],
        ],
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
    'db' => require(__DIR__ . '/db.php'),

    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
        'order/confirm/<id:\d+>' => 'order/confirm',
        'order/save/<id:\d+>' => 'order/save',
      ],
    ],

  ],
  'params' => $params,
];

if (YII_ENV_DEV) {
  // configuration adjustments for 'dev' environment
  $config['bootstrap'][] = 'debug';
  $config['modules']['debug'] = [
    'class' => 'yii\debug\Module',
  ];

  $config['bootstrap'][] = 'gii';
  $config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
  ];
}

return $config;


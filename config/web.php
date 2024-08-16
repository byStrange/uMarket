<?php

use app\models\User;
use yii\filters\AccessControl;

$params = require __DIR__ . "/params.php";
$db = require __DIR__ . "/db.php";

$config = [
  "language" => 'uz-UZ',
  'sourceLanguage' => 'en-US',
  "id" => "basic",
  "basePath" => dirname(__DIR__),
  "bootstrap" => ["log"],
  "modules" => [
    "gridview" => [
      "class" => "\kartik\grid\Module",
      // see settings on http://demos.krajee.com/grid#module
    ],
    "datecontrol" => [
      "class" => "\kartik\datecontrol\Module",
      // see settings on http://demos.krajee.com/datecontrol#module
    ],
    "admin" => [
      "class" => "app\module\admin\Admin",
      "as access" => [
        "class" => AccessControl::class,
        "only" => ["*"],
        "rules" => [
          [
            "allow" => true,
            "matchCallback" => function ($rule, $action) {
              $allowed_actions = ["admin/user-address/create", "admin/rating/create", "admin/rating/update"];
              $user = User::findOne([
                "id" => Yii::$app->user->getId(),
              ]);
              if ($user && ($user->is_superuser || in_array($action->getUniqueId(), $allowed_actions))) {
                return true;
              }
              return false;
            },
          ],
        ],
      ],
    ],
  ],
  "aliases" => [
    "@bower" => "@vendor/bower-asset",
    "@npm" => "@vendor/npm-asset",
  ],
  'bootstrap' => [
    [
      'class' => 'app\components\LanguageSelector',
      'supportedLanguages' => ['en-US', 'ru-RU', 'uz-UZ'],
    ],
  ],
  "components" => [

    "formatter" => [
      "class" => "yii\i18n\Formatter",
      "currencyCode" => "USD", // Set your desired currency code here
    ],
    "request" => [
      // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
      "cookieValidationKey" => "lvlIyXgVTD2abv0dXFlVZTPlkGsC4WYf",
    ],
    "cache" => [
      "class" => "yii\caching\FileCache",
    ],
    "user" => [
      "identityClass" => "app\models\User",
      "enableAutoLogin" => true,
    ],
    "errorHandler" => [
      "errorAction" => "site/error",
    ],
    "mailer" => [
      "class" => \yii\symfonymailer\Mailer::class,
      "viewPath" => "@app/mail",
      // send all mails to a file by default.
      "useFileTransport" => true,
      "transport" => [
        "dsn" => "smtp://qosimovrahmatullo006@gmail.com:ejvw enpz nsqp sgjb@smtp.gmail.com:587"
      ]
    ],
    "log" => [
      "traceLevel" => YII_DEBUG ? 3 : 0,
      "targets" => [
        [
          "class" => "yii\log\FileTarget",
          "levels" => ["error", "warning"],
        ],
      ],
    ],
    "db" => $db,
    "urlManager" => [
      "enablePrettyUrl" => true,
      "showScriptName" => false,
      "rules" => [],
    ],
    'i18n' => [
      'translations' => [
        'yii2.extensions.datetime.picker*' => [
          'class' => 'yii\i18n\PhpMessageSource',
          'basePath' => '@vendor/kartik-v/yii2-widget-datetimepicker/messages',
          'fileMap' => [
            'yii2.extensions.datetime.picker' => 'datetimepicker.php',
          ],
        ],
        'app*' => [
          'class' => 'yii\i18n\PhpMessageSource',
          'basePath' => '@app/messages',
          'sourceLanguage' => 'en-US',
          'fileMap' => [
            'app' => 'app.php',
            'app/error' => 'error.php',
          ],
        ],
      ],
    ],
  ],
  "params" => $params,
];

if (YII_ENV_DEV) {
  // configuration adjustments for 'dev' environment
  $config["bootstrap"][] = "debug";
  $config["modules"]["debug"] = [
    "class" => "yii\debug\Module",
    // uncomment the following to add your IP if you are not connecting from localhost.
    //'allowedIPs' => ['127.0.0.1', '::1'],
  ];

  $config["bootstrap"][] = "gii";
  $config["modules"]["gii"] = [
    "class" => "yii\gii\Module",
    // uncomment the following to add your IP if you are not connecting from localhost.
    //'allowedIPs' => ['127.0.0.1', '::1'],
  ];
}

return $config;

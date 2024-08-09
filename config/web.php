<?php

use app\models\User;
use yii\filters\AccessControl;

$params = require __DIR__ . "/params.php";
$db = require __DIR__ . "/db.php";

$config = [
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
              $user = User::findOne([
                "id" => Yii::$app->user->getId(),
              ]);
              if ($user && $user->is_superuser) {
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

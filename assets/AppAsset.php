<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'css/plugins.min.css',
  ];
  public $js = [
    'js/plugins/htmx.min.js',
    'js/vendor/jquery-migrate-3.3.2.min.js',
    'js/vendor/modernizr-3.11.2.min.js',
    'js/vendor/moment.js',
    'js/plugins.min.js',
    'js/main.js',
  ];
  public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap5\BootstrapAsset'
  ];
}

<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/stubs.php';

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../config/test.php'),
    require(__DIR__ . '/../config/test-local.php'),
    require(__DIR__ . '/../config/web.php'),
    require(__DIR__ . '/../config/web-local.php'),
);

(new yii\web\Application($config))->run();

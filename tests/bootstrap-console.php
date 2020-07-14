#!/usr/bin/env php
<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../config/test.php'),
    require(__DIR__ . '/../config/test-local.php'),
    require(__DIR__ . '/../config/console.php'),
    require(__DIR__ . '/../config/console-local.php'),
);

$application = new yii\console\Application($config);
$exitCode = $application->run();
exit($exitCode);

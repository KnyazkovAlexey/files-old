<?php

/**
 * Заглушки для тестирования загрузки файлов.
 * @see https://yiiframework.ru/forum/viewtopic.php?t=38017
 */
namespace yii\web {
    function move_uploaded_file($from, $to) {
        return rename($from, $to);
    }

    function is_uploaded_file($file) {
        return true;
    }
}

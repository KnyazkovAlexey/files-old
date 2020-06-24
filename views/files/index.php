<?php

use yii\web\View ;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/**
 * @var ActiveDataProvider $dataProvider
 * @var $this View
 */

$this->title = Yii::t('app', 'Загруженные файлы');
?>

<h1><?= $this->title ?></h1>

<br>

<a class="btn btn-success" href="/files/add">Добавить</a>

<br><br>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => [
        'class' => 'table table-bordered',
    ],
    'columns' => [
        'name',
        'uploaded_at:datetime',
    ],
]); ?>

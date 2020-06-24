<?php

use app\forms\UploadForm;
use yii\web\View ;
use yii\widgets\ActiveForm;

/**
 * @var UploadForm $model
 * @var $this View
 */

$this->title = Yii::t('app', 'Загрузка файлов');
?>

<h1><?= $this->title ?></h1>

<br>

<?php $form = ActiveForm::begin([
    'action' => 'upload',
    'options' => ['enctype' => 'multipart/form-data'],
]) ?>

<?= $form->field($model, 'files[]')->fileInput(['multiple' => true])->label(false) ?>

<button><?= Yii::t('app', 'Загрузить') ?></button>

<br><br>

<a class="btn btn-info" href="/files">Список загруженных файлов</a>

<?php ActiveForm::end() ?>

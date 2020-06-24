<?php

use app\forms\UploadForm;
use yii\web\View ;
use yii\widgets\ActiveForm;

/**
 * @var UploadForm $model
 * @var $this View
 */

$this->title = Yii::t('app', 'Отправка файлов');
?>

<?php $form = ActiveForm::begin([
    'action' => 'upload',
    'options' => ['enctype' => 'multipart/form-data'],
]) ?>

<?= $form->field($model, 'files[]')->fileInput(['multiple' => true])->label(false) ?>

<button><?= Yii::t('app', 'Загрузить') ?></button>

<?php ActiveForm::end() ?>

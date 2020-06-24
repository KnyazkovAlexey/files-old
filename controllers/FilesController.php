<?php

namespace app\controllers;

use app\forms\UploadForm;
use app\services\FileUploadService;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Throwable;
use yii\web\UploadedFile;

/**
 * Контроллер для работы с файлами
 * 
 * Class FilesController
 * @package app\controllers
 */
class FilesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'upload' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Страница загрузки файлов
     * 
     * @return string
     */
    public function actionAdd(): string
    {
        /** @var UploadForm $form */
        $form = new UploadForm();

        return $this->render('add', ['model' => $form]);
    }

    /**
     * Загрузка файлов
     * 
     * @return string
     */
    public function actionUpload(): string
    {
        /** @var UploadForm $form */
        $form = new UploadForm();

        $form->files = UploadedFile::getInstances($form, 'files');

        if ($form->validate()) {
            try {
                (new FileUploadService())->upload($form);

                Yii::$app->session->setFlash('success', Yii::t('app', 'Ок'));
            } catch (Throwable $e) {
                Yii::error($e->getMessage());

                Yii::$app->session->setFlash('error', Yii::t('app',
                    'Возникла ошибка. Обратитесь в техподдержку: ' . Yii::$app->params['adminEmail'] . '.'));
            }
        }

        return $this->render('add', ['model' => $form]);
    }
}

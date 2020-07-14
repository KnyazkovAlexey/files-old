<?php

namespace app\services;

use app\models\forms\UploadForm;
use yii\db\Transaction;
use yii\helpers\Inflector;
use yii\web\UploadedFile;
use app\models\UploadedFile as UploadedFileModel;
use Exception;
use Throwable;
use Yii;

/**
 * Сервис для загрузки файлов
 *
 * Class FileUploadService
 * @package app\services
 */
class FileUploadService
{
    /**
     * Загрузка файлов.
     * Загружаем в транзакции, то есть либо всё, либо ничего.
     *
     * @param UploadForm $form
     * @return bool
     * @throws Throwable
     */
    public function upload(UploadForm $form): bool
    {
        /** @var Transaction $transaction */
        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($form->files as $file) {
                /** @var UploadedFile $file */

                $this->uploadFile($file);
            }

            $transaction->commit();
        } catch (Throwable $e) {
            $transaction->rollBack();

            throw $e;
        }

        return true;
    }

    /**
     * Загрузка одного файла
     *
     * @param UploadedFile $file
     * @return bool
     * @throws Exception
     */
    protected function uploadFile(UploadedFile $file): bool
    {
        /** @var string $filePath */
        $filePath = $this->generateFilePath($file);

        if (!$file->saveAs($filePath)) {
            throw new Exception('Не удалось загрузить файл ' . $file->name);
        }

        /** @var UploadedFileModel $model */
        $model = new UploadedFileModel([
            'path' => $filePath,
            'name' => $this->prepareFileName($file->name),
            'uploaded_at' => date('Y-m-d H:i:s'),
        ]);

        if (!$model->save()) {
            throw new Exception('Не удалось сохранить в БД данные о файле ' . $file->name);
        }

        return true;
    }

    /**
     * Генерация пути для сохранения файла
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function generateFilePath(UploadedFile $file): string
    {
        return 'uploads/' . uniqid() . '.' . $file->extension;
    }

    /**
     * Обработка наименования файла (транслит, нижний регистр, ...)
     *
     * @param string $originalName
     * @return string
     */
    protected function prepareFileName(string $originalName): string
    {
        /** @var string $fileName */

        /** Транслит, нижний регистр */
        $fileName = Inflector::transliterate(mb_strtolower($originalName));

        /** Удаляем лишние пробелы */
        $fileName = preg_replace('~\s{2,}~', ' ', trim($fileName));

        /** Заменяем пробелы дефисами */
        $fileName = preg_replace('~\s~', '-', $fileName);

        return $fileName;
    }
}

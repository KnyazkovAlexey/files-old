<?php

namespace app\tests\unit\services;

use app\models\forms\UploadForm;
use app\services\FileUploadService;
use app\tests\TestCase;
use yii\web\UploadedFile;
use Yii;
use app\models\UploadedFile as UploadedFileModel;
use Exception;
use Throwable;

/**
 * Тестирование сервиса для загрузки файлов.
 *
 * Class FileUploadServiceTest
 * @package app\tests\unit\services
 */
class FileUploadServiceTest extends TestCase
{
    /** @inheritdoc */
    protected bool $useFiles = true;

    /**
     * Успешная загрузка файла.
     *
     * @throws Throwable
     */
    public function testSuccessfulUpload()
    {
        /** @var string $fileName */
        $fileName = 'Привет, мир.txt';
        /** @var string $preparedFileName */
        $preparedFileName = 'privet, mir.txt';

        /** @var UploadedFile $file */
        $file = $this->createUploadedFile(['name' => $fileName]);

        /** @var UploadForm $form */
        $form = new UploadForm([
            'files' => [$file],
        ]);

        $this->assertTrue((new FileUploadService())->upload($form));

        $this->assertTrue(UploadedFileModel::find()->where(['name' => $preparedFileName])->exists());
    }

    /**
     * Загрузка файла с ненулевым кодом ошибки.
     * @see https://www.php.net/manual/en/features.file-upload.errors.php
     *
     * @throws Throwable
     */
    public function testUploadFileWithErrorCode()
    {
        /** @var UploadedFile $file */
        $file = $this->createUploadedFile(['error' => rand(1, 8)]);

        /** @var UploadForm $form */
        $form = new UploadForm([
            'files' => [$file],
        ]);

        $this->expectException(Exception::class);

        (new FileUploadService())->upload($form);
    }

    /**
     * Создание загруженного файла (некая имитация загрузки файла на сервер).
     *
     * @param array $attributes Кастомные свойства файла (name, type, tempName, size, error).
     * @return UploadedFile
     * @throws Exception
     */
    protected function createUploadedFile(array $attributes = []): UploadedFile
    {
        /** @var string $fileName */
        $fileName = $attributes['name'] ?? Yii::$app->security->generateRandomString(6) .'.txt';

        /** @var string $filePath */
        $filePath = Yii::getAlias(self::TMP_DIR_PATH . '/' . $fileName);

        if (false === file_put_contents($filePath, '')) {
            throw new Exception('Не удалось создать файл ' . $filePath);
        }

        /** @var array $attributes */
        $attributes = array_merge($attributes, [
            'name' => $fileName,
            'tempName' => $filePath,
        ]);

        return new UploadedFile($attributes);
    }
}
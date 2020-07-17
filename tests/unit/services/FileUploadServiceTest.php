<?php

namespace app\tests\unit\services;

use app\models\forms\UploadForm;
use app\services\FileUploadService;
use app\tests\TestCase;
use yii\web\UploadedFile;
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
}
<?php

namespace app\tests\unit\models\forms;

use app\models\forms\UploadForm;
use app\tests\TestCase;
use yii\web\UploadedFile;
use Exception;

/**
 * Тестирование формы для загрузки файлов.
 *
 * Class UploadFormTest
 * @package app\tests\unit\models\forms
 */
class UploadFormTest extends TestCase
{
    /** @inheritdoc */
    protected bool $useDb = false;
    /** @inheritdoc */
    protected bool $useFiles = true;

    /**
     * Успешная валиация.
     *
     * @throws Exception
     */
    public function testSuccess()
    {
        /** @var UploadedFile $file */
        $file = $this->createUploadedFile();

        /** @var UploadForm $form */
        $form = new UploadForm([
            'files' => [$file],
        ]);

        $this->assertTrue($form->validate());
    }

    /**
     * Форма без файлов.
     *
     * @throws Exception
     */
    public function testEmptyForm()
    {
        /** @var UploadForm $form */
        $form = new UploadForm([
            'files' => [],
        ]);

        $this->assertFalse($form->validate());
    }

    /**
     * Недопустимое количество файлов.
     *
     * @throws Exception
     */
    public function testWrongFilesCount()
    {
        /** @var UploadedFile[] $files */
        $files = [];

        /** @var int $filesLimit */
        $filesLimit = 5;

        /** @var int $filesCount */
        $filesCount = 0;

        while ($filesCount != $filesLimit + 1) {
            $files[] = $this->createUploadedFile();

            $filesCount++;
        }

        /** @var UploadForm $form */
        $form = new UploadForm([
            'files' => $files,
        ]);

        $this->assertFalse($form->validate());
    }

    /**
     * Недопустимое расширение файла.
     *
     * @throws Exception
     */
    public function testWrongFileExtension()
    {
        /** @var UploadedFile $file */
        $file = $this->createUploadedFile(['name' => 'test.php']);

        /** @var UploadForm $form */
        $form = new UploadForm([
            'files' => [$file],
        ]);

        $this->assertFalse($form->validate());
    }

    /**
     * Недопустимый размер файла.
     *
     * @throws Exception
     */
    public function testWrongFileSize()
    {
        /** @var int $sizeLimit */
        $sizeLimit = 16 * 1024 * 1024;

        /** @var UploadedFile $file */
        $file = $this->createUploadedFile(['size' => $sizeLimit + 1]);

        /** @var UploadForm $form */
        $form = new UploadForm([
            'files' => [$file],
        ]);

        $this->assertFalse($form->validate());
    }
}
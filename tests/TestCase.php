<?php

namespace app\tests;

use yii\db\Transaction;
use Yii;
use Exception;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Базовый класс для тестов
 *
 * Class TestCase
 * @package app\tests
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    /** @var string Путь до папки с временными файлами тестов. */
    protected const TMP_DIR_PATH = '@app/tests/tmp';

    /** @var bool $useDb Флаг о том, что тесты работают с БД. */
    protected bool $useDb = true;
    /** @var bool $useFiles Флаг о том, что тесты работают с файлами. */
    protected bool $useFiles = false;
    /** @var Transaction|null $transaction */
    protected ?Transaction $transaction = null;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        if ($this->useDb) {
            $this->transaction = Yii::$app->db->beginTransaction();
        }
    }

    /**
     * @inheritDoc
     */
    public function teardown(): void
    {
        parent::teardown();

        if ($this->useDb) {
            $this->transaction->rollback();
        }

        if ($this->useFiles) {
            $this->clearTmpDir();
        }
    }

    /**
     * Очистка папки с временными файлами.
     *
     * @return bool
     */
    protected function clearTmpDir(): bool
    {
        /** @var string $tmpDirPath */
        $tmpDirPath = Yii::getAlias(self::TMP_DIR_PATH);

        foreach (FileHelper::findDirectories($tmpDirPath) as $dirPath) {
            rmdir($dirPath);
        }

        foreach (FileHelper::findFiles($tmpDirPath, ['except' => ['.gitignore']]) as $filePath) {
            unlink($filePath);
        }

        return true;
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

        if (false === file_put_contents($filePath, 'test')) {
            throw new Exception('Не удалось создать файл ' . $filePath);
        }

        /** @var array $attributes */
        $attributes = array_merge([
            'name' => $fileName,
            'tempName' => $filePath,
            'type' => 'text/plain',
            'size' => 5,
            'error' => 0,
        ], $attributes);

        return new UploadedFile($attributes);
    }
}
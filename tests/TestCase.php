<?php

namespace app\tests;

use yii\db\Transaction;
use Yii;
use yii\helpers\FileHelper;

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
}
<?php

use yii\db\Migration;

/**
 * Миграция создаёт таблицу "Загруженные файлы"
 *
 * Class m200624_114530_create_table_uploaded_file
 */
class m200624_114530_create_table_uploaded_file extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%uploaded_file}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Наименование'),
            'path' => $this->string()->notNull()->comment('Путь к файлу'),
            'uploaded_at' => $this->timestamp()->notNull()->comment('Дата загрузки'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%uploaded_file}}');
    }
}

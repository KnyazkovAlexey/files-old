<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "uploaded_file".
 *
 * @property int $id
 * @property string $name Наименование
 * @property string $path Путь к файлу
 * @property string $uploaded_at Дата загрузки
 */
class UploadedFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'uploaded_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path', 'name'], 'required'],
            [['uploaded_at'], 'safe'],
            [['path', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'path' => 'Путь к файлу',
            'uploaded_at' => 'Дата загрузки',
        ];
    }
}

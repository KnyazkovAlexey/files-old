<?php

namespace app\models\forms;

use app\traits\ModelTrait;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

/**
 * Форма для загрузки файлов
 *
 * Class UploadForm
 * @package app\models\forms
 */
class UploadForm extends Model
{
    use ModelTrait;

    /** @var UploadedFile[] $files */
    public $files = [];

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['files'], 'file', 'skipOnEmpty' => false, 'maxFiles' => 5, 'maxSize' => 16 * 1024 * 1024,
                'extensions' => 'png, jpg, jpeg, gif, mp3, mp4, txt, pdf, docx, xlsx, odt, ods, zip',
                'uploadRequired' => Yii::t('app', 'Выберите файлы.'),
                'tooMany' => Yii::t('app', 'Вы не можете загружать более 5 файлов.'),
                'tooBig' => Yii::t('app', 'Размер файла не должен превышать 16MB.'),
            ],
        ];
    }
}

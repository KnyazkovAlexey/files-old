<?php

namespace app\forms;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $files;

    public function rules(): array
    {
        return [
            [['files'], 'file', 'skipOnEmpty' => false, 'maxFiles' => 5, 'maxSize' => 16 * 1024 * 1024,
                'extensions' => 'png, jpg, gif, mp3, mp4, txt, pdf, docx, xlsx, odt, ods, zip',
                'uploadRequired' => Yii::t('app', 'Выберите файлы.'),
                'tooMany' => Yii::t('app', 'Вы не можете загружать более 5 файлов.'),
                'tooBig' => Yii::t('app', 'Размер файла не должен превышать 16MB.'),
            ],
        ];
    }
}

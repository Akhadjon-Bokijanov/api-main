<?php


namespace common\models;


use frontend\classes\consts\ExcelConst as Consts;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class Files extends ActiveRecord
{
    public $file;
    public function rules()
    {
        return [
            ['file', 'file', 'extensions' => 'xlsx'],
        ];
    }

    public function upload()
    {
        if(!is_dir(Yii::getAlias(Consts::FILE_PATH)))
            FileHelper::createDirectory(Yii::getAlias(Consts::FILE_PATH));

        if(is_file(Yii::getAlias(Consts::FILE_PATH . Consts::FILE_NAME)))
            unlink(Yii::getAlias(Consts::FILE_PATH . Consts::FILE_NAME));
        $file = UploadedFile::getInstance($this, 'file');
        $file->saveAs(Yii::getAlias(Consts::FILE_PATH . Consts::FILE_NAME));
        return true;
    }
}
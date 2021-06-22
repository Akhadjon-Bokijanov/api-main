<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "aferta".
 *
 * @property int $id
 * @property string|null $title_uz
 * @property string|null $title_oz
 * @property string|null $title_ru
 * @property string|null $body_uz
 * @property string|null $body_oz
 * @property string|null $body_ru
 * @property int|null $status
 */
class Aferta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const ACTIV_AFERTA = 10;

    public static function tableName()
    {
        return 'aferta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['body_uz', 'body_oz', 'body_ru'], 'string'],
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
            [['title_uz', 'title_oz', 'title_ru'], 'string', 'max' => 255],
        ];
    }

    public static function AcceptAferta($pks_data,$data){
        $reason = "";
        if(isset($pks_data['1.2.860.3.16.1.1'])) {
            $tin = $pks_data['1.2.860.3.16.1.1'];
        } else{
            $tin = $pks_data['UID'];
        }
        if($reason==""){
            $model = Company::findOne(['tin'=>$data['tin']]);
            if(!empty($model)){
                if($model->is_aferta!=1) {
                    $model->is_aferta = 1;
                    if ($model->save()) {
                        $collection = Yii::$app->mongodb->getCollection('accept_aferta');
                        $collection->insert(['pkcs7_aferta' => $data['pkcs7'], 'sign_tin' => $tin,'tin'=>$data['tin'], 'created_date' => date('Y-m-d H:i:s')]);
                    } else {
                        $reason = Json::encode($model->getErrors());
                    }
                } else {
                    $reason = "Oferta tasdiqlangan ";
                }
            } else {
                $reason = "Korxona mavjud emas TIN:".$tin;
            }
        }
        if($reason=="")
            return [
                'success'=>true,
            ];
        else
            return [
                'success'=>false,
                'data'=>$model,
                'reason'=>$reason
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title_uz' => Yii::t('app', 'Title Uz'),
            'title_oz' => Yii::t('app', 'Title Oz'),
            'title_ru' => Yii::t('app', 'Title Ru'),
            'body_uz' => Yii::t('app', 'Body Uz'),
            'body_oz' => Yii::t('app', 'Body Oz'),
            'body_ru' => Yii::t('app', 'Body Ru'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}

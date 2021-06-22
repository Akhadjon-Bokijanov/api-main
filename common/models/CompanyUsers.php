<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_users".
 *
 * @property int $id
 * @property string|null $company_tin
 * @property string|null $user_tin
 * @property int|null $status
 * @property int|null $type_company
 * @property int|null $enabled
 * @property string|null $company_name
 */
class CompanyUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'type_company', 'enabled'], 'default', 'value' => null],
            [['status', 'type_company', 'enabled'], 'integer'],
            [['company_tin', 'user_tin'], 'string', 'max' => 9],
            [['company_name'], 'string', 'max' => 500],
        ];
    }

    public static function CheckCompany($tin){
        $model = self::find()->andWhere(['company_tin'=>$tin,'user_tin'=>Yii::$app->user->identity->username])->one();
        if(empty($model))
            return false;
        else
            return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_tin' => Yii::t('app', 'Company Tin'),
            'user_tin' => Yii::t('app', 'User Tin'),
            'status' => Yii::t('app', 'Status'),
            'type_company' => Yii::t('app', 'Type Company'),
            'enabled' => Yii::t('app', 'Enabled'),
            'company_name' => Yii::t('app', 'Company Name'),
        ];
    }
}

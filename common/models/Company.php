<?php

namespace common\models;

use common\components\services\MySoliqUz;
use phpDocumentor\Reflection\Types\False_;
use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $tin
 * @property string $name
 * @property string|null $correct_name
 * @property string|null $address
 * @property string|null $ns10_code
 * @property string|null $ns11_code
 * @property string|null $director_tin
 * @property string|null $director_fio
 * @property string|null $accountant
 * @property string|null $mfo
 * @property string|null $oked
 * @property string|null $bank_account
 * @property string|null $nds_code
 * @property string|null $pass_sr
 * @property string|null $pass_num
 * @property int|null $status
 * @property int|null $enabled
 * @property string|null $created_date
 * @property string|null $status_name
 * @property string|null $short_name
 * @property int|null $is_online
 * @property int|null $is_budget
 * @property int|null $status_code
 * @property int|null $type_company
 * @property int|null $is_aferta
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $phone;


    const STATUS_ACTIVE = 10;

    const ENABLED_ON = 1;
    const ENABLED_OFF = 0;

    const TYPE_YURIDIK = 10;
    const TYPE_FIZIK = 20;
    const TYPE_YaTT = 30;

    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tin', 'name'], 'required'],
            [['status', 'enabled', 'is_online', 'is_aferta'], 'default', 'value' => null],
            [['status', 'enabled', 'is_online', 'is_aferta','type_company','is_budget','status_code'], 'integer'],
            [['created_date'], 'safe'],
            [['tin', 'director_tin'], 'string', 'max' => 9],
            [['name', 'address', 'director_fio', 'accountant'], 'string', 'max' => 500],
            [['correct_name','short_name','status_name'], 'string', 'max' => 255],
            [['ns10_code', 'ns11_code'], 'string', 'max' => 2],
            [['mfo', 'oked', 'bank_account', 'nds_code','pass_sr','pass_num'], 'string', 'max' => 50],
        ];
    }

    public static function SetCompany($tin){
        $data = MySoliqUz::getNp1ByTin($tin);
        $model = new Company();
        $model->tin = $tin;
        $model->type_company = Company::TYPE_YURIDIK;
        $model->name = $data['name'];
        $model->address = $data['address'];
        $model->ns10_code = (string)$data['ns10Code'];
        $model->ns11_code = (string)$data['ns11Code'];
        $model->mfo = $data['mfo'];
        $model->oked = $data['oked'];
        $model->bank_account = $data['account'];
        $model->director_tin = $data['directorTin'];
        $model->director_fio = $data['director'];
        $model->accountant = $data['accountant'];
        $model->status = Company::STATUS_ACTIVE;
        $model->enabled = Company::ENABLED_ON;
        if($model->save())
            return $model;
        else
            return $model->getErrors();
    }

//    public static function GetCompanyData($key='id'){
//        $company_users = CompanyUsers::find()->andWhere([''])->one();
//    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tin' => Yii::t('app', 'Tin'),
            'name' => Yii::t('app', 'Name'),
            'correct_name' => Yii::t('app', 'Correct Name'),
            'address' => Yii::t('app', 'Address'),
            'ns10_code' => Yii::t('app', 'Ns10 Code'),
            'ns11_code' => Yii::t('app', 'Ns11 Code'),
            'director_tin' => Yii::t('app', 'Director Tin'),
            'director_fio' => Yii::t('app', 'Director Fio'),
            'accountant' => Yii::t('app', 'Accountant'),
            'mfo' => Yii::t('app', 'Mfo'),
            'oked' => Yii::t('app', 'Oked'),
            'bank_account' => Yii::t('app', 'Bank Account'),
            'nds_code' => Yii::t('app', 'Nds Code'),
            'status' => Yii::t('app', 'Status'),
            'enabled' => Yii::t('app', 'Enabled'),
            'created_date' => Yii::t('app', 'Created Date'),
            'is_online' => Yii::t('app', 'Is Online'),
            'is_aferta' => Yii::t('app', 'Is Aferta'),
        ];
    }
}

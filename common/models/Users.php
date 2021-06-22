<?php

namespace common\models;

use common\components\services\MySoliqUz;
use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 * @property string|null $fio
 * @property string|null $ns10_code
 * @property string|null $ns11_code
 * @property string|null $address
 * @property string|null $oked
 * @property string|null $director_tin
 * @property string|null $director_fio
 * @property string|null $accountant_fio
 * @property string|null $nds_code
 * @property int|null $column_20
 * @property string|null $mfo
 * @property string|null $main_invoices
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at', 'column_20'], 'default', 'value' => null],
            [['status', 'created_at', 'updated_at', 'column_20'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token', 'fio', 'address', 'director_fio', 'accountant_fio', 'main_invoices'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['ns10_code', 'ns11_code'], 'string', 'max' => 2],
            [['oked', 'nds_code', 'mfo'], 'string', 'max' => 50],
            [['director_tin'], 'string', 'max' => 9],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
            'fio' => 'Fio',
            'ns10_code' => 'Ns10 Code',
            'ns11_code' => 'Ns11 Code',
            'address' => 'Address',
            'oked' => 'Oked',
            'director_tin' => 'Director Tin',
            'director_fio' => 'Director Fio',
            'accountant_fio' => 'Accountant Fio',
            'nds_code' => 'Nds Code',
            'column_20' => 'Column 20',
            'mfo' => 'Mfo',
            'main_invoices' => 'Main Invoices',
        ];
    }


    public static function SignUp($data){
        $model = self::findOne(['username'=>$data['UID']]);
        if(empty($model)){
            $model = new Users();
            $model->username = $data['UID'];
            $model->fio = $data['CN'];
            $model->email = $data['UID']."@noemail.uz";
            $model->created_at = strtotime(date('Y-m-d H:i:s'));
            $model->updated_at = strtotime(date('Y-m-d H:i:s'));
            $model->status = 10;
            if(isset($data['1.2.860.3.16.1.1'])) {
                $model->SetNp1Data($data['1.2.860.3.16.1.1']);
            }
            else {
                $model->SetTaxpayers($data['UID']);
            }
            $model->SetCompany();
            $model->auth_key = Yii::$app->security->generateRandomString(32);
            $model->password_hash = Yii::$app->security->generateRandomString(32);
            if(!$model->save())
                return [
                    'success'=>false,
                    'reason'=>$model->getErrors()
                ];
        }
        return ['success'=>true,'data'=>$model];
    }

    public function SetTaxpayers($tin){
        $model = Company::findOne(['tin'=>$tin]);
        if(empty($model)) {
            $data = MySoliqUz::getTaxpayersByTin($tin);
            $model = new Company();
            $model->tin = $tin;
            $model->name = $data['fullName'];
            $model->address = $data['address'];
            $model->ns10_code = (string)$data['ns10Code'];
            $model->ns11_code = (string)$data['ns11Code'];
            $model->type_company = $data['isItd']?Company::TYPE_YaTT:Company::TYPE_FIZIK;
            $model->pass_sr = $data['passSeries'];
            $model->pass_num = $data['passNumber'];
            $model->director_fio = $data['fullName'];
            $model->director_tin = $tin;
            $model->status = Company::STATUS_ACTIVE;
            $model->enabled = Company::ENABLED_ON;
            if(!$model->save()){
                echo Json::encode(['reason'=>$model->getErrors(),'success'=>false]);die;
            }
        }
        $this->ns10_code = $model->ns10_code;
        $this->ns11_code = $model->ns11_code;
        $this->address = $model->address;

        return [
            'success'=>true,
            'data'=>$model
        ];
    }

    public function SetNp1Data($tin){
        $model = Company::findOne(['tin'=>$tin]);
        if(empty($model)){
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
            $model->save();
        }
    }

    public function SetCompany(){
        $company = MySoliqUz::getCompanyByDirector($this->username);
        foreach ($company as $items){
            $check = CompanyUsers::findOne(['company_tin'=>$items['tin'],'user_tin'=>$this->username]);
            if(empty($check)){
                $check = new CompanyUsers();
                $check->company_name = $items['name'];
                $check->company_tin = $items['tin'];
                $check->user_tin = $this->username;
                $check->enabled=1;
                $check->status = 10;
                $check->save();
            }
        }
        $modelCompany = Company::find()->andWhere(['director_tin'=>$this->username])->all();
        foreach ($modelCompany as $items){
            $check = CompanyUsers::findOne(['company_tin'=>$items->tin,'user_tin'=>$this->username]);
            if(empty($check)){
                $check = new CompanyUsers();
                $check->company_name = $items->name;
                $check->company_tin = $items->tin;
                $check->user_tin = $this->username;
                $check->enabled=1;
                $check->status = 10;
                $check->save();
            }
        }
    }

}

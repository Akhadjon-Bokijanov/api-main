<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "all_documents".
 *
 * @property int $id
 * @property string $doc_id
 * @property string $tin
 * @property string $contragent_tin
 * @property string $contragent_name
 * @property string $contract_no
 * @property string $contract_date
 * @property string|null $emp_no
 * @property string|null $emp_date
 * @property string|null $doc_no
 * @property string|null $doc_date
 * @property int|null $type
 * @property int|null $status
 * @property int|null $is_view
 * @property string|null $created_date
 * @property int|null $write_type
 * @property int|null $user_id
 */
class AllDocuments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'all_documents';
    }

//    const STATUS_NEW=0;
//    const STATUS_SAVED=10;
//    const STATUS_SEND=15;

    const STATUS_NEW=0;
    const STATUS_SAVED=10;
    const STATUS_SEND=15;
    const STATUS_CANCELLED=17;
    const STATUS_REJECTED=20;
    const STATUS_ACCEPTED=30;
    const STATUS_SEND_ACCEPTED =40;

    const TYPE_FACTURA = 10;
    const TYPE_EMP = 20;
    const TYPE_ACT = 30;

    const VIEWE_DOC = 0;
    const NO_VIEWE_DOC = 1;

    const IN_DOC = 0;
    const OUT_DOC = 1;
    const SAVED_DOC = 2;

    const FAVORITE_DOC = 3;
    const DELETE_DOC = 4;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc_id', 'tin', 'contragent_tin', 'contragent_name', 'contract_no', 'contract_date'], 'required'],
            [['contract_date', 'emp_date', 'doc_date', 'created_date'], 'safe'],
            [['type', 'status', 'is_view', 'write_type', 'user_id'], 'default', 'value' => null],
            [['type', 'status', 'is_view', 'write_type', 'user_id'], 'integer'],
            [['doc_id'], 'string', 'max' => 50],
            [['tin', 'contragent_tin'], 'string', 'max' => 9],
            [['contragent_name'], 'string', 'max' => 500],
            [['contract_no', 'emp_no', 'doc_no'], 'string', 'max' => 255],
        ];
    }



    public function SetFacturaData($data){
        $this->doc_id = $data['FacturaId'];
        $this->tin = $data['SellerTin'];
        $this->contragent_tin = $data['BuyerTin'];
        $this->contragent_name = $data['Buyer']['Name'];
        $this->contract_date = $data['ContractDoc']['ContractDate'];
        $this->contract_no = $data['ContractDoc']['ContractNo'];
        if(isset($data['FacturaEmpowermentDoc']['EmpowermentNo'])) {
            $this->emp_no = $data['FacturaEmpowermentDoc']['EmpowermentNo'];
            $this->emp_date = $data['FacturaEmpowermentDoc']['EmpowermentDateOfIssue'];
        }
        $this->doc_date = $data['FacturaDoc']['FacturaDate'];
        $this->doc_no = $data['FacturaDoc']['FacturaNo'];
        $this->type = self::TYPE_FACTURA;
        $this->status = self::STATUS_SAVED;
        $this->is_view = self::NO_VIEWE_DOC;
        $this->write_type = self::SAVED_DOC;
        $this->created_date = date('Y-m-d H:i:s');
        $this->user_id =Yii::$app->user->id;
    }

    public function SetEmpData($data){
        $this->doc_id = $data['EmpowermentId'];
        $this->tin = $data['SellerTin'];
        $this->contragent_tin = $data['BuyerTin'];
        $this->contragent_name = $data['Buyer']['Name'];
        $this->contract_date = $data['ContractDoc']['ContractDate'];
        $this->contract_no = $data['ContractDoc']['ContractNo'];
        $this->emp_no = $data['EmpowermentDoc']['EmpowermentNo'];
        $this->emp_date = $data['EmpowermentDoc']['EmpowermentDateOfIssue'];
        $this->doc_date = $data['EmpowermentDoc']['EmpowermentDateOfExpire'];
        $this->doc_no = $data['EmpowermentDoc']['EmpowermentNo'];

        $this->type = self::TYPE_EMP;
        $this->status = self::STATUS_SAVED;
        $this->is_view = self::NO_VIEWE_DOC;
        $this->write_type = self::SAVED_DOC;
        $this->created_date = date('Y-m-d H:i:s');
        $this->user_id =Yii::$app->user->id;
    }

    public function SetActData($data){
        $this->doc_id = $data['ActId'];
        $this->tin = $data['SellerTin'];
        $this->contragent_tin = $data['BuyerTin'];
        $this->contragent_name = $data['BuyerName'];
        $this->contract_date = date('Y-m-d H:i:s',strtotime( $data['ContractDoc']['ContractDate']));
        $this->contract_no = $data['ContractDoc']['ContractNo'];
        $this->doc_no = $data['ActDoc']['ActNo'];
        $this->doc_date = date('Y-m-d H:i:s',strtotime( $data['ActDoc']['ActDate']));
        $this->type = self::TYPE_ACT;
        $this->status = self::STATUS_SAVED;
        $this->is_view = self::NO_VIEWE_DOC;
        $this->write_type = self::SAVED_DOC;
        $this->created_date = date('Y-m-d H:i:s');
        $this->user_id =Yii::$app->user->id;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'doc_id' => Yii::t('app', 'Doc ID'),
            'tin' => Yii::t('app', 'Tin'),
            'contragent_tin' => Yii::t('app', 'Contragent Tin'),
            'contragent_name' => Yii::t('app', 'Contragent Name'),
            'contract_no' => Yii::t('app', 'Contract No'),
            'contract_date' => Yii::t('app', 'Contract Date'),
            'emp_no' => Yii::t('app', 'Emp No'),
            'emp_date' => Yii::t('app', 'Emp Date'),
            'doc_no' => Yii::t('app', 'Doc No'),
            'doc_date' => Yii::t('app', 'Doc Date'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'is_view' => Yii::t('app', 'Is View'),
            'created_date' => Yii::t('app', 'Created Date'),
            'write_type' => Yii::t('app', 'Write Type'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }
}

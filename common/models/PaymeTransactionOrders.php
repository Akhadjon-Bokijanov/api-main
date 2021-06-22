<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payme_transaction_orders".
 *
 * @property int $id
 * @property int $tin
 * @property int $amount
 * @property int $time
 * @property PaymeTransactions $transaction
 */
class PaymeTransactionOrders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payme_transaction_orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tin', 'amount', 'time'], 'required'],
            [['tin', 'amount', 'time'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tin' => 'Tin',
            'amount' => 'Amount',
            'time' => 'Time',
        ];
    }

    public function getTransaction()
    {
        return $this->hasOne(PaymeTransactions::class,['order_id'=>'id']);
    }
}

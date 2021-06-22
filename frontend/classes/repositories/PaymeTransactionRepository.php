<?php

namespace cabinet\classes\repositories;

use common\models\PaymeTransactions;

/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 18.12.2019
 * Time: 15:51
 */

class PaymeTransactionRepository
{

    /**
     * @param $data
     * @param \yii\db\Transaction|null $transaction
     * @return array|PaymeTransactions
     */
    public static function createTransaction($data, \yii\db\Transaction $transaction = null)
    {
//        var_dump($data);die;

        $model = PaymeTransactions::findOne(['order_id' => $data['account']['order_id']]);

        if($model && $model->transaction_id == $data['id'])
            return $model;
        elseif ($model && $model->transaction_id != $data['id']){
            $model->addError('transaction_id','Transaction with the same order_id already exists');
            return $model->errors;
        }

        $model = new PaymeTransactions();
        $model->transaction_id = $data['id'];
        $model->transaction_create_time = (string)$data['time'];
        $model->transaction_amount = $data['amount'];
        $model->transaction_account = json_encode($data['account']);
        $model->create_time = time() * 1000;
        $model->state = PaymeTransactions::STATE_NEW;
        $model->tin = $data['account']['tin'];
        $model->order_id = $data['account']['order_id'];

        if(!$model->save()){
            if($transaction)
                $transaction->rollBack();
            return $model->errors;
        }

        return $model;
    }

}
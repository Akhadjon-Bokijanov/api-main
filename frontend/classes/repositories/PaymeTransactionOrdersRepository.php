<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 19.12.2019
 * Time: 17:42
 */

namespace cabinet\classes\repositories;


use common\models\PaymeTransactionOrders;

class PaymeTransactionOrdersRepository
{

    public static function createOrder($tin,$amount, \yii\db\Transaction $transaction = null)
    {
        $order = new PaymeTransactionOrders();
        $order->tin = $tin;
        $order->amount = $amount;
        $order->time = time();

        if(!$order->save()){
            if($transaction)
                $transaction->rollBack();
            return $order->errors;
        }

        return $order;

    }

}
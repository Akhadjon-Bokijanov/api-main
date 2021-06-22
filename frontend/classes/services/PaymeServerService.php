<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 18.12.2019
 * Time: 12:23
 */
namespace cabinet\classes\services;


use common\models\PaymeTransactionOrders;
use common\models\PaymeTransactions;
use cabinet\classes\repositories\PaymeTransactionOrdersRepository;
use cabinet\classes\repositories\PaymeTransactionRepository;
use cabinet\classes\response\PaymeResponse;
use Yii;

class PaymeServerService extends \yii\base\BaseObject
{

    const MERCHANT_ID = 'MBuH?hXca&WoefpjjU@QYNGrnQUI9Y0QbRHV';
    const MERCHANT_ID_TEST = 'sDyxwD34y03JvCDc2iPM#OT?&U9HRIcfeuVe';
    const BACK_URL = 'https://cabinet.onlinefactura.uz/ru/invoices';
    const PAY_URL = 'https://test.paycom.uz';

    public static function pay($tin,$amount)
    {
        $order = PaymeTransactionOrdersRepository::createOrder($tin,$amount);

        if( !($order instanceof PaymeTransactionOrders) )
            return $order;

        $params = "m=".static::MERCHANT_ID.";";
        $params .= "ac.order_id=".$order->id.";";
        $params .= "ac.tin=".$tin.";";
        $params .= "a=".$amount.";";
        $params .= "l=ru;";
        $params .= "c=".static::BACK_URL.";";

        $url = static::PAY_URL . base64_encode($params);

        return Yii::$app->controller->redirect($url);
        
    }


    private function hasKeys(array $array, array $keys)
    {
        $array = array_keys($array);
        sort($array);
        sort($keys);
        return $array == $keys;
    }

    /*
     *                        __
     *  _______  ____  __ ___/  |_  ___________
     *  \_  __ \/  _ \|  |  \   __\/ __ \_  __ \
     *   |  | \(  <_> )  |  /|  | \  ___/|  | \/
     *   |__|   \____/|____/ |__|  \___  >__|
     *                                 \/
     */

    private $request;

    /**
     * @var PaymeResponse $response
     */
    public $response;


    public function init()
    {
        $this->request = Yii::$app->request->rawBody;
        $this->request = json_decode($this->request,true);
        $this->response->id = $this->request['id'];
//        var_dump(file_get_contents("php://input"));die;
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function run()
    {
        return $this->{$this->request['method']}( $this->request['params'] );
    }

    // -----------------------------------------------------------------------------------------------------<<<<<

    /**
    _____                                 __  __      _   _               _
    |  __ \                               |  \/  |    | | | |             | |
    | |__) |_ _ _   _ _ __ ___   ___      | \  / | ___| |_| |__   ___   __| |___
    |  ___/ _` | | | | '_ ` _ \ / _ \     | |\/| |/ _ \ __| '_ \ / _ \ / _` / __|
    | |  | (_| | |_| | | | | | |  __/     | |  | |  __/ |_| | | | (_) | (_| \__ \
    |_|   \__,_|\__, |_| |_| |_|\___|     |_|  |_|\___|\__|_| |_|\___/ \__,_|___/
     */

    // ------------------------------------------------------------------------------------------------------>>>>>


    /**
     * @see: https://help.paycom.uz/ru/metody-merchant-api/checkperformtransaction
     * @param $amount
     * @param $account
     * @return array
     */
    public function CheckPerformTransaction($params)
    {

        if( !$this->hasKeys($params,['amount','account']) || !$this->hasKeys($params['account'],['tin','order_id']) )
            return $this->response->error(-32504,"Incorrect parameters passed","order_id");

        extract($params);

        $transaction = PaymeTransactionOrders::findOne(['id' => @$account['order_id']]);

        if(!$transaction)
            return $this->response->error(-31050,"Transaction not found","order_id");

        if($transaction->transaction && $transaction->transaction->state != PaymeTransactions::STATE_NEW)
            return $this->response->error(-31050,"Already payed","order_id");

        if($transaction->amount != @$amount)
            return $this->response->error(-31001,"Incorrect amount","order_id");

        return $this->response->success([
            'allow' => true,
        ]);
    }

    /**
     * @see: https://help.paycom.uz/ru/metody-merchant-api/createtransaction
     * @param $id
     * @param $time
     * @param $amount
     * @param $account
     * @return array
     */
    public function CreateTransaction($params)
    {

        if( !$this->hasKeys($params,['id','time','amount','account']) || !$this->hasKeys($params['account'],['tin','order_id']) )
            return $this->response->error(-32504,"Incorrect parameters passed","order_id");

        extract($params);

        $order = PaymeTransactionOrders::findOne(['id' => $account['order_id']]);
//        var_dump(func_get_args());die;
        if(!$order)
            return $this->response->error(-31008, "Nothing to pay" . $account['order_id']);

        $model = PaymeTransactionRepository::createTransaction( compact('id', 'time', 'amount', 'account') );

        if( !($model instanceof PaymeTransactions) )
            return $this->response->error(-31050, $model);

        return $this->response->success([
            "create_time" => (int)$model->create_time,
            "transaction" => (string)$model->id,
            "state" => $model->state,
        ]);
    }

    /**
     * @see: https://help.paycom.uz/ru/metody-merchant-api/performtransaction
     * @param $id
     * @return array
     */
    public function PerformTransaction($params)
    {

        if( !isset($params['id']) )
            return $this->response->error(-32504,"Incorrect parameters passed","order_id");

        extract($params);

        $transaction = PaymeTransactions::findOne(['transaction_id' => $id]);

        if(!$transaction)
            return $this->response->error(-31003,"No transaction found","id");

        if($transaction->state == PaymeTransactions::STATE_COMPLETED)
            return $this->response->success([
                'transaction' => (string)$transaction->id,
                'perform_time' => (int)$transaction->perform_time,
                'state' => $transaction->state,
            ]);

        $transaction->state = PaymeTransactions::STATE_COMPLETED;
        $transaction->perform_time = time() * 1000;

        if($transaction->save())
            return $this->response->success([
                'transaction' => (string)$transaction->id,
                'perform_time' => (int)$transaction->perform_time,
                'state' => $transaction->state,
            ]);

        return $this->response->error(-31008,$transaction->errors);
    }

    /**
     * @see: https://help.paycom.uz/ru/metody-merchant-api/canceltransaction
     * @param $id
     * @param $reason
     * @return array
     */
    public function CancelTransaction($params)
    {

        if( !$this->hasKeys($params,['id','reason']) )
            return $this->response->error(-32504,"Incorrect parameters passed","order_id");

        extract($params);

        $transaction = PaymeTransactions::findOne(['transaction_id' => $id]);

        if(!$transaction)
            return $this->response->error(-31003,"No transaction found","id");

//        if($transaction->state != PaymeTransactions::STATE_NEW)
//            return $this->response->error(-31008,"Transaction already finished","id");

        $transaction->state = $transaction->state == PaymeTransactions::STATE_NEW ? PaymeTransactions::STATE_CANCELED : PaymeTransactions::STATE_CANCELED_AFTER_COMPLETE;
        $transaction->cancel_time = (string)(time() * 1000);
        $transaction->reason = $reason;

        if($transaction->save(false))
            return $this->response->success([
                'transaction' => (string)$transaction->id,
                'cancel_time' => (int)$transaction->cancel_time,
                'state' => $transaction->state,
            ]);

        return $this->response->error(-31008,$transaction->errors);

    }

    /**
     * @see: https://help.paycom.uz/ru/metody-merchant-api/checktransaction
     * @param $id
     * @return array
     */
    public function CheckTransaction($params)
    {

        if( !isset($params['id']) )
            return $this->response->error(-32504,"Incorrect parameters passed","order_id");

        if( !$this->hasKeys($params,['id','time','amount','account']) || !$this->hasKeys($params['account'],['tin','order_id']) )
            return $this->response->error(-32504,"Incorrect parameters passed","order_id");

        extract($params);

        $transaction = PaymeTransactions::findOne(['transaction_id' => $id]);

        if(!$transaction)
            return $this->response->error(-31003,"No transaction found","id");


        return $this->response->success([
            'create_time' => $transaction->create_time,
            'perform_time' => $transaction->perform_time,
            'cancel_time' => $transaction->cancel_time,
            'transaction' => (string)$transaction->id,
            'state' => $transaction->state,
            'reason' => $transaction->reason != null ? (int)$transaction->reason : null,
        ]);
    }

    /**
     * @see: https://help.paycom.uz/ru/metody-merchant-api/getstatement
     * @param $from
     * @param $to
     * @return array
     */
    public function GetStatement($params)
    {

        if( !$this->hasKeys($params,['from','to']) )
            return $this->response->error(-32504,"Incorrect parameters passed","order_id");

        extract($params);

        $models = PaymeTransactions::find()->andWhere(['between','transaction_create_time',$from,$to])->all();

        $data = array_map(function (PaymeTransactions $model){
            return [
                "id"            => $model->transaction_id,
                "time"          => $model->transaction_create_time,
                "amount"        => $model->transaction_amount,
                "account"       => json_decode($model->transaction_account,true),
                "create_time"   => $model->create_time,
                "perform_time"  => $model->perform_time,
                "cancel_time"   => $model->cancel_time,
                "transaction"   => $model->id,
                "state"         => $model->state,
                "reason"        => $model->reason,
            ];
        },$models);

        return $this->response->success(["transactions" => $data]);

    }

    /**
     * @see: https://help.paycom.uz/ru/metody-merchant-api/changepassword
     * @param $password
     */
    public function ChangePassword($params)
    {

        extract($params);

    }

}
<?php
namespace common\components\services;

use Yii;
use yii\httpclient\Client;


class Emp
{
    const LOGIN = 'onlinefactura';
    const PASSWORD = 'n;xw3CE(GDb$@|D*';

    const BASE_URL = 'https://factura.yt.uz';

    const BUYER_SIGNED_FILE = '/provider/api/uz/{tin}/empowerments/buyer/signedfile/';
    const BUYER_EMP_BY_ID = '/provider/api/uz/{tin}/empowerments/buyer/';
    const BUYER_EMP_LIST = '/provider/api/uz/{tin}/empowerments/buyer';
    const BUYER_EMP_SEND = '/provider/api/uz/{tin}/empowerments/buyer';
    const BUYER_EMP_CANCEL = '/provider/api/uz/{tin}/empowerments/buyer/cancel';

    const EMP_EXISTS = '/provider/api/{lang}/{tin}/empowerments/seller/checkexists';

    const SELLER_SIGNED_FILE = '/provider/api/uz/{tin}/empowerments/seller/signedfile/';
    const SELLER_EMP_BY_ID = '/provider/api/uz/{tin}/empowerments/seller/';
    const SELLER_EMP_LIST = '/provider/api/uz/{tin}/empowerments/seller';
    const SELLER_EMP_ANSWER = '/provider/api/uz/{tin}/empowerments/seller';

    const AGENT_SIGNED_FILE = '/provider/api/uz/{tin}/agent/empowerments/signedfile/';
    const AGENT_EMP_BY_ID = '/provider/api/uz/{tin}/agent/empowerments';
    const AGENT_EMP_LIST = '/provider/api/uz/{tin}/agent/empowerments';
    const AGENT_EMP_SEND = '/provider/api/uz/{tin}/agent/empowerments';


    public static function SellerEmpAnswer($tin,$data) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::SELLER_EMP_ANSWER))
            ->addHeaders(self::getAuth())
            ->setData($data)
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function BuyerEmpSignedFile($tin,$facturaId) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::BUYER_SIGNED_FILE.$facturaId))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }


    public static function BuyerEmpList($tin) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::BUYER_EMP_LIST))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function BuyerEmpById($tin,$facturaId) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::BUYER_EMP_BY_ID.$facturaId))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function BuyerEmpSend($tin,$data) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::BUYER_EMP_SEND))
            ->addHeaders(self::getAuth())
            ->setData($data)
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function BuyerEmpCancel($tin,$data) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::BUYER_EMP_CANCEL))
            ->addHeaders(self::getAuth())
            ->setData($data)
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function SellerEmpSignedFile($tin,$facturaId) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::SELLER_SIGNED_FILE.$facturaId))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }


    public static function SellerEmpList($tin) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::SELLER_EMP_LIST))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function SellerEmpById($tin,$facturaId) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::SELLER_EMP_BY_ID.$facturaId))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function SellerEmpSend($tin,$data) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::SELLER_EMP_SEND))
            ->addHeaders(self::getAuth())
            ->setData($data)
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function AgentEmpSignedFile($tin,$facturaId) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::AGENT_SIGNED_FILE.$facturaId))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }


    public static function AgentEmpList($tin) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::AGENT_EMP_LIST))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function AgentEmpById($tin,$facturaId) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::AGENT_EMP_BY_ID.$facturaId))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function AgentEmpSend($tin,$data) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::AGENT_EMP_SEND))
            ->addHeaders(self::getAuth())
            ->setData($data)
            ->send();
        return $response->isOk ? $response->data : [];
    }





    private static function getAuth() {
        return ['Authorization' => 'Basic ' . base64_encode(self::LOGIN.':'.self::PASSWORD)];
    }
}
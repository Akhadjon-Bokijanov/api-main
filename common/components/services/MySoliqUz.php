<?php
namespace common\components\services;

use Yii;
use yii\httpclient\Client;


class MySoliqUz
{
    const LOGIN = 'onlinefactura';
    const PASSWORD = '9826315157e93a13e05$';

    const BASE_URL = 'https://my.soliq.uz/';

    const NP1_BY_TIN = '/services/np1/bytin/factura';
    const TAXPAYERS_BY_TIN = '/services/np1/phisbytin/factura';
    const GET_COMPANY_DIRECTOR = '/services/np1/by-directortin/factura';
    const GET_LIST_CLASS_CODE = '/services/cl-api/class/get-list/by-company';
    const SEARCH_CLASS_CODE = '/services/cl-api/class/search';
    const SET_PRODCUTS_CLASS = '/services/cl-api/company/basket/product-add';
    const DELETE_PRODCUTS_CLASS = '/services/cl-api/company/product-delete';


    public static function getNp1ByTin($tin) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::NP1_BY_TIN)
            ->addHeaders(self::getAuth())
            ->setData(['lang' => Yii::$app->language,'tin'=>$tin])
            ->send();
         return $response->isOk ? $response->data : [];
    }

    public static function getTaxpayersByTin($tin) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::TAXPAYERS_BY_TIN)
            ->addHeaders(self::getAuth())
            ->setData(['lang' => Yii::$app->language,'tin'=>$tin])
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function getCompanyByDirector($tin) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::GET_COMPANY_DIRECTOR)
            ->addHeaders(self::getAuth())
            ->setData(['lang' => Yii::$app->language,'tin'=>$tin])
            ->send();
        return $response->isOk ? $response->data : [];
    }


    public static function getListClassCode($tin) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::GET_LIST_CLASS_CODE)
            ->addHeaders(self::getAuth())
            ->setData(['lang' => Yii::$app->language,'tin'=>$tin])
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function getClassSearch($key) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::SEARCH_CLASS_CODE)
            ->addHeaders(self::getAuth())
            ->setData(['search_text' => $key])
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function setProductsClassifications($data) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(self::BASE_URL.self::SET_PRODCUTS_CLASS)
            ->addHeaders(self::getAuth())
            ->setData($data)
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function deleteProductsClassifications($data) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(self::BASE_URL.self::DELETE_PRODCUTS_CLASS)
            ->addHeaders(self::getAuth())
            ->setData([$data])
            ->send();
        return $response->isOk ? $response->data : [];
    }

    private static function getAuth() {
        return ['Authorization' => 'Basic ' . base64_encode(self::LOGIN.':'.self::PASSWORD)];
    }
}
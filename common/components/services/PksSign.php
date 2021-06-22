<?php
namespace common\components\services;


use yii\helpers\Json;
use yii\helpers\VarDumper;
use function GuzzleHttp\Psr7\_caseless_remove;

class PksSign
{
    const BASE_URL = 'http://127.0.0.1:9090/';

    const VERIFY_PKS = 'dsvs/pkcs7/v1?wsdl';

    public static function AuthverifyPkcs7($data){
        $keyId = $data['keyId'];
        $guid = $data['guid'];
        $pkcs7 = $data['pkcs7'];
        $reason = "";$subjectModel = [];
        $client = new \SoapClient(self::BASE_URL.self::VERIFY_PKS);
        $result = $client->verifyPkcs7([ "pkcs7B64" =>$pkcs7]);
        $model = $result->return;
        if(empty($model))
            $reason = "Malumot topilmadi";
        if($reason=="")
            $model = Json::decode($model);
        if($model['success']==false)
            $reason = $model['reason'];
        if($reason==""){
            $model = $model['pkcs7Info'];
            $signers = $model['signers'];
            $signers = $signers[0];
            $keyid_main = base64_decode($model['documentBase64']);
//            VarDumper::dump($signers[0],12,true);die;
            if($signers['verified']==false){
                $reason = "ЭЦП не действительна";
            }
        }
        if($reason=="") {
            if ($guid != $keyid_main)
                $reason = "Xatolik: auth id not defined 1.-" . $keyId . " 2.-" . $keyid_main;

        }
        if($reason==""){
            if($signers['certificateVerified']==false){
                $reason="цепочка сертификатов не действительна";
            }
        }

        if($reason==""){
            if(isset($signers['exception'])) {
                if ($signers['exception'] != "") {
                    $reason = "Ошибка:" . $signers['exception'];
                }
            }
        }

        if($reason=="") {
            $certificate = $signers['certificate'];
            $subjectName = $certificate[0];
            $subjectName = $subjectName['subjectName'];
            $subjectData = explode(",", $subjectName);
            $subjectModel = [];
            foreach ($subjectData as $items) {
                $subjectItem = explode("=", $items);
                $subjectModel[$subjectItem[0]] = $subjectItem[1];
            }
        }


        if($reason==""){
            return [
              'success'=>true,
              'data'=>$subjectModel
            ];
        }  else {
            return [
                'success'=>false,
                'reason'=>$reason
            ];
        }
    }

    public static function AfertaVerifyPkcs7($data){
        $pkcs7 = $data['pkcs7'];
        $reason = "";$subjectModel = [];
        $client = new \SoapClient(self::BASE_URL.self::VERIFY_PKS);
        $result = $client->verifyPkcs7([ "pkcs7B64" =>$pkcs7]);
        $model = $result->return;
        if(empty($model))
            $reason = "Malumot topilmadi";
        if($reason=="")
            $model = Json::decode($model);
        if($model['success']==false)
            $reason = $model['reason'];
        if($reason==""){
            $model = $model['pkcs7Info'];
            $signers = $model['signers'];
            $signers = $signers[0];
            $keyid_main = base64_decode($model['documentBase64']);
//            VarDumper::dump($signers[0],12,true);die;
            if($signers['verified']==false){
                $reason = "ЭЦП не действительна";
            }
        }
//        if($reason=="") {
//            if ($guid != $keyid_main)
//                $reason = "Xatolik: auth id not defined 1.-" . $keyId . " 2.-" . $keyid_main;
//
//        }
        if($reason==""){
            if($signers['certificateVerified']==false){
                $reason="цепочка сертификатов не действительна";
            }
        }

        if($reason==""){
            if(isset($signers['exception'])) {
                if ($signers['exception'] != "") {
                    $reason = "Ошибка:" . $signers['exception'];
                }
            }
        }

        if($reason=="") {
            $certificate = $signers['certificate'];
            $subjectName = $certificate[0];
            $subjectName = $subjectName['subjectName'];
            $subjectData = explode(",", $subjectName);
            $subjectModel = [];
            foreach ($subjectData as $items) {
                $subjectItem = explode("=", $items);
                $subjectModel[$subjectItem[0]] = $subjectItem[1];
            }
        }


        if($reason==""){
            return [
                'success'=>true,
                'data'=>$subjectModel
            ];
        }  else {
            return [
                'success'=>false,
                'reason'=>$reason
            ];
        }
    }

    public static function VerifyPkcs7($pkcs7){
//        $pkcs7 = $data['Sign'];
        $reason = "";$subjectModel = [];
        $client = new \SoapClient(self::BASE_URL.self::VERIFY_PKS);
        $result = $client->verifyPkcs7([ "pkcs7B64" =>$pkcs7]);
        $model = $result->return;
        if(empty($model))
            $reason = "Malumot topilmadi";
        if($reason=="")
            $model = Json::decode($model);
        if($model['success']==false)
            $reason = $model['reason'];
        if($reason==""){
            $model = $model['pkcs7Info'];
            $signers = $model['signers'];
            $signers = $signers[0];
            $doc_data = base64_decode($model['documentBase64']);
            if($signers['verified']==false){
                $reason = "ЭЦП не действительна";
            }
        }

        if($reason==""){
            if($signers['certificateVerified']==false){
                $reason="цепочка сертификатов не действительна";
            }
        }

        if($reason==""){
            if(isset($signers['exception'])) {
                if ($signers['exception'] != "") {
                    $reason = "Ошибка:" . $signers['exception'];
                }
            }
        }

        if($reason=="") {
            $certificate = $signers['certificate'];
            $subjectName = $certificate[0];
            $subjectName = $subjectName['subjectName'];
            $subjectData = explode(",", $subjectName);
            $subjectModel = [];
            foreach ($subjectData as $items) {
                $subjectItem = explode("=", $items);
                $subjectModel[$subjectItem[0]] = $subjectItem[1];
            }
        }


        if($reason==""){
            return [
                'success'=>true,
                'data'=>$doc_data,
                'subject'=>$subjectModel
            ];
        }  else {
            return [
                'success'=>false,
                'reason'=>$reason
            ];
        }
    }
}
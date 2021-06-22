<?php
namespace frontend\controllers;


use common\components\services\MySoliqUz;
use common\components\services\PksSign;
use common\models\User;
use common\models\Users;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\ErrorAction;

/**
 * Site controller
 */
class SiteController extends BaseApi
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'optional' => [
                'auth','get-company'
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return [ 'MESSAGES'=>'Wellcome to API systems!',
            'DATE_TIME_MACHINE'=> date('Y-m-d H:i:s'),
            'CUREENT_LANGUAGE'=>Yii::$app->language
        ];
    }


    public function actionGetCompany($tin){
//        $number  = substr($tin,0,1);
//        if($number==2 || $number==3)
            return MySoliqUz::getNp1ByTin($tin);
//        else
//            return MySoliqUz::getTaxpayersByTin($tin);
    }

    /*
       {"keyId": "asdasd",
        "guid": "sdffasdf",
        "pkcs7": "asdfasdf"
       } */



    public function actionAuth(){
        $reason = "";
        try {
            $data = Json::decode(Yii::$app->request->rawBody);
//            var_dump($data);die;
            $pksData = PksSign::AuthverifyPkcs7($data);

            if($pksData['success']==false)
                $reason = $pksData['reason'];
            else
                $pksData = $pksData['data'];
            if($reason==""){
                $userData =  Users::SignUp($pksData);
                if($userData['success']==false)
                    $reason = $userData['reason'];
                else
                    $userData = $userData['data'];

            }

        } catch (\ErrorException $e){
            $reason = $e->getMessage();
        }



        if($reason==""){

            return [
                'success'=>true,
                'token'=>User::generateToken($userData),
                'data'=>$userData
            ];
        } else {
            return [
                'success'=>false,
                'reason'=>$reason
            ];
        }
    }


}

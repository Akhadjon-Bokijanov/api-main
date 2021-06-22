<?php
namespace frontend\controllers;


use common\components\services\Facturas;
use common\components\services\MySoliqUz;
use common\components\services\PksSign;
use common\models\Aferta;
use common\models\Company;
use common\models\CompanyUsers;
use common\models\User;
use common\models\Users;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Lcobucci\JWT\Token;
use sizeg\jwt\JwtHttpBearerAuth;
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
class UserController extends BaseApi
{
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }


    public function actionGetCompanyData($tin){
        $model = CompanyUsers::find()->andWhere(['company_tin'=>$tin,'user_tin'=>Yii::$app->user->identity->username])->one();
        if(!empty($model)){
            $company =  Company::findOne(['tin'=>$tin]);
            if(empty($company))
               $company = Company::SetCompany($tin);
            return [
                'success'=>true,
                'company'=>$company,
                'user'=>Yii::$app->user->identity
            ];
        }else
            return [
               'success'=>false,
               'reason'=>'Ko`rsatilgan STIR sizga tegishli emas'
            ];
        }

    public function actionGetUserData(){
         return Yii::$app->user->identity;
    }

    public function actionSetAferta(){
        $reason = "";

        try {
            $data = Json::decode(Yii::$app->request->rawBody);
            $pksData = PksSign::AfertaVerifyPkcs7($data);
            if($pksData['success']==false)
                $reason = $pksData['reason'];
            else
                $pksData = $pksData['data'];
            if($reason==""){
                $setAFerta =  Aferta::AcceptAferta($pksData,$data);
//                var_dump($setAFerta);die;
                if($setAFerta['success']==false)
                    $reason = $setAFerta['reason'];
            }
        } catch (\ErrorException $e){
            $reason = $e->getMessage();
        }
//        echo "asasdd";die;
        return $reason==""?['success'=>true]:['success'=>false,'reason'=>$reason];
    }

    public function actionBindProvider(){
        $reason = "";
        try {
            $data = Json::decode(Yii::$app->request->rawBody);
            $resultBind  =  Facturas::BindProvider($data['sign']);
            $reason = (isset($resultBind['errorMessage'])) ? $resultBind['errorMessage'] : '';
            if($reason=="") {
//                $reason = $data['tin'];
//                echo $data['tin'];die;
                $model = Company::findOne(['tin' => $data['tin']]);
                if (!empty($model)) {
                    $model->is_online = 1;
                    if (!$model->save()) {
                        $reason = Json::encode($model->getErrors());
                    }
                }
            }
        } catch (\ErrorException $e){
            $reason = $e->getMessage();
        }
        return $reason==""?['success'=>true]:['success'=>false,'reason'=>$reason];

    }

}

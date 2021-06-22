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
class InfoController extends BaseApi
{
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function actionDirectorCompany($tin){
        $model = CompanyUsers::find()->andWhere(['user_tin'=>$tin]);
        return [
            'success'=>true,
            'count'=>$model->count(),
            'data'=>$model->all()
        ];
    }

    public function actionContragentByTin($tin){
        $number  = substr($tin,0,1);
        if($number==2 || $number==3)
            return MySoliqUz::getNp1ByTin($tin);
        else
            return MySoliqUz::getTaxpayersByTin($tin);
    }

    public function actionCompanyByTin($tin){
        $model = Company::find()->andWhere(['tin'=>$tin]);
        $resultData =[];
        foreach ($model as $key=>$value){
            $resultData[]=[
               "Company[{$key}]"=>$value
            ] ;
        }
        return [
           'success'=>true,
           'data'=>$resultData
        ];
    }

    public function actionGetAferta(){
        $model = Aferta::findOne(['status'=>Aferta::ACTIV_AFERTA]);
        $language = Yii::$app->language;
        if(isset($model['body_'.$language]))
            return [
                'success'=>true,
                'data'=>$model['body_'.$language],
            ];
        else
            return [
                'success'=>false,
                'reason'=>'Til parametri notogri'
            ];
    }

    public function actionMeasure(){
        return Facturas::GetMeasureList();
    }

    public function actionMeasureView($id){
        return Facturas::GetMeasureView($id);
    }

    public function actionRegions(){
        return Facturas::GetRegionsList();
    }

    public function actionRegionsView($id){
        return Facturas::GetRegionView($id);
    }

    public function actionDistrict(){
        return Facturas::GetDistrictList();
    }

    public function actionDistrictView($id){
        return Facturas::GetDistrictView($id);
    }

    public function actionGetBindProvider($tin){
        return Facturas::GetBindProvider($tin);
    }

    public function actionGetGuid(){
        return Facturas::GetGuid();
    }

}

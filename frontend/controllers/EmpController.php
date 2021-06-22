<?php
namespace frontend\controllers;





use common\components\services\Emp;
use common\components\services\Facturas;
use common\components\services\MySoliqUz;
use common\components\services\PksSign;
use common\models\Aferta;
use common\models\AllDocuments;
use common\models\AllDocumentsSearch;
use common\models\Company;
use common\models\CompanyUsers;
use common\models\Files;
use common\models\User;
use common\models\Users;
use frontend\classes\consts\ExcelConst;
use frontend\classes\viewers\ExcelViewer;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\mongodb\Query;
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
class EmpController extends BaseApi
{
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function actionUpdate($tin,$id){
        $reason = "";
        try {
            $data = Json::decode(Yii::$app->request->rawBody);
            if($reason==""){
                $modelDoc = AllDocuments::findOne(['doc_id'=>$id,'tin'=>$tin]);
                if(empty($modelDoc))
                    $reason = "Malumot topilmadi";
            }
            if($reason==""){
                $collection = Yii::$app->mongodb->getCollection('empowerment');
                $collection->update(["EmpowermentId"=>$id],$data);
//                $id = get_object_vars($collection);
//                if(!isset($id['oid']))
//                    $reason = "Malumotlarni saqlashda xatolik";
            }
            if($reason==""){
                $modelDoc->SetEmpData($data);
                if(!$modelDoc->save()){
                    $reason = Json::encode($modelDoc->getErrors());
                }
            }
        } catch (\ErrorException $e){
            $reason = $e->getMessage();
        }
        return $reason==""?['success'=>true]:['success'=>false,'reason'=>$reason];
    }

    public function actionSend($tin){
        $reason = "";
        if(CompanyUsers::CheckCompany($tin)==false)
            $reason = "Kiritilgan STIR foydalanuvchiga tegishli emas";
        try {
            if($reason=="") {
                $data = Json::decode(Yii::$app->request->rawBody);
                $data['ClientIp'] = Yii::$app->request->getUserIP();
                $collection = Yii::$app->mongodb->getCollection('send_factura_log');
                $collection->insert(["sign" => $data['Sign'], 'client_ip' => $data['ClientIp'], 'user_id' => Yii::$app->user->id, 'company_tin' => $tin]);
                $sendData = Emp::BuyerEmpSend($tin, $data);
                $reason = (isset($sendData['errorMessage'])) ? $sendData['errorMessage'] : '';
            }
        } catch (\ErrorException $e){
            $reason = $e->getMessage();
        }
        return $reason==""?['success'=>true,'verify'=>self::VerifyBySign($data['Sign'])]:['success'=>false,'reason'=>$reason];
    }

    public function actionImportExcel(){
        $request = Yii::$app->request;
        $model = new Files();
        $reason = "";
        if(Yii::$app->request->isPost){
            $productsItesm = [];
            $r = $model->upload();
            if($r!==true)
                $reason = $r;
            if($reason==""){
//                $data = ExcelViewer::readFull(Yii::getAlias(ExcelConst::FILE_PATH . ExcelConst::FILE_NAME));
                $fileName = Yii::getAlias(ExcelConst::FILE_PATH . ExcelConst::FILE_NAME);
//                $data = \moonland\phpexcel\Excel::import(
//                    Yii::getAlias(ExcelConst::FILE_PATH . ExcelConst::FILE_NAME)
//                ); // $config is an optional
                $data = \moonland\phpexcel\Excel::widget([
                    'mode' => 'import', 
                    'fileName' => $fileName,
                    'leaveRecordByIndex'=>1,
                    'setFirstRecordAsKeys' => false, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
                    'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
//                    'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                ]);

                $i=0;
//                echo "<pre>";
//                var_dump($data['faktura']);die;
                foreach ($data['faktura'] as $items) {
                    $i++;
//                    var_dump($items);die;
                    if($i>=ExcelConst::ROW_BEGIN_KEY) {
                        $productsItesm[] =
                            [
                                "ProductName" => $items[ExcelConst::EMP_NAME],
                                "ProductMeasureId" => $items[ExcelConst::EMP_MEASURE],
                                "ProductCount" => (int)$items[ExcelConst::EMP_COUNT],
                            ];
                    }
                }
//                echo $i;die;
            }
            return  $reason==""?['success'=>true,'data'=>$productsItesm]:['success'=>false,'reason'=>$reason];
        }
        return ['messages'=>'post method'];
    }

    public function actionCreate(){
        $reason = "";
        try {
            $data = Json::decode(Yii::$app->request->rawBody);
            $collection = Yii::$app->mongodb->getCollection('empowerment');
            $id = $collection->insert($data);
            $id = get_object_vars($id);
            if(!isset($id['oid']))
                $reason = "Malumotlarni saqlashda xatolik";
            if($reason==""){
                $model = new AllDocuments();
                $model->SetEmpData($data);
                if(!$model->save())
                    $reason = Json::encode($model->getErrors());
            }
        } catch (\ErrorException $e){
            $reason = $e->getMessage();
        }
        return $reason==""?['success'=>true]:['success'=>false,'reason'=>$reason];
    }

    public function actionView($EmpId,$tin){
        $reason = "";
        if(CompanyUsers::CheckCompany($tin)==false)
            $reason = "Kiritilgan STIR foydalanuvchiga tegishli emas.";
        if($reason==""){
            $query = new Query();
            $model =$query->from("empowerment")
                ->andWhere(['EmpowermentId'=>$EmpId])->limit(1)->all();
            return [
               'success'=>true,
               'data'=>$model
            ];
        } else {
            return [
                'success'=>false,
                'reason'=>$reason
            ];
        }
    }

    public function actionDelete($tin,$id){
        $reason = "";
        if(CompanyUsers::CheckCompany($tin)==false)
            $reason = "Kiritilgan STIR foydalanuvchiga tegishli emas";
        try {
            $collection = Yii::$app->mongodb->getCollection('empowerment');
            $id = $collection->delete(['EmpowermentId'=>$id]);
            AllDocuments::deleteAll(['tin'=>$tin,'doc_id'=>$id]);
        } catch (\ErrorException $e){
            $reason = $e->getMessage();
        }
        return $reason==""?['success'=>true,]:['success'=>false,'reason'=>$reason];
    }


    public function actionIndex($tin){
        $reason = "";
        $begin_date = Yii::$app->request->get('begin_date',null);
        $end_date = Yii::$app->request->get('end_date',null);
        if(CompanyUsers::CheckCompany($tin)==false)
            $reason = "Kiritilgan STIR foydalanuvchiga tegishli emas.";
        if($reason==""){
            $searchModel = new AllDocumentsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            if($begin_date!=null && $end_date!=null)
                $dataProvider->query->where(['between','created_date',$begin_date,$end_date]);
            $dataProvider->query->andWhere(['tin'=>$tin,'type'=>AllDocuments::TYPE_EMP]);

               return [
                   'success'=>true,
                   'data'=>$dataProvider,
                   'pages'=>$dataProvider->pagination
               ];
        } else {
            return  [
                'success'=>false,
                'reason'=>$reason
            ];
        }
    }



//    public function actionSend($tin){
//        $reason = "";
//        if(CompanyUsers::CheckCompany($tin)==false)
//            $reason = "Kiritilgan STIR foydalanuvchiga tegishli emas";
//        try {
//            if($reason=="") {
//                $data = Json::decode(Yii::$app->request->rawBody);
//                $data['ClientIp'] = Yii::$app->request->getUserIP();
//                $collection = Yii::$app->mongodb->getCollection('send_factura_log');
//                $collection->insert(["sign" => $data['Sign'], 'client_ip' => $data['ClientIp'], 'user_id' => Yii::$app->user->id, 'company_tin' => $tin]);
//                $sendData = Facturas::SellerFacturaSend($tin, $data);
//                $reason = (isset($sendData['errorMessage'])) ? $sendData['errorMessage'] : '';
//            }
//        } catch (\ErrorException $e){
//            $reason = $e->getMessage();
//        }
//        return $reason==""?['success'=>true,'verify'=>self::VerifyBySign($data['Sign'])]:['success'=>false,'reason'=>$reason];
//    }


    protected static function VerifyBySign($data){
        $FacutraData = PksSign::VerifyPkcs7($data);
        if (isset($FacutraData['success']) && $FacutraData['success']==true) {
            $FacutraData = Json::decode($FacutraData['data']);
            $model = AllDocuments::findOne(['doc_id' => $FacutraData['EmpowermentId']]);
            if (!empty($model)) {
                $model->status = AllDocuments::STATUS_SEND;
                $model->save();
            } else {
                 return false;
            }
        }
        return $FacutraData;
    }



}

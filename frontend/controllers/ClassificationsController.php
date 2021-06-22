<?php

namespace frontend\controllers;

use common\components\services\MySoliqUz;
use common\components\services\PksSign;
use common\models\User;
use common\models\Users;
use Yii;
use common\models\Classifications;
use common\models\ClassificationsSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClassificationsController implements the CRUD actions for Classifications model.
 */
class ClassificationsController extends BaseApi
{
    /**
     * Lists all Classifications models.
     * @return mixed
     */
    public function actionIndex($tin)
    {
        $searchModel = new ClassificationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tin'=>$tin]);
        return  [
//            'searchModel' => $searchModel,
            'data' => $dataProvider,
        ];
    }

    public function actionSearch($key){
        return MySoliqUz::getClassSearch($key);
    }

//    {
//        "tin": "200523221",
//        "class_codes": [
//           "12",
//           "34",
//           "45"
//        ]
//    }

    public function actionAddProducts(){
        $reason = "";
        try {
            $data = Json::decode(Yii::$app->request->rawBody);
        } catch (\ErrorException $e){
            $reason = $e->getMessage();
        }
        if($reason==""){

            return [
                'success'=>true,
                'data'=>MySoliqUz::setProductsClassifications($data)
            ];
        } else {
            return [
                'success'=>false,
                'reason'=>$reason
            ];
        }
    }

    public function actionReload($tin)
    {
        $model = MySoliqUz::getListClassCode($tin);
        if(isset($model['success']) && $model['success']==true){
            $delete = Classifications::deleteAll(['tin'=>$tin]);
            foreach ($model['data'] as $items){
                $data = new Classifications();
                $data->tin = $tin;
                $data->groupCode = $items['groupCode'];
                $data->classCode = $items['classCode'];
                $data->className = $items['className'];
                $data->productCode = $items['productCode'];
                $data->productName = $items['productName'];
                $data->save();

            }
            $data = Classifications::findAll(['tin'=>$tin]);
            return  ['success'=>true,'data'=>$data];
        } else {
            return $model;
        }


    }


    /**
     * Displays a single Classifications model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Classifications model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Classifications();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Classifications model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Classifications model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$tin)
    {
        $model = Classifications::find()->andWhere(['tin'=>$tin,'id'=>$id])->one();
        if(empty($model))
            return ['success'=>false,'reason'=>'Malumot topilmadi'];
        else {
             $model->delete();
            return ['success'=>true];
        }

    }

    /**
     * Finds the Classifications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Classifications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Classifications::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 20.09.2019
 * Time: 17:01
 */

namespace frontend\controllers;


use bizley\jwt\JwtHttpBearerAuth;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

abstract class BaseApi extends Controller
{


    public function behaviors()
    {

        return [

            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['*'],
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ],
            'authenticator'=>[
                'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
                'optional' => [
                    'auth',
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'index'  => ['GET'],
                    'view'   => ['GET'],
                    'create' => ['GET', 'POST'],
                    'update' => ['GET', 'PUT', 'POST'],
                    'delete' => ['POST','GET'],
                    'add-products' => ['POST'],
                    'import-excel' => ['POST'],
                    'send' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return true;
                        }
                    ],
                ],
            ],
        ];
    }

}
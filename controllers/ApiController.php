<?php

namespace app\controllers;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use app\models\LoginForm;
use app\models\Articles;

use yii\filters\auth\QueryParamAuth;
class ApiController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [


                'corsFilter' => [
                    'class' => \yii\filters\Cors::className(),
                    'cors'  => [
                        'Origin'                           => ['*'],
                        'Access-Control-Request-Method'    => ['POST', 'GET','PUT','DELETE','PATCH','OPTIONS'],
                        'Access-Control-Allow-Credentials' => true,
                        'Access-Control-Request-Headers' => ['*'],
                        'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                        'Access-Control-Expose-Headers' => ['*'],
//                        'Access-Control-Allow-Origin' => ['*'],

                    ]
                ]
            ]
        );
    }

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data'
    ];



}

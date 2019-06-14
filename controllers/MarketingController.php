<?php

namespace app\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;

class MarketingController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Marketing';
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
                'authenticator' => [
                    'class' => QueryParamAuth::className(),
                ],

                'corsFilter' => [
                    'class' => \yii\filters\Cors::className(),
                    'cors'  => [
                        'Origin'                           => ['*', 'http://bi.verworren.net'],
                        'Access-Control-Request-Method'    => ['POST', 'GET','PUT','DELETE','PATCH','OPTIONS'],
                        'Access-Control-Allow-Credentials' => true,
                        'Access-Control-Request-Headers' => ['*'],
                        'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                        'Access-Control-Expose-Headers' => ['*'],
                        'Access-Control-Allow-Origin' => ['*', 'http://bi.verworren.net'],

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

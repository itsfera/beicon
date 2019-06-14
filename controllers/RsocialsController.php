<?php

namespace app\controllers;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use app\models\Socials;

class RsocialsController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Socials';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data'
    ];

    /**
     * @inheritdoc
     */
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
}

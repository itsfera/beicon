<?php

namespace app\controllers;
use app\models\Articles;
use yii\rest\ActiveController;
use app\models\Rss;
use yii\helpers\ArrayHelper;

use yii\filters\auth\QueryParamAuth;
class RssController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Rss';
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
                'authenticator' => [
                    'class' => QueryParamAuth::className(),
                ],

                'corsFilter' => [
                    'class' => \yii\filters\Cors::className(),
                    'cors'  => [
                        'Origin'                           => ['*'],
                        'Access-Control-Request-Method'    => ['POST', 'GET','PUT','DELETE','PATCH','OPTIONS'],
                        'Access-Control-Allow-Credentials' => true,
                        'Access-Control-Request-Headers' => ['*'],
                        'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                        'Access-Control-Expose-Headers' => ['*'],
                        'Access-Control-Allow-Origin' => ['*'],


                    ]
                ]
            ]
        );
    }

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data'
    ];



    public function actions()
    {
        $actions = parent::actions();
//        unset($actions["update"]);
        // disable the "delete" and "create" actions
//        unset($actions['delete'], $actions['create']);

        // customize the data provider preparation with the "prepareDataProvider()" method
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
//        $actions['update']['prepareDataProvider'] = [$this, 'prepareDataProviderUpdate'];


        return $actions;
    }


    public function prepareDataProvider()
    {
        // prepare and return a data provider for the "index" action
        $model = new Rss();
        $res = $model->search(\Yii::$app->request->queryParams);


        return $res;
    }


}

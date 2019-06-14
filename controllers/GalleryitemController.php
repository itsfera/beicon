<?php

namespace app\controllers;

use app\models\GalleryItems;
use yii\helpers\ArrayHelper;
use app\models\Image;
use app\models\Articles;

use yii\filters\auth\QueryParamAuth;

class GalleryitemController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\GalleryItems';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data'
    ];



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

    public function actionSorting(){
        $f = \Yii::$app->request->post();

        if(isset($f) && is_array($f)) {

            foreach ($f as $item) {
                $el = GalleryItems::findOne($item["id"]);
                $el->sort = $item["sort"];
                if(!$el->save())
                    return ['status' => 'error', $el->getErrors()];
            }
            return ['items' => $f, 'status' => 'success'];
        } else {
        return ['status' => 'error', 'message' => 'Нет Items'];
        }


    }

    public function actions()
    {
        $actions = parent::actions();

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
        $model = new GalleryItems();
        $res = $model->search(\Yii::$app->request->queryParams);


        return $res;
    }
}
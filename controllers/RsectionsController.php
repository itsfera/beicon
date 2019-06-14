<?php

namespace app\controllers;

use Bitrix\Iblock\Model\Section;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Sections;
use app\models\Articles;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

use yii\filters\auth\QueryParamAuth;
class RsectionsController extends ActiveController
{

    CONST API_KEY = 'Pj55UTx5eAb34fqVCzfuR9jxrfk8Fz';
    public $modelClass = 'app\models\Sections';


    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data'
    ];

 

    public function init()
    {
        parent::init();
        // отключаем механизм сессий в api
        \Yii::$app->user->enableSession = false;
    }

    public function actionUpdate($id){
        die('asdas');
    }

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

    public function actionView($id){ return Sections::findOne(['id' => $id]); }

    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions
//        unset($actions['delete'], $actions['create']);

        // customize the data provider preparation with the "prepareDataProvider()" method
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        // prepare and return a data provider for the "index" action
        $model = new Sections();
        return $model->search(\Yii::$app->request->queryParams);
    }


}
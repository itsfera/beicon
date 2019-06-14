<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\Sections;
use app\models\Recomended;
use app\models\Articles;
use app\models\PartnersNews;
use app\models\Tags;
use app\models\Atags;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

use yii\filters\auth\QueryParamAuth;
class PnewsController extends ActiveController
{

    public $modelClass = 'app\models\PartnersNews';

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

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data'
    ];

    public function actions()
    {
        $actions = parent::actions();
        unset($actions["update"]);
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
        $model = new PartnersNews();
        $res = $model->search(\Yii::$app->request->queryParams);


        return $res;
    }


    public function actionUpdate(){
        $post = \Yii::$app->request->post();
        unset($post["preview_img"]);
        $post_id = \Yii::$app->request->queryParams;
        $post_id = (int)$post_id["id"];
        $item = PartnersNews::findOne($post_id);


        if($e = $item->load($post, '')){
            if ($item->save() && $item->validate()){
                return array('status' => 'success', 'data' => $item);
            } else {
                return array('status' => 'error', 'message' => 'Не прошло валидацию', 'errors' => $item->getErrors());
            }
        } else return array('status' => 'error', 'message' => 'Пустой запрос');

    }








}
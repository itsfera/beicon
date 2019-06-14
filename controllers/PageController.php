<?php

namespace app\controllers;
use app\models\Pages;
use Bitrix\Main\Page;
use yii\helpers\ArrayHelper;
use app\models\LoginForm;
use yii;
class PageController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Pages';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data'
    ];
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
        $model = new Pages();
        return $model->search(\Yii::$app->request->queryParams);
    }


    public function actionApilog()
    {

        $model = new LoginForm();
        $p = Yii::$app->request->post();
        $model->username = $p["username"];
        $model->password = $p["password"];
        if ($model->getUser()) {
            if($user = $model->login())
                return ['access-token' => $user];
            else return ['status' => 'error', 'message' => 'Не верный логин или пароль'];
        } else {
            return ['status' => 'error', 'message' => $model->getErrors()];
        }
    }


 


    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * @inheritdoc
     */
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
                    //    'Access-Control-Allow-Origin' => ['*'],

                    ]
                ]
            ]
        );
    }
}

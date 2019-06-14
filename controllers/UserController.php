<?php
namespace app\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\models\User;
use app\models\LoginForm;

class UserController extends ActiveController
{
    CONST API_KEY = 'Pj55UTx5eAb34fqVCzfuR9jxrfk8Fz';
    public $modelClass = 'app\models\User';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data'
    ];


    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
//                'access' => [
//                    'class' => AccessControl::className(),
//                    'user' => false,
//                    'rules' => [
//                        [
//                            'allow' => true,
//                            'matchCallback' => function ($rule, $action) {
//
//                                $data = \Yii::$app->request;
//                                $token = $data->get('auth_token');
//
//                                return isset($token) && $token === self::API_KEY;
//                            },
//                        ],
//                    ],
//                    'denyCallback' => function ($rule, $action) {
//
//                        return false;
//
//
//                    }
//                ],
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

                    ],
                ]
            ]
        );
    }

    /**
     * @inheritdoc
     */

    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions
//        unset($actions['delete'], $actions['create']);

        // customize the data provider preparation with the "prepareDataProvider()" method
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        unset($actions["create"]);
        return $actions;
    }

    public function actionCreate()
    {
        $model = new User();
        $post = \Yii::$app->request->post();

        $model->attributes = $post;
        $model->password = md5($model->password);
        $model->auth_key = 'Pj55UTx5eAb34fqVCzfuR9jxrfk8Fz';
        if($model->save()) {
            return ['user' => $model];
        } else {
            return ['error' => $model->getErrors()];
        }
    }

    public function actionChangepass()
    {
        $model = new LoginForm();
        $p = Yii::$app->request->post();
        $model->password = $p["password"];
        if ($userModel = $model->getUser()) {
            if($user = $model->login(false)) {
                $userModel->password = md5($p["new_password"]);
                $userModel->save();
                return ['status' => 'success', 'message' => 'Пароль успешно изменен'];
            } else return ['status' => 'error', 'message' => 'Не верный логин или пароль'];
        } else {
            return ['status' => 'error', 'message' => $model->getErrors()];
        }
    }

    public function actionGet()
    {
        $get = \Yii::$app->request->get();
        if($user = User::findIdentityByAccessToken($get["access-token"])){
            return ['user' => $user];
        } else return false;
    }

    public function prepareDataProvider()
    {
        // prepare and return a data provider for the "index" action
        $model = new User();
        return $model->search(\Yii::$app->request->queryParams);
    }

}
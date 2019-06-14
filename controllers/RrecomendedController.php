<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\Sections;
use app\models\Articles;
use app\models\Tags;
use app\models\Atags;
use app\models\Recomended;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

use yii\filters\auth\QueryParamAuth;
class RrecomendedController extends ActiveController
{

    public $modelClass = 'app\models\Recomended';

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
<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\Sections;
use app\models\Articles;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

class RsectionsController extends ActiveController
{

    public $modelClass = 'app\models\Sections';



    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data'
    ];

    /**
     * @inheritdoc
     */


}
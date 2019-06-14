<?php

namespace app\controllers;

use app\models\Category;
use app\models\Gallery;
use app\models\Marketing;
use app\models\SectionsCategory;
use app\models\Seo;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Sections;
use app\models\Articles;
use app\models\ImageSizes;
use app\models\Recomended;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\Pages;

use app\models\Image as customImage;

use yii\filters\auth\QueryParamAuth;
class PController extends Controller
{
    public function actionView($url)
    {
        $page = Pages::findOne(['url' => $url]);
        if ($page === null) {
            throw new NotFoundHttpException;
        }

        return $this->render('page', [
            'page' => $page,
            'header' => 'y'
        ]);
    }
}
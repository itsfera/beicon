<?php

namespace app\controllers;

use app\models\Category;
use app\models\Sections;
use app\models\SectionsCategory;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use yii\web\Controller;
use app\models\Articles;
use app\models\Seo;


class PubcategoryController extends Controller
{




    public function actionView($url)
    {
        $model = Category::find()->where(['url' => $url])->one();
        if ($model === null) {
            throw new NotFoundHttpException;
        }
        $id = $model->id;

        $sections = SectionsCategory::find()->where(['category_id' => $id])->all();
        $ids = array();
        foreach ($sections as $section){
            $ids[] = $section->id;
        }

        $articles = Articles::find()->where(['section' => $ids, 'status' => 'publish'])->orderBy(['date_publish' => SORT_DESC])->limit(20)->all();



        foreach ($articles as $k => $article){
            if($article["preview_img"]) {
                $articles[$k]["preview_img"] = ImageSizes::getResizesName($article["preview_img"], 'rectangle');
            }
            if($article["header_img"]) {
                $articles[$k]["header_img"] = ImageSizes::getResizesName($article["header_img"], 'rectangle');
            }
        }


        $seo = Seo::find()->where(['tbl' => 'sections', 'id_record' => $id])->one();
        if($seo) {
            \Yii::$app->view->title = $seo->title;

            \Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $seo->description
            ]);
            \Yii::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $seo->keywords
            ]);
            \Yii::$app->view->registerMetaTag([
                'name' => 'og:title',
                'content' => $seo->og_title
            ]);
            \Yii::$app->view->registerMetaTag([
                'name' => 'og:description',
                'content' => $seo->og_description
            ]);
            \Yii::$app->view->registerMetaTag([
                'name' => 'og:locale',
                'content' => $seo->og_locale
            ]);
            \Yii::$app->view->registerMetaTag([
                'name' => 'og:image',
                'content' => $seo->og_image
            ]);
            \Yii::$app->view->registerMetaTag([
                'name' => 'og:url',
                'content' => $seo->og_url
            ]);
            \Yii::$app->view->registerMetaTag([
                'name' => 'og:site_name',
                'content' => $seo->og_site_name
            ]);
            \Yii::$app->view->registerMetaTag([
                'name' => 'last-modified',
                'content' => $seo->last_updated
            ]);
        }


        return $this->render('index', [
            'section' => $model,
            'articles' => $articles,
            'header' => 'y'
        ]);
    }

}

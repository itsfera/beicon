<?php

namespace app\controllers;

use app\models\Atags;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Tags;
use app\models\Articles;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\Seo;
use app\models\ImageSizes;

use yii\filters\auth\QueryParamAuth;
class TagsController extends Controller
{



    public function actionView($url){
        $tag = Tags::findOne(['url' => $url]);
        if($tag === null){
            throw new NotFoundHttpException;
        }

        $atags = Atags::find()->where(['tag_id' => $tag->id])->all();
        $articleIds = [];
        foreach ($atags as $atag)
            $articleIds[] = $atag["article_id"];

//        $articles = Articles::find()->where(["id" => $articleIds])->orderBy(['date_publish' => SORT_DESC])->limit(14)->all();
        $articles = Articles::find()->where(['id' => $articleIds, 'status' => 'publish'])->orderBy(['date_publish' => SORT_DESC]);

        $pages = new Pagination(['totalCount' => $articles->count(), 'pageSize' => 19]);



        $articles = $articles->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

//        foreach ($articles as $k => $article){
//            if($article["preview_img"]) {
//                $articles[$k]["preview_img"] = ImageSizes::getResizesName($article["preview_img"], 'rectangle');
//            }
//            if($article["header_img"]) {
//                $articles[$k]["header_img"] = ImageSizes::getResizesName($article["header_img"], 'rectangle');
//            }
//        }


        $seo = Seo::find()->where(['tbl' => 'tags', 'id_record' => $tag->id])->one();
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


        $ajax = false;

        if(\Yii::$app->request->isAjax){
            $ajax = true;
            return $this->renderPartial('index', [
                'section' => $tag,
                'articles' => $articles,
                'ajax' => $ajax,
                'limit' => $pages->pageCount
            ]);
        } else {

            return $this->render('index', [
                'section' => $tag,
                'articles' => $articles,
                'ajax' => $ajax,
                'limit' => $pages->pageCount
            ]);
        }
    }



}
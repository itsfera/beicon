<?php

namespace app\controllers;

use app\models\Category;
use app\models\Gallery;
use app\models\GalleryItems;
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
use yii\db\Query;

use app\models\Image as customImage;

use yii\filters\auth\QueryParamAuth;
class ArticlesController extends Controller
{




    CONST API_KEY = 'Pj55UTx5eAb34fqVCzfuR9jxrfk8Fz';
    public $modelClass = 'app\models\Articles';

    public $hide_header;
    public $body_id;






    public function actionSearch(){

        $query = \Yii::$app->request->get('query');


        if (empty($query)) {
            $obj = new Query();
            $ids_gallery = $obj->select('t2.article_id')->from(GalleryItems::tableName() . ' t1')->innerJoin(Gallery::tableName() . ' t2', 't1.gallery_id = t2.id')->where(['like', 't1.content', $query])->column();
            $obj = new Query();
            $ids_articles = $obj->select('id')->from(Articles::tableName())->where(['like', 'name', $query])->andWhere(['status' => 'publish'])->column();
            $ids = array_merge($ids_gallery, $ids_articles);

            $model = Articles::find()->where(['id' => $ids])->orderBy(['date_publish' => SORT_DESC])->all();
        }
        else
        {
            $model = [];
        }
        $this->hide_header = 1;
        $this->body_id = 'searchResultsPage';
        return $this->render('search', [
            'result' => $model,
            'query' => $query,
        ]);
    }

    public $contentClass;

    public function actionView($section, $url)
    {

        $section = Sections::findOne(['url' => $section]);
        if($section === null){
            throw new NotFoundHttpException;
        }

        $model = Articles::find()->where(['url' => $url])->andWhere(['status' => 'publish'])->with('tags')->one();
//        $model = Articles::find()->where(['url' => $url])->andWhere(['status' => 'publish'])->andWhere(['>=', 'date_publish', date('Y-m-d H:i:s')])->with('tags')->one();
        if ($model === null || $model->section != $section->id) {
            throw new NotFoundHttpException;
        }
        $id = $model->id;



        $topic = Articles::find()->where(['topic_day' => 1, 'status' => 'publish'])->limit(10);
        if($topic)
            $topic = $topic->one();
        else $topic = false;

        if($topic["id"] == $id) $topic = false;


        $categoryRes = SectionsCategory::find()->where(['section_id' => $section["id"]])->all();
        $cs = [];

        foreach ($categoryRes as $cr){
            $cs[] = $cr["category_id"];
        }

        $categories = Category::find()->where(['id' => $cs])->all();

        $not_miss = Articles::find()->where(['not_miss' => 1, 'status' => 'publish'])->andWhere(['!=', 'id', $id])->orderBy(['date_publish' => SORT_DESC])->limit(5);
        if($not_miss)
            $not_miss = $not_miss->all();
        else $not_miss = false;

        $recomendedIds = Recomended::find()->where(['article_id' => $id])->all();

        if($recomendedIds){
            $recomended = array();
            foreach ($recomendedIds as $recItem){

                $recItem = Articles::find()->where(['id' => $recItem["recomended_id"]])->andWhere(['!=', 'id', $id])->andWhere(['status' => 'publish'])->one();

                if($recItem){
                    $recomended[] = $recItem;
                }

            }
        } else {
            $recomended = false;
        }



        $model->content = str_replace('[[PRODUCT_BLOCK1]]',  \Yii::$app->view->renderFile('@app/views/articles/productBlock.php'), $model->content);
        $model->content = str_replace('[[PRODUCT_BLOCK2]]',  \Yii::$app->view->renderFile('@app/views/articles/productBlock2.php'), $model->content);
        $model->content = str_replace('[[BANNER_BLOCK]]',  \Yii::$app->view->renderFile('@app/views/articles/banerBlock.php'), $model->content);



        $marketing = Marketing::find()->all();
        foreach ($marketing as $code){
            $model->content = str_replace($code["shortcode"],  $code["content"], $model->content);
        }

        $model->content = str_replace('files/', '/basic/web/files/', $model->content);

        $galleryIDs = [];

        if(preg_match_all("/{{GALLERY=\d+}}/", $model->content, $matches) || preg_match_all("/{{GALLERY=\d+}}/", $model->preview_content, $matches)){
            $matches = $matches[0];
            foreach ($matches as $shortcode){
//                $shortcode = $shortcode[0];
                preg_match('/\d+/', $shortcode, $galeryId);
                $galeryId = $galeryId[0];
                $galery = Gallery::find()->where(['id' => $galeryId])->with('items')->one();






                foreach ($galery->items as $k => $item){

                    $image = new customImage;
                    $filename = explode('/', $item["url"]);

                    if (!file_exists(dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$galery["id"].'/'.$filename[count($filename) - 1])) {


                        $image->moveGalleryItem($galery["id"], $filename[count($filename) - 1]);
                    }
                }



                $galleryIDs[] = $galery["id"];
                switch ($galery->type){
                    case 'default':
                        $model->content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/slider.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->content);
                        $model->preview_content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/slider.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->preview_content);
                        break;
                    case 'one_column':
                        $model->content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/custom.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->content);
                        $model->preview_content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/custom.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->preview_content);
                        break;
                    case 'two_column':
                        $model->content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/two_column.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->content);
                        $model->preview_content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/two_column.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->preview_content);
                        break;
                    case 'three_column':
//                        if($model->section != 5){
//                            $model->content = str_replace($shortcode, \Yii::$app->view->renderFile('@app/views/gallery/two_column.php', array('gallery' => $galery, 'view_type' => $model["view_type"])), $model->content);
//                            $model->preview_content = str_replace($shortcode, \Yii::$app->view->renderFile('@app/views/gallery/two_column.php', array('gallery' => $galery, 'view_type' => $model["view_type"])), $model->preview_content);
//                        } else {
                        $model->content = str_replace($shortcode, \Yii::$app->view->renderFile('@app/views/gallery/three_column.php', array('gallery' => $galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->content);
                        $model->preview_content = str_replace($shortcode, \Yii::$app->view->renderFile('@app/views/gallery/three_column.php', array('gallery' => $galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->preview_content);
//                        }
                        break;
                    default:
                        $model->content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/slider.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->content);
                        $model->preview_content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/slider.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->preview_content);
                        break;
                }


            }
//            die();
        }
        $model->content =  preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $model->content);

        if($model->section == 5){
            $galsRes = Gallery::find()->where(['article_id' => $model["id"]])->all();


            foreach ($galsRes as $i){
                if(!in_array($i, $galleryIDs)){

                    foreach ($i->items as $k => $item){

                        $image = new customImage;
                        $filename = explode('/', $item["url"]);

                        if (!file_exists(dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$i["id"].'/'.$filename[count($filename) - 1])) {


                            $image->moveGalleryItem($i["id"], $filename[count($filename) - 1]);
                        }
                    }


                    $model->content.=\Yii::$app->view->renderFile('@app/views/gallery/three_column.php', array('gallery'=>$i, 'article' => $model, 'view_type' => $model["view_type"]));
                }
            }
        }

        if($model->preview_img){
            $model->preview_img = ImageSizes::getResizesName($model->preview_img, '16_9_1040');
        }
        if($model->header_img){
            $model->header_img = ImageSizes::getResizesName($model->header_img, '16_9_1040');
        }

        if($not_miss) {
            foreach ($not_miss as $k => $value) {

                if ($value->preview_img) {
                    $not_miss[$k]->preview_img = ImageSizes::getResizesName($value->preview_img, 'mini');
                }
                if ($value->header_img) {
                    $not_miss[$k]->header_img = ImageSizes::getResizesName($value->header_img, 'mini');
                }

            }
        }
        if($recomended) {
            foreach ($recomended as $k => $value) {

                if ($value->preview_img) {
                    $recomended[$k]->preview_img = ImageSizes::getResizesName($value->preview_img, '1_1_352_exact');
                }
                if ($value->header_img) {
                    $recomended[$k]->header_img = ImageSizes::getResizesName($value->header_img, '1_1_352_exact');
                }

            }
        }

        $session = \Yii::$app->session;

        if(!$session->has('view-'.$id)){

            $tmp = Articles::findOne($id);
            $tmp->views = (int)$tmp->views+1;
            $tmp->save();
            $session->set('view-'.$id, 'true');
        }
        $seo = Seo::find()->where(['tbl' => 'articles', 'id_record' => $id])->one();
        if($seo) {
            \Yii::$app->view->title = $seo->title;

            $imgGalery = '';

            if (\Yii::$app->request->get('item') && isset($galery->items[\Yii::$app->request->get('item')]['url']))
            {
                $imgGalery = $galery->items[\Yii::$app->request->get('item')]['url'];
            }



            if($seo->description != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'description',
                    'content' => $seo->description
                ]);
            }
            if($seo->keywords != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'keywords',
                    'content' => $seo->keywords
                ]);
            }
            if($seo->og_title != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'og:title',
                    'content' => $seo->og_title
                ]);
            }
            if($seo->og_description != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'og:description',
                    'content' => $seo->og_description
                ]);
            }

            if($seo->og_locale != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'og:locale',
                    'content' => $seo->og_locale
                ]);
            }

            if (!empty($imgGalery))
            {
// 	            die;
            }

            if($seo->og_image != '' || !empty($imgGalery)) {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'og:image',
                    'content' => !empty($imgGalery)?'http://beicon.ru/uploads'.$imgGalery:$seo->og_image
                ]);
            } else {
                if($model->header_img) $img = $model->header_img; else $img = $model->preview_img;
                \Yii::$app->view->registerMetaTag([
                    'name' => 'og:image',
                    'content' => 'http://beicon.ru/uploads/'.$img
                ]);
            }

            \Yii::$app->view->registerMetaTag([
                'name' => 'og:type',
                'content' => 'article'
            ]);

            \Yii::$app->view->registerMetaTag([
                'name' => 'og:site_name',
                'content' => 'Be Icon'
            ]);


            if($seo->og_url != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'og:url',
                    'content' => $seo->og_url
                ]);
            }

//            if($seo->description != '') {
//                \Yii::$app->view->registerMetaTag([
//                    'name' => 'og:site_name',
//                    'content' => $seo->og_site_name
//                ]);
//            }

            if($seo->last_updated != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'last-modified',
                    'content' => $seo->last_updated
                ]);
            }
        }


        $view = 'index';


        if($model["view_type"] == 'gallery-one-column'){
//            $view = 'index2';
            $this->contentClass = 'one-column';
        }


        if(\Yii::$app->request->isAjax) {

            return $this->renderPartial($view, [
                'article' => $model,
                'section' => $section,
                'topic' => $topic,
                'not_miss' => $not_miss,
                'recomended' => $recomended,
                'seo' => $seo ? $seo : false,
                'cats' => $categories,
                'header' => 'y',
                'ajax' => true
            ]);

        } else {
            return $this->render($view, [
                'article' => $model,
                'section' => $section,
                'topic' => $topic,
                'not_miss' => $not_miss,
                'recomended' => $recomended,
                'seo' => $seo ? $seo : false,
                'cats' => $categories,
                'header' => 'y'
            ]);
        }

    }

    public function actionPreview($url)
    {

        $model = Articles::find()->where(['url' => $url])->with('tags')->one();
        if ($model === null) {
            throw new NotFoundHttpException;
        }
        $id = $model->id;


        $topic = Articles::find()->where(['topic_day' => 1])->limit(10);
        if($topic)
            $topic = $topic->one();
        else $topic = false;

        if($topic["id"] == $id) $topic = false;

        $section = Sections::findOne($model["section"]);
        $categoryRes = SectionsCategory::find()->where(['section_id' => $section["id"]])->all();
        $cs = [];

        foreach ($categoryRes as $cr){
            $cs[] = $cr["category_id"];
        }

        $categories = Category::find()->where(['id' => $cs])->all();

        $not_miss = Articles::find()->where(['not_miss' => 1, 'status' => 'publish'])->andWhere(['!=', 'id', $id])->orderBy(['date_publish' => SORT_DESC])->limit(5);
        if($not_miss)
            $not_miss = $not_miss->all();
        else $not_miss = false;

        $recomendedIds = Recomended::find()->where(['article_id' => $id])->all();
        if($recomendedIds){
            $recomended = array();
            foreach ($recomendedIds as $recItem){

                $recItem = Articles::find()->where(['id' => $recItem["recomended_id"]])->andWhere(['!=', 'id', $id])->one();

                if($recItem){
                    $recomended[] = $recItem;
                }

            }
        } else {
            $recomended = false;
        }




        $model->content = str_replace('[[PRODUCT_BLOCK1]]',  \Yii::$app->view->renderFile('@app/views/articles/productBlock.php'), $model->content);
        $model->content = str_replace('[[PRODUCT_BLOCK2]]',  \Yii::$app->view->renderFile('@app/views/articles/productBlock2.php'), $model->content);
        $model->content = str_replace('[[BANNER_BLOCK]]',  \Yii::$app->view->renderFile('@app/views/articles/banerBlock.php'), $model->content);

        $marketing = Marketing::find()->all();
        foreach ($marketing as $code){
            $model->content = str_replace($code["shortcode"],  $code["content"], $model->content);
        }

        $model->content = str_replace('files/', '/basic/web/files/', $model->content);
        if(preg_match_all("/{{GALLERY=\d+}}/", $model->content, $matches) || preg_match_all("/{{GALLERY=\d+}}/", $model->preview_content, $matches)){
            $matches = $matches[0];
            foreach ($matches as $shortcode){
//                $shortcode = $shortcode[0];
                preg_match('/\d+/', $shortcode, $galeryId);
                $galeryId = $galeryId[0];
                $galery = Gallery::find()->where(['id' => $galeryId])->with('items')->one();






                foreach ($galery->items as $k => $item){

                    $image = new customImage;
                    $filename = explode('/', $item["url"]);

                    if (!file_exists(dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$galery["id"].'/'.$filename[count($filename) - 1])) {


                        $image->moveGalleryItem($galery["id"], $filename[count($filename) - 1]);
                    }
                }

                $galleryIDs[] = $galery["id"];

                switch ($galery->type){
                    case 'default':
                        $model->content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/slider.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->content);
                        $model->preview_content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/slider.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->preview_content);
                        break;
                    case 'one_column':
                        $model->content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/custom.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->content);
                        $model->preview_content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/custom.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->preview_content);
                        break;
                    case 'two_column':
                        $model->content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/two_column.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->content);
                        $model->preview_content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/two_column.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->preview_content);
                        break;
                    case 'three_column':
//                        if($model->section != 5){
//                            $model->content = str_replace($shortcode, \Yii::$app->view->renderFile('@app/views/gallery/two_column.php', array('gallery' => $galery, 'view_type' => $model["view_type"])), $model->content);
//                            $model->preview_content = str_replace($shortcode, \Yii::$app->view->renderFile('@app/views/gallery/two_column.php', array('gallery' => $galery, 'view_type' => $model["view_type"])), $model->preview_content);
//                        } else {
                        $model->content = str_replace($shortcode, \Yii::$app->view->renderFile('@app/views/gallery/three_column.php', array('gallery' => $galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->content);
                        $model->preview_content = str_replace($shortcode, \Yii::$app->view->renderFile('@app/views/gallery/three_column.php', array('gallery' => $galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->preview_content);
//                        }
                        break;
                    default:
                        $model->content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/slider.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->content);
                        $model->preview_content = str_replace($shortcode,  \Yii::$app->view->renderFile('@app/views/gallery/slider.php', array('gallery'=>$galery, 'article' => $model, 'view_type' => $model["view_type"])), $model->preview_content);
                        break;
                }


            }
//            die();
        }
        $model->content =  preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $model->content);

        if($model->section == 5){
            $galsRes = Gallery::find()->where(['article_id' => $model["id"]])->all();


            foreach ($galsRes as $i){
                if(!in_array($i, $galleryIDs)){

                    foreach ($i->items as $k => $item){

                        $image = new customImage;
                        $filename = explode('/', $item["url"]);

                        if (!file_exists(dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$i["id"].'/'.$filename[count($filename) - 1])) {


                            $image->moveGalleryItem($i["id"], $filename[count($filename) - 1]);
                        }
                    }


                    $model->content.=\Yii::$app->view->renderFile('@app/views/gallery/three_column.php', array('gallery'=>$i, 'article' => $model, 'view_type' => $model["view_type"]));
                }
            }
        }

        if($model->preview_img){
            $model->preview_img = ImageSizes::getResizesName($model->preview_img, '16_9_1040');
        }
        if($model->header_img){
            $model->header_img = ImageSizes::getResizesName($model->header_img, '16_9_1040');
        }

        if($not_miss) {
            foreach ($not_miss as $k => $value) {

                if ($value->preview_img) {
                    $not_miss[$k]->preview_img = ImageSizes::getResizesName($value->preview_img, 'mini');
                }
                if ($value->header_img) {
                    $not_miss[$k]->header_img = ImageSizes::getResizesName($value->header_img, 'mini');
                }

            }
        }
        if($recomended) {
            foreach ($recomended as $k => $value) {

                if ($value->preview_img) {
                    $recomended[$k]->preview_img = ImageSizes::getResizesName($value->preview_img, '1_1_352_exact');
                }
                if ($value->header_img) {
                    $recomended[$k]->header_img = ImageSizes::getResizesName($value->header_img, '1_1_352_exact');
                }

            }
        }

        $session = \Yii::$app->session;

        if(!$session->has('view-'.$id)){

            $tmp = Articles::findOne($id);
            $tmp->views = (int)$tmp->views+1;
            $tmp->save();
            $session->set('view-'.$id, 'true');
        }
        $seo = Seo::find()->where(['tbl' => 'articles', 'id_record' => $id])->one();
        if($seo) {
            \Yii::$app->view->title = $seo->title;

            if($seo->description != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'description',
                    'content' => $seo->description
                ]);
            }
            if($seo->keywords != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'keywords',
                    'content' => $seo->keywords
                ]);
            }
            if($seo->og_title != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'og:title',
                    'content' => $seo->og_title
                ]);
            }
            if($seo->og_description != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'og:description',
                    'content' => $seo->og_description
                ]);
            }

            if($seo->og_locale != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'og:locale',
                    'content' => $seo->og_locale
                ]);
            }

            if($seo->og_image != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'og:image',
                    'content' => $seo->og_image
                ]);

                \Yii::$app->view->registerMetaTag([
                    'name' => 'og:image:secure_url',
                    'content' => $seo->og_image
                ]);

            }

            if($seo->og_url != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'og:url',
                    'content' => $seo->og_url
                ]);
            }

            if($seo->description != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'og:site_name',
                    'content' => $seo->og_site_name
                ]);
            }

            if($seo->last_updated != '') {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'last-modified',
                    'content' => $seo->last_updated
                ]);
            }
        }


        $view = 'index';


        if($model["view_type"] == 'gallery-one-column'){
//            $view = 'index2';
            $this->contentClass = 'one-column';
        }

        return $this->render('index', [
            'article' => $model,
            'section' => $section,
            'topic' => $topic,
            'not_miss' => $not_miss,
            'recomended' => $recomended,
            'seo' => $seo ? $seo : false,
            'cats' => $categories,
            'header' => 'y',
            'preview' => 'y'
        ]);
    }
}
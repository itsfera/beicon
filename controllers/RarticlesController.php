<?php

namespace app\controllers;

use app\models\Category;
use app\models\Persons;
use app\models\SectionsCategory;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Sections;
use app\models\Recomended;
use app\models\Articles;
use app\models\Tags;
use app\models\Arss;
use app\models\Rss;
use app\models\Apersons;
use app\models\Atags;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

use yii\filters\auth\QueryParamAuth;

class RarticlesController extends ActiveController
{

    public $modelClass = 'app\models\Articles';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data'
    ];
    public $searchRecParams = ['id', 'name', 'value'];

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
                    'cors' => [
                        'Origin' => ['*'],
                        'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'],
                        'Access-Control-Allow-Credentials' => true,
                        'Access-Control-Request-Headers' => ['*'],
                        'Access-Control-Max-Age' => 3600,                 // Cache (seconds)
                        'Access-Control-Expose-Headers' => ['*'],
//                        'Access-Control-Allow-Origin' => ['*', 'http://bi.verworren.net'],

                    ]
                ]
            ]
        );
    }

    /**
     * @inheritdoc
     */

    public function actionRss($id)
    {
        $res = Arss::find()->where(['article_id' => $id]);
        $array = $res->all();
        $result = array();

        foreach ($array as $r) {
            $result[] = $r["rss_id"];
        }
        $items = $result;

        $result = Rss::find()->all();
        $newResult = array();


        foreach ($result as $i) {
            $newResult[] = array(
                'id' => $i["id"],
                'name' => $i["name"],
                'value' => in_array($i["id"], $items) ? 1 : 0
            );
        }

        return $newResult;
    }

    public function actionRecomended($id)
    {
        $query = \Yii::$app->request->get();
        $art = \app\models\Articles::find()->where(['id' => $id])->one();
        $sort = null;
        $res = Recomended::find()->where(['article_id' => $id]);

        $array = $res->all();
        $result = array();

        foreach ($array as $r) {
            $result[] = $r["recomended_id"];
        }
        $items = $result;

        $result = Articles::find()->where(['status' => 'publish'])->andWhere(['section' => $art['section']])->orderBy(['date_publish' => SORT_DESC])->all();
        
        if (isset($query["section_id"])) {
            $result = Articles::find()->where(["section" => $query["section_id"]])->andWhere(['status' => 'publish'])->orderBy(['date_publish' => SORT_DESC])->all();
        }

        $newResult = array();


        foreach ($result as $i) {

            if (isset($query["name"]) && strpos($i["name"], $query["name"]) === false) continue;
            if (isset($query["value"]) && $query["value"] != in_array($i["id"], $items) ? 1 : 0) continue;

            $newResult[] = array(
                'id' => $i["id"],
                'name' => $i["name"],
                'date_publish' => $i["date_publish"],
                'status' => $i["status"],
                'section_id' => $i["section"],
                'value' => in_array($i["id"], $items) ? 1 : 0
            );

        }


        $ps = 20;
        if (isset($query["psize"])) {
            $ps = $query["psize"];
        }

        if (isset($query["sort"])) {
            $sort = $query["sort"];
        }

        return new ArrayDataProvider([
            'allModels' => $newResult,
            'pagination' => [
                'pageSize' => $ps,
            ],
            'sort' => [
                'attributes' => [
                    'id',
                    'value',
                    'name',
                    'section_id'
                ],
            ]
        ]);

    }

    public function actionCategories($id)
    {
        $res = SectionsCategory::find()->where(['category_id' => $id]);
        $array = $res->all();
        $result = array();

        foreach ($array as $r) {
            $result[] = $r["section_id"];
        }
        $items = $result;

        $result = Sections::find()->all();
        $newResult = array();


        foreach ($result as $i) {
            $newResult[] = array(
                'id' => $i["id"],
                'name' => $i["name"],
                'value' => in_array($i["id"], $items) ? 1 : 0
            );
        }

        return $newResult;

    }

    public function actionRssupdate($id)
    {
        $post = \Yii::$app->request->post();

        if ($post["value"] == 0) {

            $r = Arss::find()->where(['article_id' => $id, 'rss_id' => $post["rss_id"]]);

            if ($item = $r->one()) {
                $item->delete();
                return ['status' => 'success', 'message' => 'Удалено'];
            } else return ['status' => 'error', 'message' => 'Рекомендация не найдена'];
        } else {

            $one = Articles::findOne($id);
            if (!$one)
                return ['status' => 'error', 'message' => 'id не действительный'];


            if ($post["rss_id"] != 0) {

                $one = Rss::findOne($post["rss_id"]);
                if (!$one)
                    return ['status' => 'error', 'message' => 'rss_id не действительный'];

                $item = new Arss;
                $item->article_id = $id;
                $item->rss_id = $post["rss_id"];
                $result = $item->save();
            } else {


                $rss = Rss::find()->all();
                foreach ($rss as $item) {
                    $arss = Arss::find()->where(['rss_id' => $item["id"]])->andWhere(['article_id' => $id])->one();
                    if (!$arss) {
                        $newItem = new Arss;
                        $newItem->article_id = $id;
                        $newItem->rss_id = $item["id"];
                        $result = $newItem->save();
                    }
                }

            }


            if ($result)
                return ['status' => 'success'];
            else return ['status' => 'error', 'message' => $result->getErrors()];
        }
    }

    public function actionRecupdate($id)
    {
        $post = \Yii::$app->request->post();

        if ($post["value"] == 0) {

            $r = Recomended::find()->where(['article_id' => $id, 'recomended_id' => $post["article_id"]]);

            if ($item = $r->one()) {
                $item->delete();
                return ['status' => 'success', 'message' => 'Удалено'];
            } else return ['status' => 'error', 'message' => 'Рекомендация не найдена'];
        } else {

            $one = Articles::findOne($post["article_id"]);
            if (!$one)
                return ['status' => 'error', 'message' => 'article_id не действительный'];

            $one = Articles::findOne($id);
            if (!$one)
                return ['status' => 'error', 'message' => 'id не действительный'];


            $item = new Recomended;
            $item->article_id = $id;
            $item->recomended_id = $post["article_id"];

            if ($result = $item->save())
                return ['status' => 'success'];
            else return ['status' => 'error', 'message' => $result->getErrors()];
        }
    }

    public function actionCatupdate($id)
    {
        $post = \Yii::$app->request->post();

        if ($post["value"] == 0) {

            $r = SectionsCategory::find()->where(['section_id' => $post["section_id"], 'category_id' => $id]);

            if ($item = $r->one()) {
                $item->delete();
                return ['status' => 'success', 'message' => 'Удалено'];
            } else return ['status' => 'error', 'message' => 'Не найдено'];
        } else {

            $one = Sections::findOne($post["section_id"]);
            if (!$one)
                return ['status' => 'error', 'message' => 'section_id не действительный'];

            $one = Category::findOne($id);
            if (!$one)
                return ['status' => 'error', 'message' => 'id не действительный'];


            $item = new SectionsCategory;
            $item->section_id = $post["section_id"];
            $item->category_id = $id;

            if ($result = $item->save())
                return ['status' => 'success'];
            else return ['status' => 'error', 'message' => $result->getErrors()];
        }
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions["update"]);
        unset($actions["create"]);
        // disable the "delete" and "create" actions
//        unset($actions['delete'], $actions['create']);

        // customize the data provider preparation with the "prepareDataProvider()" method


        $actions['index']['prepareDataProvider'] = function () {

            $res = \app\models\Articles::find();
            if (isset($_REQUEST['name'])) {
                $_REQUEST['name'] = str_replace(["%25","%"],"",$_REQUEST['name']);
                $res->andWhere(['like', 'name', $_REQUEST['name']]);
            }
            if (isset($_REQUEST['choise']))
                $res->andWhere(['=', 'choise', $_REQUEST['choise']]);
            if (isset($_REQUEST['not_miss']))
                $res->andWhere(['=', 'not_miss', $_REQUEST['not_miss']]);
            if (isset($_REQUEST['topic_day']))
                $res->andWhere(['=', 'topic_day', $_REQUEST['topic_day']]);
            if (isset($_REQUEST['section']))
                $res->andWhere(['=', 'section', $_REQUEST['section']]);
            if (isset($_REQUEST['author']))
                $res->andWhere(['=', 'author', $_REQUEST['author']]);
            if (isset($_REQUEST['main_sort']))
                $res->andWhere(['=', 'main_sort', $_REQUEST['main_sort']]);
            if (isset($_REQUEST['show_on_main']))
                $res->andWhere(['=', 'show_on_main', $_REQUEST['show_on_main']]);
            if (isset($_REQUEST['section_topic']))
                $res->andWhere(['=', 'section_topic', $_REQUEST['section_topic']]);
            if (isset($_REQUEST['date_publish']))
                $res->andWhere(['like', 'date_publish', $_REQUEST['date_publish']]);   
            if (isset($_REQUEST['date_create'])) {
                $res->andWhere(['like', 'date_create', $_REQUEST['date_create']]); 
            }
            if (isset($_REQUEST['status']))
                $res->andWhere(['=', 'status', $_REQUEST['status']]);
            if (isset($_REQUEST['views'])){
                $_REQUEST['views'] = str_replace(["%25","%"],"",$_REQUEST['views']);
                $res->andWhere(['like', 'views', $_REQUEST['views']]); 
            }

            return new ActiveDataProvider([
                'query' => $res,
                'sort' => [
                    'defaultOrder' => [
                        'date_publish' => SORT_DESC
                    ]
                ]
            ]);
        };

//        $actions['update']['prepareDataProvider'] = [$this, 'prepareDataProviderUpdate'];


        return $actions;
    }

    public function prepareDataProvider()
    {
        // prepare and return a data provider for the "index" action
        $model = new Articles();
        $res = $model->search(\Yii::$app->request->queryParams);


        return $res;
    }

    public function actionCreate()
    {
        $post = \Yii::$app->request->post();
        $object = new Articles();
        $object->load($post, '');
        $object->save();

        if (isset($post["tags"])) {
            $tags = $post["tags"];
        }

        if (isset($tags) && is_array($tags)) {

            foreach ($tags as $tag) {

                $r = Tags::find()->where(['name' => $tag])->one();


                $atag = false;
                if ($r) {
                    $atag = Atags::find()->where(['tag_id' => $r->id, 'article_id' => $object->id])->one();


                } else {
                    $r = new Tags;
                    $r->name = $tag;
                    $r->sort = 0;
                    $r->hidden = 0;
                    $r->save();
                }


                if (!$atag) {
                    $atag = new Atags;
                    $atag->article_id = $object->id;
                    $atag->tag_id = $r->id;

                    $atag->save();

                }
            }
            $item = Articles::findOne($object->id);
        }

        $object = Articles::findOne($object->id);
        return $object;
    }

    public function actionUpdate()
    {
        $post = \Yii::$app->request->post();
        unset($post["preview_img"]);
        unset($post["header_img"]);
        $post_id = \Yii::$app->request->queryParams;
        $post_id = (int)$post_id["id"];
        $item = Articles::findOne($post_id);
        $oldTags = $item->tags;
        if (isset($post["tags"])) {
            $tags = $post["tags"];
//            $tags = $item->tags;
        }
        if (isset($post["persons"]))
            $persons = $post["persons"];
        unset($post["tags"]);
        unset($post["persons"]);
        if (isset($post["topic_day"]) && $post["topic_day"] == 1) {
            $topic = Articles::find()->where(['topic_day' => 1])->one();
            if ($topic) {
                $topic->topic_day = 0;
                $topic->save();
            }

        }


//        Удаляяем теги
        if (isset($item->tags) && count($item->tags) > 0 && $item->tags != '' && isset($tags) && is_array($tags)) {
            foreach ($oldTags as $tag) {
                if (!in_array($tag->name, $tags)) {


                    $atag = Atags::find()->where(['tag_id' => $tag->id, 'article_id' => $post_id])->all();
                    foreach ($atag as $a) {
                        $a->delete();
                    }
                }
            }
        }
        $item = Articles::findOne($post_id);

        if ($e = $item->load($post, '')) {
            if ($item->save() && $item->validate()) {


                if (isset($item->persons) && count($item->persons) > 0 && $item->persons != '' && isset($persons) && is_array($persons)) {


                    foreach ($item->persons as $person) {
                        if (!in_array($person, $persons)) {

                            $aperson = Apersons::find()->where(['person_id' => $person->id, 'article_id' => $post_id])->one();

                            $aperson->delete();
                        }
                    }
                }

                if (isset($tags) && is_array($tags)) {

                    foreach ($tags as $tag) {

                        $r = Tags::find()->where(['name' => $tag])->one();


                        $atag = false;
                        if ($r) {
                            $atag = Atags::find()->where(['tag_id' => $r->id, 'article_id' => $post_id])->one();


                        } else {
                            $r = new Tags;
                            $r->name = $tag;
                            $r->sort = 0;
                            $r->hidden = 0;
                            $r->save();
                        }


                        if (!$atag) {
                            $atag = new Atags;
                            $atag->article_id = $post_id;
                            $atag->tag_id = $r->id;

                            $atag->save();
                        }
                    }
                    $item = Articles::findOne($post_id);
                }

                if (isset($persons) && is_array($persons)) {
                    foreach ($persons as $person) {
                        $r = Persons::find()->where(['name' => $person])->one();

                        $aperson = false;
                        if ($r) {
                            $aperson = Apersons::find()->where(['person_id' => $r->id, 'article_id' => $post_id])->one();


                        } else {
                            $r = new Persons();
                            $r->name = $person;
                            $r->sort = 0;
                            $r->hidden = 0;
                            $r->save();
                        }


                        if (!$aperson) {
                            $aperson = new Apersons();
                            $aperson->article_id = $post_id;
                            $aperson->person_id = $r->id;

                            $aperson->save();
                        }
                    }
                    $item = Articles::findOne($post_id);
                }

                return array('status' => 'success', 'data' => $item);
            } else {
                return array('status' => 'error', 'message' => 'Не прошло валидацию', 'errors' => $item->getErrors());
            }
        } else return array('status' => 'error', 'message' => 'Пустой запрос');

    }


}
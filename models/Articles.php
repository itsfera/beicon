<?php

namespace app\models;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use app\models\Atag;
use app\models\Rss;
use app\models\ImageSizes;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class Articles extends ActiveRecord
{
    public static function tableName()
    {
        return 'articles';
    }


    public function getNext() {
        $next = $this->find()->where(['<', 'id', $this->id])->andWhere(['status' => 'publish'])->andWhere(['section' => $this->section])->orderBy('id desc')->one();
        if (isset($next))
            return Url::toRoute(['articles/view', 'url' => $next->url, 'section' => $next->sectionData->url]); // абсолютный роут вне зависимости от текущего контроллера
        else return null;
    }

    static function siteURL()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'].'';
        return $protocol.$domainName;
    }


    public  function  fields ()
    {
        $json = parent::fields ();
        $json ['tags'] = function () {
//            if($this->tags) return $this->tags; else return null;
            if($this->tags){
                $array = array();


                foreach ($this->tags as $tag)
                    $array[] = $tag["name"];

                return $array;

            } else return null;
        };


        $json['url'] = function (){
            return strtolower($this->url);
        };
        $json["publisher"] = function (){
            if($this->publisher){
                return $this->publisher;
            }
        };

        $json ['persons'] = function () {
//            if($this->tags) return $this->tags; else return null;
            if($this->persons){
                $array = array();


                foreach ($this->persons as $tag)
                    $array[] = $tag["name"];

                return $array;

            } else return null;
        };
        $json['rss'] = function (){
            if($this->rss){
                $array = array();


                foreach ($this->rss as $tag)
                    $array[] = $tag["name"];

                return $array;

            } else return null;
        };
        $json["preview_href"] = function (){
          return Articles::siteURL().Url::to(['articles/preview/', 'url' => $this->url]);
        };
        $json["preview_img"] = function () {
            if ($this->preview_img)
                return Articles::siteURL() . '/uploads/' . $this->preview_img;
        };
        $json["header_img"] = function () {
            if ($this->header_img)
                return Articles::siteURL() . '/uploads/' . $this->header_img;
        };

        $json["preview_img"] = function (){
            if(!$this->preview_img) return;

//          $sizes = ImageSizes::find()->all();
          $array = array();
          $array[] = [
            'image' =>    Articles::siteURL() . '/uploads/'.$this->preview_img
          ];
            foreach (ImageSizes::find()->all() as $size){
                $filename = explode('.', $this->preview_img);
                $file=\Yii::getAlias('@app/web/uploads/'.$filename[0].'_'.$size["postfix"].'.'.$filename[1]);
                if(!file_exists($file)){
                    $file=\Yii::getAlias('@app/web/uploads/'.$filename[0].'.'.$filename[1]);
                    if(file_exists($file)) {
                        $image = \Yii::$app->image->load($file);
                        $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::PRECISE)->crop($size["width"], $size["height"]);
                        $image->save(dirname(dirname(__FILE__)) . '/web/uploads/' . $filename[0] . '_' . $size["postfix"] . '.' . $filename[1], $quality = 70);
                    }
                }





                $array[] = [
                    'url' => Articles::siteURL().'/uploads/'.$filename[0].'_'.$size["postfix"].'.'.$filename[1],
                    'width' => $size["width"],
                    'height' => $size["height"],
                    'postfix' => $size["postfix"]
                ];
            }
//          foreach ($sizes as $size){
//              $imgName = explode('.', $this->preview_img);
//              if(file_exists(dirname(dirname(__FILE__)) . '/web/uploads/' . $imgName[0] . '_' . $size["postfix"] . '.' . $imgName[1])) {
//                  $array[] = [
//                      'image' => Articles::siteURL() . '/uploads/' . $imgName[0] . '_' . $size["postfix"] . '.' . $imgName[1],
//                      'width' => $size["width"],
//                      'height' => $size["height"],
//                      'postfix' => $size["postfix"]
//                  ];
//              }
//          }
          return $array;
        };
        $json["header_img"] = function (){
            if(!$this->header_img) return;
          $sizes = ImageSizes::find()->all();
          $array = array();
            $array[] = [
                'image' =>    Articles::siteURL() . '/uploads/'.$this->header_img
            ];
          foreach ($sizes as $size){
              $imgName = explode('.', $this->header_img);
              if(file_exists(dirname(dirname(__FILE__)) . '/web/uploads/' . $imgName[0] . '_' . $size["postfix"] . '.' . $imgName[1])) {
                  $array[] = [
                      'url' => Articles::siteURL() . '/uploads/' . $imgName[0] . '_' . $size["postfix"] . '.' . $imgName[1],
                      'width' => $size["width"],
                      'height' => $size["height"],
                      'postfix' => $size["postfix"]
                  ];
              }
          }
          return $array;
        };

        return $json ;
    }

//    public function behaviors(){
//        return [
//            [
//                'class' => SluggableBehavior::className(),
//                'attribute' => 'name',
//                 'slugAttribute' => 'url',
//            ],
//        ];
//    }


    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'name обязательное поле'],
            ['section', 'required'],
            ['section', 'integer'],
            ['preview_img', 'safe'],
            ['header_img', 'safe'],
            ['content', 'safe'],
            ['preview_content', 'string'],
            [['url'], 'string'],
            [['url'], 'unique'],
            ['status', 'string'],
            ['author', 'integer'],
            ['date_create', 'string'],
            ['date_publish', 'string'],
            ['date_modify', 'string'],
            ['view_type', 'string'],
            [['choise'], 'safe'],
            ['not_miss', 'safe'],
            ['topic_day', 'safe'],
            ['moderate_comment', 'safe'],
            ['main_sort', 'safe'],
            ['show_on_main', 'safe'],
            ['other_source', 'safe'],
            ['other_author', 'safe'],
            ['photographer', 'safe'],
            ['previous_status', 'safe'],
            ['moderator', 'safe'],
            ['old_preview_img_path', 'safe'],
            ['section_topic', 'integer'],
        ];
    }

    public function urlWrite($attr){
        if($attr == 'url' && (!isset($this->url) || $this->url == '')){
            $this->url = \yii\helpers\Inflector::slug($this->name, '-');

        }
        print_r($this);
        die();
    }

    public $searchParams = ['id', 'name', 'url', 'section', 'status', 'choise', 'view_type', 'date_modify', 'date_publish', 'date_create', 'author', 'preview_content', 'views', 'not_miss', 'topic_day', 'not_miss', 'show_on_main', 'main_sort', 'section_topic'];
    public function search($query)
    {
        $res = Articles::find();
//        $res->getTags();
        foreach ($query as $k => $queryItem) {
            if(!in_array($k, $this->searchParams)) continue;
            if($k != 'auth_token' && $k != 'page' && $k != 'sorting' && $k != 'sortingby') {

                if($k == 'date_publish'){
                    $res->andWhere(['>=', 'date_publish', date('Y-m-d', strtotime($queryItem)).'%']);
                    $res->andWhere(['<', 'date_publish', date('Y-m-d 23:59:59', strtotime($queryItem)).'%']);
                    continue;
                }
                if($k == 'date_create'){
                    $res->andWhere(['>=', 'date_create', date('Y-m-d', strtotime($queryItem)).'%']);
                    $res->andWhere(['<', 'date_create', date('Y-m-d 23:59:59', strtotime($queryItem)).'%']);
                    continue;
                }
                if($queryItem[0] == '%'){
                    $res->filterWhere(['like', "$k", substr($queryItem, 1)]);
                } else {
                    $res->andWhere(["$k" => $queryItem]);
                }
            }

        }


        
        $sort = false;

        if(isset($query['sorting'])) {
            $s = $query["sorting"];
            $sby = SORT_ASC;

            if(isset($query["sortingby"])){
                switch ($query["sortingby"]){
                    case 'asc':
                        $sby = SORT_ASC;
                        break;
                    case 'desc':
                        $sby = SORT_DESC;
                        break;
                }
            }

            $sort = array(
                'defaultOrder' => array("$s" => $sby)
            );
        }

//$res = $res->with('tags');
//        print_r($res->all());
//        die();
//        $res = $res->hasOne(Atags::className(), ['article_id' => 'id']);




//        $res->tags;
        $ps = 20;
        if(isset($query["psize"])){
            $ps = $query["psize"];
        }



        return new ActiveDataProvider([
            'query' => $res->with('tags')->with('rss')->with('persons'),
            'pagination' => [
                'pageSize' => $ps,
            ],
            'sort' => $sort ? $sort : [
                'defaultOrder' => ['id' => SORT_ASC]
            ]
        ]);
    }



    public function getTags(){
        return $this->hasMany(Tags::className(), ['id' => 'tag_id'])->viaTable('articles_tags', ['article_id' => 'id']);
    }
    public function getRss(){
        return $this->hasMany(Rss::className(), ['id' => 'rss_id'])->viaTable('articles_rss', ['article_id' => 'id']);
    }
    public function getPersons(){
        return $this->hasMany(Persons::className(), ['id' => 'person_id'])->viaTable('articles_persons', ['article_id' => 'id']);
    }
    public function getPublisher(){
        return $this->hasOne(User::className(), ['id' => 'author']);
    }
    public function getSeo(){
        return $this->hasOne(Seo::className(), ['id_record' => 'id']);
    }

    public function getSectionData(){
        $s = $this->hasOne(Sections::className(), ['id' => 'section']);
        return $s;
    }
}
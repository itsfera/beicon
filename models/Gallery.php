<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\GalleryItems;
use app\models\Image;
use app\models\ImageSizes;

/**
 * This is the model class for table "gallery".
 *
 * @property int $id
 * @property int $name
 * @property int $article_id
 * @property string $type
 */
class Gallery extends \yii\db\ActiveRecord
{

    public  function  fields ()
    {
        $json = parent::fields ();
        $json["article_name"] = function (){
          $article = Articles::findOne($this->article_id);
          return $article->name;
        };
        $json ['items'] = function () {
//            if($this->tags) return $this->tags; else return null;
            if($this->items){
                $array = array();


                foreach ($this->items as $item) {
                    $tmp = [
                      'id' => $item->id,
                      'name' => $item->name,
                      'url' => Articles::siteURL().'/uploads'.$item->url,
                      'content' => $item->content,
                        'sort' => $item->sort,
                      'sizes' => []
                    ];
                    $filename = explode('.', $item->url);
//        $json["url"] = Articles::siteURL().'/uploads'.$this->url;
                    foreach (ImageSizes::find()->all() as $size){
                        $tmp["sizes"][] = [
                            'url' => Articles::siteURL().'/uploads'.$filename[0].'_'.$size["postfix"].'.'.$filename[1],
                            'width' => $size["width"],
                            'height' => $size["height"],
                            'postfix' => $size["postfix"]
                        ];
                    }
                    $array[] = $tmp;
                }

                return $array;

            } else return null;
        };





        return $json ;
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'article_id', 'type'], 'required'],
            [['article_id'], 'integer'],
            [['type'], 'string'],
            ['name', 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'article_id' => 'Article ID',
            'type' => 'Type',
        ];
    }


    public $searchParams = ['id', 'name', 'article_id', 'type'];
    public function search($query)
    {
        $res = $this->find();
//        $res->getTags();
        foreach ($query as $k => $queryItem) {
            if(!in_array($k, $this->searchParams)) continue;
            if($k != 'auth_token' && $k != 'page' && $k != 'sorting' && $k != 'sortingby') {
                if($queryItem[0] == '%'){
                    $res->filterWhere(['like', "$k", substr($queryItem, 1)]);
                } else {
                    $res->where(["$k" => $queryItem]);
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
            'query' => $res->with('items'),
            'pagination' => [
                'pageSize' => $ps,
            ],
            'sort' => $sort ? $sort : [
                'defaultOrder' => ['id' => SORT_ASC]
            ]
        ]);
    }

    public function getItems(){
        return $this->hasMany(GalleryItems::className(), ['gallery_id' => 'id'])->orderBy(['sort'=>SORT_ASC, 'id' => SORT_ASC]);
    }

}

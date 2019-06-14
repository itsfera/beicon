<?php

namespace app\models;

use Yii;
use app\models\Gallery;
use app\models\Articles;
use app\models\Image;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "gallery_items".
 *
 * @property int $id
 * @property string $content
 * @property string $name
 * @property int $sort
 * @property int $gallery_id
 */
class GalleryItems extends \yii\db\ActiveRecord
{


    public  function  fields ()
    {
        $json = parent::fields ();
        $json["url"] = function (){
            return Articles::siteURL()."/uploads".$this->url;
        };
        $json ['sizes'] = function () {
//            if($this->tags) return $this->tags; else return null;


            $filename = explode('.', $this->url);
//        $json["url"] = Articles::siteURL().'/uploads'.$this->url;
            foreach (ImageSizes::find()->all() as $size){

                $file=Yii::getAlias('@app/web/uploads'.$filename[0].'_'.$size["postfix"].'.'.$filename[1]);
                if(!file_exists($file)){
                    $file=Yii::getAlias('@app/web/uploads'.$filename[0].'.'.$filename[1]);
                    $image=Yii::$app->image->load($file);
                    $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::PRECISE)->crop($size["width"], $size["height"]);
                    $image->save(dirname(dirname(__FILE__)) . '/web/uploads'.$filename[0].'_'.$size["postfix"].'.'.$filename[1], $quality = 70);
                }





                $tmp[] = [
                    'url' => Articles::siteURL().'/uploads'.$filename[0].'_'.$size["postfix"].'.'.$filename[1],
                    'width' => $size["width"],
                    'height' => $size["height"],
                    'postfix' => $size["postfix"]
                ];
            }
            $array = $tmp;
            return $array;
        };





        return $json ;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['gallery_id', 'required'],
            [['content', 'name'], 'safe'],
            [['sort', 'gallery_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'name' => 'Name',
            'sort' => 'Sort',
            'gallery_id' => 'Gallery ID',
        ];
    }

    public function getGallery(){
        return $this->hasOne(Gallery::className(), ['id' => 'gallery_id']);
    }

    public $searchParams = ['id', 'name', 'gallery_id', 'sort'];
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
            'query' => $res,
            'pagination' => [
                'pageSize' => $ps,
            ],
            'sort' => $sort ? $sort : [
                'defaultOrder' => ['id' => SORT_ASC]
            ]
        ]);
    }

}

<?php

namespace app\models;

use yii\helpers\Url;
use Yii;
use app\models\Persons;
use app\models\Tags;
use app\models\Sections;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "seo".
 *
 * @property int $id
 * @property int $id_record
 * @property string $tbl
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property double $priority
 * @property string $last_updated
 * @property string $changegreq
 * @property string $canonical_url
 * @property string $og_title
 * @property string $og_image
 * @property string $og_locale
 * @property string $og_site_name
 * @property string $og_url
 * @property string $og_description
 */
class Seo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo';
    }


    public  function  fields ()
    {
        $json = parent::fields ();
        $json["url"] = function (){
            if($this->tbl == 'articles'){
                $article = Articles::findOne($this->id_record);
                return Url::to(['articles/view', 'url' => $article->url, 'section' => $article->sectionData->url]);
            }
            if($this->tbl == 'tags'){
                $article = Tags::findOne($this->id_record);
                return Url::to(['tags/view', 'url' => $article->url]);
            }
            if($this->tbl == 'persons'){
                $article = Persons::findOne($this->id_record);
                return Url::to(['persons/view', 'url' => $article->url]);
            }
            if($this->tbl == 'sections'){
                $article = Sections::findOne($this->id_record);
                return Url::to(['sections/view', 'url' => $article->url]);
            }
        };

        return $json ;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_record', 'tbl', 'title'], 'required'],
            [['id_record'], 'integer'],
            [['keywords', 'description'], 'string'],
            [['priority'], 'number'],
            [['last_updated'], 'safe'],
            [['comment'], 'safe'],
            [['tbl', 'changegreq', 'og_site_name'], 'string', 'max' => 45],
            [['title', 'canonical_url', 'og_title', 'og_image', 'og_url', 'og_description'], 'string', 'max' => 255],
            [['og_locale'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_record' => 'Id Record',
            'tbl' => 'Tbl',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'priority' => 'Priority',
            'last_updated' => 'Last Updated',
            'changegreq' => 'Changegreq',
            'canonical_url' => 'Canonical Url',
            'og_title' => 'Og Title',
            'og_image' => 'Og Image',
            'og_locale' => 'Og Locale',
            'og_site_name' => 'Og Site Name',
            'og_url' => 'Og Url',
            'og_description' => 'Og Description',
        ];
    }


    public $searchParams = ['id', 'id_record', 'tbl'];

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

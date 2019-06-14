<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "notifies".
 *
 * @property int $id
 * @property int $article_id
 * @property int $user_from кому
 * @property int $user_whom от кого
 * @property string $date_create
 */
class Notifies extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'user_from', 'user_whom'], 'required'],
            [['article_id', 'user_from', 'user_whom'], 'integer'],
            [['date_create'], 'safe'],
            [['type'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'user_from' => 'User From',
            'user_whom' => 'User Whom',
            'date_create' => 'Date Create',
        ];
    }



    public  function  fields ()
    {
        $json = parent::fields();
        $json ['article'] = function () {
          return $this->article->name;
        };
        return $json;
    }

    public $searchParams = ['id', 'article', 'user_from', 'user_whom', 'date_create', 'type'];

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
            'query' => $res->with('article'),
            'pagination' => [
                'pageSize' => $ps,
            ],
            'sort' => $sort ? $sort : [
                'defaultOrder' => ['id' => SORT_ASC]
            ]
        ]);
    }


    public function getArticle(){
        return $this->hasOne(Articles::className(), ['id' => 'article_id']);
    }
}

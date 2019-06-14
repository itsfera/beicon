<?php

namespace app\models;

use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use app\models\Seo;

class Sections extends ActiveRecord
{
    public static function tableName()
    {
        return 'sections';
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'name обязательное поле'],
            ['url', 'required', 'message' => 'url обязательное поле'],
            ['url', 'unique'],
            ['sort', 'required'],
            ['hidden', 'required'],
        ];
    }

    public $searchParams = ['id', 'name', 'url', 'sort', 'hidden'];
    public function search($query)
    {
        $res = $this->find();
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
//    public function behaviors(){
//        return [
//            [
//                'class' => SluggableBehavior::className(),
//                'attribute' => 'name',
//                'slugAttribute' => 'url',
//            ],
//        ];
//    }



    public function getSeo(){
        return $this->hasOne(Seo::className(), ['id_record' => 'id']);
    }

}
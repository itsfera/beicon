<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property string $url
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name',  'url'], 'required'],
            [['name', 'content', 'url'], 'string'],
            ['sort', 'safe']
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
            'content' => 'Content',
            'url' => 'Url',
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
//
//    public function behaviors(){
//        return [
//            [
//                'class' => SluggableBehavior::className(),
//                'attribute' => 'name',
//                'slugAttribute' => 'url',
//            ],
//        ];
//    }
}

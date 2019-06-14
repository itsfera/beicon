<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "meta".
 *
 * @property int $id
 * @property string $name
 * @property string $keyname
 * @property string $value
 */
class Meta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'keyname'], 'required'],
            [['name', 'keyname'], 'string'],
            ['value', 'safe']
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
            'keyname' => 'Keyname',
            'value' => 'Value',
        ];
    }

    public $searchParams = ['id', 'value', 'keyname', 'name'];
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

<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "subsribers".
 *
 * @property int $id
 * @property string $email
 * @property int $active
 */
class Subscribers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subsribers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'active'], 'required'],
            [['active'], 'integer'],
            [['email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'active' => 'Active',
        ];
    }


    public $searchParams = ['id', 'email', 'active'];
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

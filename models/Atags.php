<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use app\models\Articles;

class Atags extends ActiveRecord
{
    public static function tableName()
    {
        return 'articles_tags';
    }



    public function rules()
    {
        return [
            ['article_id', 'required'],
            ['tag_id', 'required'],
        ];
    }

//    public $searchParams = ['id', 'name', 'url', 'sort', 'hidden'];

    public function getArticles(){
        return $this->hasOne(Articles::className(), ['id' => 'article_id']);
    }

}
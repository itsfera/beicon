<?php

namespace app\models;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use app\models\Atag;
use yii\data\ActiveDataProvider;

class Recomended extends ActiveRecord
{
    public static function tableName()
    {
        return 'recomended';
    }




    public function rules()
    {
        return [
            ['article_id', 'integer'],
            ['recomended_id', 'integer'],

        ];
    }




}
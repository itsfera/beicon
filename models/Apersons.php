<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articles_persons".
 *
 * @property int $article_id
 * @property int $person_id
 * @property int $id
 */
class Apersons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles_persons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'person_id'], 'required'],
            [['article_id', 'person_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'article_id' => 'Article ID',
            'person_id' => 'Person ID',
            'id' => 'ID',
        ];
    }
}

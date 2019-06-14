<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articles_rss".
 *
 * @property int $id
 * @property int $article_id
 * @property int $rss_id
 */
class Arss extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles_rss';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'rss_id'], 'required'],
            [['article_id', 'rss_id'], 'integer'],
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
            'rss_id' => 'Rss ID',
        ];
    }
}

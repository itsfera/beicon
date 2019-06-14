<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "socials".
 *
 * @property int $id
 * @property string $name
 * @property string $href
 * @property int $sort
 */
class Socials extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'socials';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'href'], 'required'],
            [['name'], 'string'],
            [['sort'], 'safe'],
            [['description'], 'safe'],
            [['href'], 'string', 'max' => 255],
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
            'href' => 'Href',
            'sort' => 'Sort',
        ];
    }
}

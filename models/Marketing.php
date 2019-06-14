<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "marketing".
 *
 * @property int $id
 * @property string $shortcode
 * @property string $content
 */
class Marketing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'marketing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shortcode', 'content'], 'required'],
            [['content'], 'string'],
            [['shortcode'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shortcode' => 'Shortcode',
            'content' => 'Content',
        ];
    }
}

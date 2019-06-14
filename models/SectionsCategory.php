<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sections_category".
 *
 * @property int $id
 * @property int $section_id
 * @property int $category_id
 */
class SectionsCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sections_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['section_id', 'category_id'], 'required'],
            [['section_id', 'category_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section_id' => 'Section ID',
            'category_id' => 'Category ID',
        ];
    }
}

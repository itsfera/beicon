<?php

use yii\db\Migration;

/**
 * Class m190205_082607_changeArticleTable
 */
class m190205_082607_changeArticleTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('articles', 'section_topic', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190205_082607_changeArticleTable cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190205_082607_changeArticleTable cannot be reverted.\n";

        return false;
    }
    */
}

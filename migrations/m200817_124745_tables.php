<?php

use yii\db\Migration;

/**
 * Class m200817_124745_tables
 */
class m200817_124745_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute(file_get_contents('../filesharingdb.sql'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200817_124745_tables cannot be reverted.\n";

        return false;
    }
    */
}

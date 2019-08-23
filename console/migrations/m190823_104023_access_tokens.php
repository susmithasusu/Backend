<?php

use yii\db\Migration;

/**
 * Class m190823_104023_access_tokens
 */
class m190823_104023_access_tokens extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('accesstokens',array(

            'id'=> $this->primarykey(),
          

        ));
             
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m190823_104023_access_tokens cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190823_104023_access_tokens cannot be reverted.\n";

        return false;
    }
    */
}

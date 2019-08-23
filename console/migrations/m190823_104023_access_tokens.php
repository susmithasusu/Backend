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
            'token'=>$this->string()->notnull(),
            'expires_at'=>$this->integer()->notnull(),
            'auth_ccode'=>$this->string()->notnull(),
            'user_id'=>$this->integer()->notnull(),
            'app_id'=>$this->integer()->notnull(),
            'created_at'=>$this->integer()->notnull(),
            'updated_at'=>$this->integer()->notnull()


          

        ));
             
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m190823_104023_access_tokens cannot be reverted.\n";
       
        $this->dropTable('access_token');
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

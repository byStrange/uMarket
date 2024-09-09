<?php

use yii\db\Migration;

/**
 * Class m240907_092214_change_authtoken_max_length_on_main_user_table_to_store_jwt_tokens
 */
class m240907_092214_change_authtoken_max_length_on_main_user_table_to_store_jwt_tokens extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->alterColumn('main_user', 'authkey', 'text');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240907_092214_change_authtoken_max_length_on_main_user_table_to_store_jwt_tokens cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240907_092214_change_authtoken_max_length_on_main_user_table_to_store_jwt_tokens cannot be reverted.\n";

        return false;
    }
    */
}

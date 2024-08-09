<?php

use yii\db\Migration;

/**
 * Class m240809_045114_remove_not_null_constraint_from_main_useraddress
 */
class m240809_045114_remove_not_null_constraint_from_main_useraddress extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->alterColumn('main_useraddress', 'zip_code', $this->string()->null());
    $this->alterColumn('main_useraddress', 'apartment', $this->string()->null());
    $this->alterColumn('main_useraddress', 'street_address', $this->string()->null());
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->alterColumn('main_useraddress', 'zip_code', $this->string()->notNull());
    $this->alterColumn('main_useraddress', 'apartment', $this->string()->notNull());
    $this->alterColumn('main_useraddress', 'street_address', $this->string()->notNull());

    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240809_045114_remove_not_null_constraint_from_main_useraddress cannot be reverted.\n";

        return false;
    }
    */
}

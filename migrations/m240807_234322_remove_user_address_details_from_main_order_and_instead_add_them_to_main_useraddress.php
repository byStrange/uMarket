<?php

use yii\db\Migration;

/**
 * Class m240807_234322_remove_user_address_details_from_main_order_and_instead_add_them_to_main_useraddress
 */
class m240807_234322_remove_user_address_details_from_main_order_and_instead_add_them_to_main_useraddress extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->dropColumn('main_order', 'user_first_name');
    $this->dropColumn('main_order', 'user_last_name');
    $this->dropColumn('main_order', 'user_phone_number');

    $this->addColumn('main_useraddress', 'user_first_name', $this->string(255)->null());
    $this->addColumn('main_useraddress', 'user_last_name', $this->string(255)->null());
    $this->addColumn('main_useraddress', 'user_phone_number', $this->string(255)->null());
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->addColumn('main_order', 'user_first_name', $this->string(255)->null());
    $this->addColumn('main_order', 'user_last_name', $this->string(255)->null());
    $this->addColumn('main_order', 'user_phone_number', $this->string(255)->null());

    $this->dropColumn('main_useraddress', 'user_first_name');
    $this->dropColumn('main_useraddress', 'user_last_name');
    $this->dropColumn('main_useraddress', 'user_phone_number');

    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_234322_remove_user_address_details_from_main_order_and_instead_add_them_to_main_useraddress cannot be reverted.\n";

        return false;
    }
    */
}

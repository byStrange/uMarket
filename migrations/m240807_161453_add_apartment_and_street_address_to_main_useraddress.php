<?php

use yii\db\Migration;

/**
 * Class m240807_161453_add_apartment_and_street_address_to_main_useraddress
 */
class m240807_161453_add_apartment_and_street_address_to_main_useraddress extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {

    $this->addColumn('main_useraddress', 'apartment', $this->string(255)->defaultValue(''));
    $this->addColumn('main_useraddress', 'street_address', $this->string(255)->defaultValue(''));
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropColumn('main_useraddress', 'apartment');
    $this->dropColumn('main_useraddress', 'street_address');

    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_161453_add_apartment_and_street_address_to_main_useraddress cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m240807_235202_remove_delivery_point_from_main_useraddress
 */
class m240807_235202_remove_delivery_point_from_main_useraddress extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->dropColumn('main_useraddress', 'delivery_point_id');
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->addColumn('main_useraddress', 'delivery_point_id', $this->bigInteger()->null());
    $this->addForeignKey('main_useraddress_delivery_point_id_fk_main_delivery_point_id', 'main_useraddress', 'delivery_point_id', 'main_deliverypoint', 'id');
    echo "m240807_235202_remove_delivery_point_from_main_useraddress cannot be reverted.\n";

    return false;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_235202_remove_delivery_point_from_main_useraddress cannot be reverted.\n";

        return false;
    }
    */
}

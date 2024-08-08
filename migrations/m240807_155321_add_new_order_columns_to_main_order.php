<?php

use yii\db\Migration;

/**
 * Class m240807_155321_add_new_order_columns_to_main_order
 */
class m240807_155321_add_new_order_columns_to_main_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('main_order', 'user_first_name', $this->string(255)->null());
      $this->addColumn('main_order', 'user_last_name', $this->string(255)->null());
      $this->addColumn('main_order', 'user_phone_number', $this->string(255)->null());
      $this->addColumn('main_order', 'delivery_type', $this->string(255)->null());
      $this->addColumn('main_order', 'delivery_point_id', $this->bigInteger()->null());

      $this->addForeignKey('main_order_delivery_point_id_fk_main_delivery_point_id', 'main_order', 'delivery_point_id', 'main_deliverypoint', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('main_order', 'user_first_name');
        $this->dropColumn('main_order', 'user_last_name');
        $this->dropColumn('main_order', 'user_phone_number');
        $this->dropColumn('main_order', 'delivery_type');
        $this->dropColumn('main_order', 'delivery_point_id');
        
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_155321_add_new_order_columns_to_main_order cannot be reverted.\n";

        return false;
    }
    */
}

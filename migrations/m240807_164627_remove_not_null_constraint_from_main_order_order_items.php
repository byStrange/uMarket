<?php

use yii\db\Migration;

/**
 * Class m240807_164627_remove_not_null_constraint_from_main_order_order_items
 */
class m240807_164627_remove_not_null_constraint_from_main_order_order_items extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->alterColumn('main_order_order_items', 'cartitem_id', $this->bigInteger()->null());
    $this->alterColumn('main_order_order_items', 'order_id', $this->bigInteger()->null());
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->alterColumn('main_order_order_items', 'cartitem_id', $this->bigInteger()->notNull());
    $this->alterColumn('main_order_order_items', 'order_id', $this->bigInteger()->notNull());
    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_164627_remove_not_null_constraint_from_main_order_order_items cannot be reverted.\n";

        return false;
    }
    */
}

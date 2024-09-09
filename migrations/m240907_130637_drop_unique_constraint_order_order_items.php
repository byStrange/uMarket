<?php

use yii\db\Migration;

/**
 * Class m240907_130637_drop_unique_constraint_order_order_items
 */
class m240907_130637_drop_unique_constraint_order_order_items extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->dropForeignKey('main_order_order_items_order_id_cartitem_id_a8451fc5_uniq', 'main_order_order_items');
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    echo "m240907_130637_drop_unique_constraint_order_order_items cannot be reverted.\n";

    return false;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240907_130637_drop_unique_constraint_order_order_items cannot be reverted.\n";

        return false;
    }
    */
}

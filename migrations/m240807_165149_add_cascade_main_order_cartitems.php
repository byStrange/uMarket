<?php

use yii\db\Migration;

/**
 * Class m240807_165149_add_cascade_main_order_cartitems
 */
class m240807_165149_add_cascade_main_order_cartitems extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {

    $this->dropForeignKey('main_order_order_items_cartitem_id_fk_main_cartitem_id', 'main_order_order_items');
    $this->dropForeignKey('main_order_order_items_order_id_fk_main_order_id', 'main_order_order_items');

    $this->addForeignKey('main_order_order_items_cartitem_id_fk_main_cartitem_id', 'main_order_order_items', 'cartitem_id', 'main_cartitem', 'id', 'CASCADE');
    $this->addForeignKey('main_order_order_items_order_id_fk_main_order_id', 'main_order_order_items', 'order_id', 'main_order', 'id', 'CASCADE');
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {

    $this->dropForeignKey('main_order_order_items_cartitem_id_fk_main_cartitem_id', 'main_order_order_items');
    $this->dropForeignKey('main_order_order_items_order_id_fk_main_order_id', 'main_order_order_items');

    $this->addForeignKey('main_order_order_items_cartitem_id_fk_main_cartitem_id', 'main_order_order_items', 'cartitem_id', 'main_cartitem', 'id', 'RESTRICT');
    $this->addForeignKey('main_order_order_items_order_id_fk_main_order_order_id', 'main_order_order_items', 'order_id', 'main_order', 'id', 'RESTRICT');
    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_165149_add_cascade_main_order_cartitems cannot be reverted.\n";

        return false;
    }
    */
}

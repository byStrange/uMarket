<?php

use yii\db\Migration;

/**
 * Class m240807_223948_remove_cascade_main_cartitem_cart_id
 */
class m240807_223948_remove_cascade_main_cartitem_cart_id extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->dropForeignKey('main_cartitem_cart_id_fk_main_cart_id', 'main_cartitem');
    $this->addForeignKey('main_cartitem_cart_id_fk_main_cart_id', 'main_cartitem', 'cart_id', 'main_cart', 'id', 'SET NULL');
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropForeignKey('main_cartitem_cart_id_fk_main_cart_id', 'main_cartitem');
    $this->addForeignKey('main_cartitem_cart_id_fk_main_cart_id', 'main_cartitem', 'cart_id', 'main_cart', 'id', 'CASCADE');
    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_223948_remove_cascade_main_cartitem_cart_id cannot be reverted.\n";

        return false;
    }
    */
}

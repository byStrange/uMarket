<?php

use yii\db\Migration;

/**
 * Class m240807_193050_remove_not_null_constraint_from_main_cartitem
 */
class m240807_193050_remove_not_null_constraint_from_main_cartitem extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->alterColumn('main_cartitem', 'cart_id', $this->bigInteger()->null());
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->alterColumn('main_cartitem', 'cart_id', $this->bigInteger()->notNull());

    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_193050_remove_not_null_constraint_from_main_cartitem cannot be reverted.\n";

        return false;
    }
    */
}

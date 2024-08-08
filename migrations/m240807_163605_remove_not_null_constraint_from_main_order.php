<?php

use yii\db\Migration;

/**
 * Class m240807_163605_remove_not_null_constraint_from_main_order
 */
class m240807_163605_remove_not_null_constraint_from_main_order extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {


    $this->alterColumn('main_order', 'user_id', $this->bigInteger()->null());
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {

    $this->alterColumn('main_order', 'user_id', $this->bigInteger()->notNull());
    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_163605_remove_not_null_constraint_from_main_order cannot be reverted.\n";

        return false;
    }
    */
}

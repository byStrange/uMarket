<?php

use yii\db\Migration;

/**
 * Class m240804_221154_remove_not_null_constraint_from_main_featuredoffer_discount_price
 */
class m240804_221154_remove_not_null_constraint_from_main_featuredoffer_discount_price extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->alterColumn('main_featuredoffer', 'dicount_price', $this->string()->null());
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->alterColumn('main_featuredoffer', 'dicount_price', $this->string()->notNull());
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240804_221154_remove_not_null_constraint_from_main_featuredoffer_discount_price cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m240807_223040_add_unique_main_cart_user_id
 */
class m240807_223040_add_unique_main_cart_user_id extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createIndex('idx-unique-user_id', 'main_cart', 'user_id', true);
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropIndex('idx-unique-user_id', 'main_cart');
    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_223040_add_unique_main_cart_user_id cannot be reverted.\n";

        return false;
    }
    */
}

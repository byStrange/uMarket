<?php

use yii\db\Migration;

/**
 * Class m240808_091733_add_is_deleted_to_main_product
 */
class m240808_091733_add_is_deleted_to_main_product extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->addColumn('main_product', 'is_deleted', $this->boolean()->defaultValue(false));
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropColumn('main_product', 'is_deleted');

    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240808_091733_add_is_deleted_to_main_product cannot be reverted.\n";

        return false;
    }
    */
}

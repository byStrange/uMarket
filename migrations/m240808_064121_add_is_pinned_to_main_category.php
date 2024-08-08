<?php

use yii\db\Migration;

/**
 * Class m240808_064121_add_is_pinned_to_main_category
 */
class m240808_064121_add_is_pinned_to_main_category extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->addColumn('main_category', 'is_pinned', $this->boolean()->defaultValue(false)->null());
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropColumn('main_category', 'is_pinned');
    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240808_064121_add_is_pinned_to_main_category cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m240910_071914_add_discount_percentage_to_main_featuredoffer
 */
class m240910_071914_add_discount_percentage_to_main_featuredoffer extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->addColumn('main_featuredoffer', 'discount_percentage', $this->integer()->null());
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropColumn('main_featuredoffer', 'discount_percentage');

    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240910_071914_add_discount_percentage_to_main_featuredoffer cannot be reverted.\n";

        return false;
    }
    */
}

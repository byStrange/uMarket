<?php

use yii\db\Migration;

/**
 * Class m240926_060741_add_brand_to_main_product
 */
class m240926_060741_add_brand_to_main_product extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->addColumn('main_product', 'brand', $this->string(255)->defaultValue('')->null());
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropColumn('main_product', 'brand');

    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240926_060741_add_brand_to_main_product cannot be reverted.\n";

        return false;
    }
    */
}

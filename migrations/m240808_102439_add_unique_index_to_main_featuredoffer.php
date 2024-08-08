<?php

use yii\db\Migration;

/**
 * Class m240808_102439_add_unique_index_to_main_featuredoffer
 */
class m240808_102439_add_unique_index_to_main_featuredoffer extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp() {
    $this->createIndex('idx-unique-product_id', 'main_featuredoffer', 'product_id', true);
    $this->createIndex('idx-unique-category_id', 'main_featuredoffer', 'category_id', true);
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {

    $this->dropIndex('idx-unique-category_id', 'main_featuredoffer');
    $this->dropIndex('idx-unique-product_id', 'main_featuredoffer');
    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240808_102439_add_unique_index_to_main_featuredoffer cannot be reverted.\n";

        return false;
    }
    */
}

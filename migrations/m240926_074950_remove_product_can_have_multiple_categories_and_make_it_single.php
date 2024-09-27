<?php

use yii\db\Migration;

/**
 * Class m240926_074950_remove_product_can_have_multiple_categories_and_make_it_single
 */
class m240926_074950_remove_product_can_have_multiple_categories_and_make_it_single extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->addColumn('main_product', 'category_id', $this->integer()->notNull()->defaultValue(1));
    $this->alterColumn('main_product', 'category_id', $this->integer()->notNull());
    $this->addForeignKey('main_product_category_id_fk_main_category_id', 'main_product', 'category_id', 'main_category', 'id', 'CASCADE');
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropColumn('main_product', 'category_id');

    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240926_074950_remove_product_can_have_multiple_categories_and_make_it_single cannot be reverted.\n";

        return false;
    }
    */
}

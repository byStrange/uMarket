<?php

use yii\db\Migration;

/**
 * Class m240812_190233_create_main_specification_table_for_storing_product_specifications
 */
class m240812_190233_create_main_specification_table_for_storing_product_specifications extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable('main_product_specification', [
      'id' => $this->primaryKey(),
      'product_id' => $this->integer(),
      'spec_key' => $this->string(),
      'spec_value' => $this->string(),
      'created_at' => $this->timestamp()->notNull(),
      'updated_at' => $this->timestamp()->notNull(),
    ]);

    $this->addForeignKey('main_product_specification_product_id_fk_main_product_id', 'main_product_specification', 'product_id', 'main_product', 'id', 'CASCADE');
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropTable('main_product_specification');
    $this->dropForeignKey('main_product_specification_product_id_fk_main_product_id', 'main_product_specification');

    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240812_190233_create_main_specification_table_for_storing_product_specifications cannot be reverted.\n";

        return false;
    }
    */
}

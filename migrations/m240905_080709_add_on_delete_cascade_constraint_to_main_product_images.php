<?php

use yii\db\Migration;

/**
 * Class m240905_080709_add_on_delete_cascade_constraint_to_main_product_images
 */
class m240905_080709_add_on_delete_cascade_constraint_to_main_product_images extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {

    $this->dropForeignKey('main_product_images_image_id_fk', 'main_product_images');
    $this->dropForeignKey('main_product_images_product_id_fk', 'main_product_images');

    $this->addForeignKey('main_product_images_image_id_fk', 'main_product_images', 'image_id', 'main_image', 'id', 'CASCADE');
    $this->addForeignKey('main_product_images_product_id_fk', 'main_product_images', 'product_id', 'main_product', 'id', 'CASCADE');
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropForeignKey('main_product_images_image_id_fk', 'main_product_images');
    $this->dropForeignKey('main_product_images_product_id_fk', 'main_product_images');

    $this->addForeignKey('main_product_images_image_id_fk', 'main_product_images', 'image_id', 'main_image', 'id');
    $this->addForeignKey('main_product_images_product_id_fk', 'main_product_images', 'product_id', 'main_product', 'id');
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240905_080709_add_on_delete_cascade_constraint_to_main_product_images cannot be reverted.\n";

        return false;
    }
    */
}

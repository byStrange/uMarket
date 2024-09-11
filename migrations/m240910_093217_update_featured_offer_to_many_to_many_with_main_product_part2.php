<?php

use yii\db\Migration;

/**
 * Class m240910_093217_update_featured_offer_to_many_to_many_with_main_product_part2
 */
class m240910_093217_update_featured_offer_to_many_to_many_with_main_product_part2 extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {

    $this->createTable('main_featuredoffer_main_products', [
      'id' => $this->primaryKey(),
      'product_id' => $this->integer(),
      'featured_offer_id' => $this->integer(),
    ]);


    // unique together (featured_offer_id and product_id)
    $this->createIndex(
      'idx-featured_offer_product-unique',
      'main_featuredoffer_main_products',
      [
        'featured_offer_id',
        'product_id'
      ],
      true
    );

    // product_id -> main_product.id fk
    $this->addForeignKey(
      'main_featuredoffer_main_products_product_id_main_product_fk',
      'main_featuredoffer_main_products',
      'product_id',
      'main_product',
      'id',
      'CASCADE'
    );

    // featured_offer_id -> main_featuredoffer.id fk
    $this->addForeignKey(
      'main_featuredoffer_main_products_featured_offer_id_main_featuredoffer_fk',
      'main_featuredoffer_main_products',
      'featured_offer_id',
      'main_featuredoffer',
      'id',
      'CASCADE'
    );

    // product_id index
    $this->createIndex(
      'main_featuredoffer_main_products_product_id',
      'main_featuredoffer_main_products',
      'product_id'
    );

    // featured_offer_id index
    $this->createIndex(
      'main_featuredoffer_main_products_featured_offer_id',
      'main_featuredoffer_main_products',
      'featured_offer_id'
    );
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    echo "m240910_093217_update_featured_offer_to_many_to_many_with_main_product_part2 cannot be reverted.\n";

    return false;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240910_093217_update_featured_offer_to_many_to_many_with_main_product_part2 cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m240910_092412_update_featured_offer_to_many_to_many_with_main_product
 */
class m240910_092412_update_featured_offer_to_many_to_many_with_main_product extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->dropForeignKey("main_feauturedoffer_product_id_fk_main_product_id", "main_featuredoffer");
    $this->dropIndex('idx-unique-product_id', 'main_featuredoffer');
    $this->dropIndex('main_featuredoffer_product_id_e5b209b0', 'main_featuredoffer');
    $this->dropColumn('main_featuredoffer', 'product_id');
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    echo "m240910_092412_update_featured_offer_to_many_to_many_with_main_product cannot be reverted.\n";

    return false;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240910_092412_update_featured_offer_to_many_to_many_with_main_product cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m240910_094702_add_not_null_constraint_to_main_feauteredoffer_main_products_junction_table
 */
class m240910_094702_add_not_null_constraint_to_main_feauteredoffer_main_products_junction_table extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->alterColumn('main_featuredoffer_main_products', 'product_id', $this->integer()->notNull());
    $this->alterColumn('main_featuredoffer_main_products', 'featured_offer_id', $this->integer()->notNull());
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    echo "m240910_094702_add_not_null_constraint_to_main_feauteredoffer_main_products_junction_table cannot be reverted.\n";

    return false;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240910_094702_add_not_null_constraint_to_main_feauteredoffer_main_products_junction_table cannot be reverted.\n";

        return false;
    }
    */
}

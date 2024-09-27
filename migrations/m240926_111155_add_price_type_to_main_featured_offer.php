<?php

use yii\db\Migration;

/**
 * Class m240926_111155_add_price_type_to_main_featured_offer
 */
class m240926_111155_add_price_type_to_main_featured_offer extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->addColumn('main_featuredoffer', 'price_type', $this->string(255)->notNull()->defaultValue(''));
    $this->alterColumn('main_featuredoffer', 'price_type', $this->string(255)->notNull());
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropColumn('main_featuredoffer', 'price_type');
    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240926_111155_add_price_type_to_main_featured_offer cannot be reverted.\n";

        return false;
    }
    */
}

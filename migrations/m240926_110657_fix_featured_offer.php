<?php

use yii\db\Migration;

/**
 * Class m240926_110657_fix_featured_offer
 */
class m240926_110657_fix_featured_offer extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->dropColumn('main_featuredoffer', 'discount_percentage');
    $this->dropColumn('main_featuredoffer', 'dicount_price');
    $this->addColumn('main_featuredoffer', 'discount', 'numeric not null default 0');
    $this->alterColumn('main_featuredoffer', 'discount', 'numeric not null');
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {

    $this->addColumn('main_featuredoffer', 'discount_percentage', $this->integer());
    $this->addColumn('main_featuredoffer', 'dicount_price', $this->integer());
    $this->dropColumn('main_featuredoffer', 'discount');


    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240926_110657_fix_featured_offer cannot be reverted.\n";

        return false;
    }
    */
}

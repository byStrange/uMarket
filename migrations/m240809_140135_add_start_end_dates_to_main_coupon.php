<?php

use yii\db\Migration;

/**
 * Class m240809_140135_add_start_end_dates_to_main_coupon
 */
class m240809_140135_add_start_end_dates_to_main_coupon extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->addColumn('main_coupon', 'start_date', $this->timestamp()->notNull()->defaultExpression('now()'));
    $this->addColumn('main_coupon', 'end_date', $this->timestamp()->notNull()->defaultExpression('now()'));
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropColumn('main_coupon', 'start_date');
    $this->dropColumn('main_coupon', 'end_date');
    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240809_140135_add_start_end_dates_to_main_coupon cannot be reverted.\n";

        return false;
    }
    */
}

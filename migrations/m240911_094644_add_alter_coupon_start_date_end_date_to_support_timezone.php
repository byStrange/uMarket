<?php

use yii\db\Migration;

/**
 * Class m240911_094644_add_alter_coupon_start_date_end_date_to_support_timezone
 */
class m240911_094644_add_alter_coupon_start_date_end_date_to_support_timezone extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->execute('ALTER table main_coupon ALTER COLUMN start_date TYPE TIMESTAMP WITH TIME ZONE USING start_date AT TIME ZONE \'UTC\'');
    $this->execute('ALTER table main_coupon ALTER COLUMN end_date TYPE TIMESTAMP WITH TIME ZONE USING end_date AT TIME ZONE \'UTC\'');
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->execute('ALTER table main_coupon ALTER COLUMN start_date TYPE TIMESTAMP WITHOUT TIME ZONE USING start_date AT TIME ZONE \'UTC\'');
    $this->execute('ALTER table main_coupon ALTER COLUMN end_date TYPE TIMESTAMP WITHOUT TIME ZONE USING end_date AT TIME ZONE \'UTC\'');
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240911_094644_add_alter_coupon_start_date_end_date_to_support_timezone cannot be reverted.\n";

        return false;
    }
    */
}

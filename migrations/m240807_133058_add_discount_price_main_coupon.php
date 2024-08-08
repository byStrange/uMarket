<?php

use yii\db\Migration;

/**
 * Class m240807_133058_add_discount_price_main_coupon
 */
class m240807_133058_add_discount_price_main_coupon extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('main_coupon', 'discount_price', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('main_coupon', 'discount_price');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_133058_add_discount_price_main_coupon cannot be reverted.\n";

        return false;
    }
    */
}

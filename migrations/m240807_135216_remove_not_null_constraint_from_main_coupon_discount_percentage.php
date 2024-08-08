<?php

use yii\db\Migration;

/**
 * Class m240807_135216_remove_not_null_constraint_from_main_coupon_discount_percentage
 */
class m240807_135216_remove_not_null_constraint_from_main_coupon_discount_percentage extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('main_coupon', 'discount_percentage', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('main_coupon', 'discount_percentage', $this->integer()->notNull());

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_135216_remove_not_null_constraint_from_main_coupon_discount_percentage cannot be reverted.\n";

        return false;
    }
    */
}

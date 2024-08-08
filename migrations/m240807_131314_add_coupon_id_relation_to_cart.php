<?php

use yii\db\Migration;

/**
 * Class m240807_131314_add_coupon_id_relation_to_cart
 */
class m240807_131314_add_coupon_id_relation_to_cart extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('main_cart', 'coupon_id', $this->bigInteger());
        $this->addForeignKey('main_cart_coupon_id_fk_coupon_id', 'main_cart', 'coupon_id', 'main_coupon', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('main_cart', 'coupon_id');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_131314_add_coupon_id_relation_to_cart cannot be reverted.\n";

        return false;
    }
    */
}

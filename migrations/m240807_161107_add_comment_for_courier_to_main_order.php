<?php

use yii\db\Migration;

/**
 * Class m240807_161107_add_comment_for_courier_to_main_order
 */
class m240807_161107_add_comment_for_courier_to_main_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('main_order', 'comment_for_courier', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn('main_order', 'comment_for_courier');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_161107_add_comment_for_courier_to_main_order cannot be reverted.\n";

        return false;
    }
    */
}

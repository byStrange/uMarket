<?php

use yii\db\Migration;

/**
 * Class m240801_104939_add_title_to_main_featured_offer
 */
class m240801_104939_add_title_to_main_featured_offer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("main_featuredoffer", "title", $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240801_104939_add_title_to_main_featured_offer cannot be reverted.\n";
        $this->dropColumn("main_featuredoffer", "title");
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240801_104939_add_title_to_main_featured_offer cannot be reverted.\n";

        return false;
    }
    */
}

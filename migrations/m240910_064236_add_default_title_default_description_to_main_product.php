<?php

use yii\db\Migration;

/**
 * Class m240910_064236_add_default_title_default_description_to_main_product
 */
class m240910_064236_add_default_title_default_description_to_main_product extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {

    $this->addColumn('main_product', 'title', $this->string(255)->notNull()->defaultValue(''));
    $this->addColumn('main_product', 'description', $this->text());
    $this->alterColumn('main_product', 'title', $this->string(255)->notNull());
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropColumn('main_product', 'title');
    $this->dropColumn('main_product', 'description');
    return true;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240910_064236_add_default_title_default_description_to_main_product cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m240913_122129_add_default_image_to_category
 */
class m240913_122129_add_default_image_to_category extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {

    $this->addColumn('main_category', 'image', $this->string(255)->notNull()->defaultValue(''));
    $this->alterColumn('main_category', 'image', $this->string(255)->notNull());
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    echo "m240913_122129_add_default_image_to_category cannot be reverted.\n";
    $this->dropColumn('main_category', 'image');

    return false;
  }

  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240913_122129_add_default_image_to_category cannot be reverted.\n";

        return false;
    }
    */
}

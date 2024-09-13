<?php

use yii\db\Migration;

/**
 * Class m240913_123535_drop_categorytranslation_image_id_add_image_instead
 */
class m240913_123535_drop_categorytranslation_image_id_add_image_instead extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->dropColumn('categorytranslation', 'image_id');
      $this->addColumn('categorytranslation', 'image', $this->string(255)->notNull()->defaultValue(''));
      $this->alterColumn('categorytranslation', 'image', $this->string(255)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240913_123535_drop_categorytranslation_image_id_add_image_instead cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240913_123535_drop_categorytranslation_image_id_add_image_instead cannot be reverted.\n";

        return false;
    }
    */
}

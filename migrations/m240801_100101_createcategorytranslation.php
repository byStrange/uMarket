<?php

use yii\db\Schema;

class m240801_100101_createcategorytranslation extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_categorytranslation",
            [
                "id" => $this->primaryKey(),
                "created_at" => $this->timestamp()->notNull(),
                "updated_at" => $this->timestamp()->notNull(),
                "language_code" => $this->string(10)->notNull(),
                "name" => $this->string(255)->notNull(),
                "category_id" => $this->bigInteger()->notNull(),
                "image_id" => $this->bigInteger()->notNull(),
                "FOREIGN KEY ([[category_id]]) REFERENCES main_category ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
                "FOREIGN KEY ([[image_id]]) REFERENCES main_image ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_categorytranslation");
    }
}

<?php

use yii\db\Schema;

class m240801_100101_createproducttranslation extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_producttranslation",
            [
                "id" => $this->primaryKey(),
                "created_at" => $this->timestamp()->notNull(),
                "updated_at" => $this->timestamp()->notNull(),
                "language_code" => $this->string(10)->notNull(),
                "title" => $this->string(255)->notNull(),
                "product_id" => $this->bigInteger()->notNull(),
                "description" => $this->text()->defaultValue(""),
                "FOREIGN KEY ([[product_id]]) REFERENCES main_product ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_producttranslation");
    }
}

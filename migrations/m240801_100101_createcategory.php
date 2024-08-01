<?php

use yii\db\Schema;

class m240801_100101_createcategory extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_category",
            [
                "id" => $this->primaryKey(),
                "created_at" => $this->timestamp()->notNull(),
                "updated_at" => $this->timestamp()->notNull(),
                "parent_id" => $this->bigInteger(),
                "label" => $this->string(255)->notNull()->defaultValue(""),
                "type" => $this->string(255)->notNull(),
                "FOREIGN KEY ([[parent_id]]) REFERENCES main_category ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_category");
    }
}

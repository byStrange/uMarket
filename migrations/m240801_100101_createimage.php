<?php

use yii\db\Schema;

class m240801_100101_createimage extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_image",
            [
                "id" => $this->primaryKey(),
                "created_at" => $this->timestamp()->notNull(),
                "updated_at" => $this->timestamp()->notNull(),
                "image" => $this->string(100)->notNull(),
                "alt" => $this->string(255)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_image");
    }
}

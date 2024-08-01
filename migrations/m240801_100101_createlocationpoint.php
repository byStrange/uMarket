<?php

use yii\db\Schema;

class m240801_100101_createlocationpoint extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_locationpoint",
            [
                "id" => $this->primaryKey(),
                "created_at" => $this->timestamp()->notNull(),
                "updated_at" => $this->timestamp()->notNull(),
                "lon" => $this->decimal(),
                "lat" => $this->decimal(),
                "address_label" => $this->string(255),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_locationpoint");
    }
}

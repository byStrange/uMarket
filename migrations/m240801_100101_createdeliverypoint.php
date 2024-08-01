<?php

use yii\db\Schema;

class m240801_100101_createdeliverypoint extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_deliverypoint",
            [
                "id" => $this->primaryKey(),
                "created_at" => $this->timestamp()->notNull(),
                "updated_at" => $this->timestamp()->notNull(),
                "label" => $this->string(255),
                "location_id" => $this->bigInteger()->notNull(),
                "FOREIGN KEY ([[location_id]]) REFERENCES main_locationpoint ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_deliverypoint");
    }
}

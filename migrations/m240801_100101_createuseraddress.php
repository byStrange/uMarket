<?php

use yii\db\Schema;

class m240801_100101_createuseraddress extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_useraddress",
            [
                "id" => $this->primaryKey(),
                "created_at" => $this->timestamp()->notNull(),
                "updated_at" => $this->timestamp()->notNull(),
                "label" => $this->string(255),
                "city" => $this->string(255)->notNull(),
                "zip_code" => $this->string(12)->notNull(),
                "delivery_point_id" => $this->bigInteger(),
                "user_id" => $this->bigInteger()->notNull(),
                "FOREIGN KEY ([[delivery_point_id]]) REFERENCES main_deliverypoint ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
                "FOREIGN KEY ([[user_id]]) REFERENCES main_user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_useraddress");
    }
}

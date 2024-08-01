<?php

use yii\db\Schema;

class m240801_100101_createcart extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_cart",
            [
                "id" => $this->primaryKey(),
                "created_at" => $this->timestamp()->notNull(),
                "updated_at" => $this->timestamp()->notNull(),
                "user_id" => $this->bigInteger(),
                "FOREIGN KEY ([[user_id]]) REFERENCES main_user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_cart");
    }
}

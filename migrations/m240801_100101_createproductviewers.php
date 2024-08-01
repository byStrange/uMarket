<?php

use yii\db\Schema;

class m240801_100101_createproductviewers extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_product_viewers",
            [
                "id" => $this->primaryKey(),
                "product_id" => $this->bigInteger()->notNull(),
                "user_id" => $this->bigInteger()->notNull(),
                "FOREIGN KEY ([[product_id]]) REFERENCES main_product ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
                "FOREIGN KEY ([[user_id]]) REFERENCES main_user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_product_viewers");
    }
}

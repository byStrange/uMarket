<?php

use yii\db\Schema;

class m240801_100101_createorderorederitems extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_order_order_items",
            [
                "id" => $this->primaryKey(),
                "order_id" => $this->bigInteger()->notNull(),
                "cartitem_id" => $this->bigInteger()->notNull(),
                "FOREIGN KEY ([[cartitem_id]]) REFERENCES main_cartitem ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
                "FOREIGN KEY ([[order_id]]) REFERENCES main_order ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_order_order_items");
    }
}

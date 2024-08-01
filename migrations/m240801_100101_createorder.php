<?php

use yii\db\Schema;

class m240801_100101_createorder extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_order",
            [
                "id" => $this->primaryKey(),
                "created_at" => $this->timestamp()->notNull(),
                "updated_at" => $this->timestamp()->notNull(),
                "status" => $this->string(20)->notNull(),
                "payment_type" => $this->string(20)->notNull(),
                "coupon_id" => $this->bigInteger(),
                "user_id" => $this->bigInteger()->notNull(),
                "address_id" => $this->bigInteger(),
                "FOREIGN KEY ([[coupon_id]]) REFERENCES main_coupon ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
                "FOREIGN KEY ([[user_id]]) REFERENCES main_user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
                "FOREIGN KEY ([[address_id]]) REFERENCES main_useraddress ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_order");
    }
}

<?php

class m240805_141541_createwishlistitem extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_wishlistitem",
            [
                "id" => $this->primaryKey(),
                "cart_id" => $this->bigInteger()->notNull(),
                "product_id" => $this->bigInteger()->notNull(),
                "FOREIGN KEY ([[cart_id]]) REFERENCES main_cart ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
                "FOREIGN KEY ([[product_id]]) REFERENCES main_product ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_wishlistitem");
    }
}


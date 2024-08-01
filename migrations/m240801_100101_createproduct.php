<?php

use yii\db\Schema;

class m240801_100101_createproduct extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_product",
            [
                "id" => $this->primaryKey(),
                "created_at" => $this->timestamp()->notNull(),
                "updated_at" => $this->timestamp()->notNull(),
                "price" => $this->decimal()->notNull(),
                "discount_price" => $this->decimal(),
                "status" => $this->string(20)->notNull(),
                "views" => $this->integer()->notNull(),
                "created_by_id" => $this->bigInteger()->notNull(),
                "average_rating" => $this->decimal()
                    ->notNull()
                    ->defaultValue("0"),
                "total_ratings" => $this->integer()
                    ->notNull()
                    ->defaultValue("0"),
                "FOREIGN KEY ([[created_by_id]]) REFERENCES main_user ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_product");
    }
}

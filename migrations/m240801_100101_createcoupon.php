<?php

use yii\db\Schema;

class m240801_100101_createcoupon extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_coupon",
            [
                "id" => $this->primaryKey(),
                "created_at" => $this->timestamp()->notNull(),
                "updated_at" => $this->timestamp()->notNull(),
                "code" => $this->string(10)->notNull(),
                "discount_percentage" => $this->integer()->notNull(),
                "is_active" => $this->boolean()->notNull(),
                "label" => $this->string(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_coupon");
    }
}

<?php

use yii\db\Schema;

class m240801_100101_createfeaturedoffer extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_featuredoffer",
            [
                "id" => $this->primaryKey(),
                "created_at" => $this->timestamp()->notNull(),
                "updated_at" => $this->timestamp()->notNull(),
                "dicount_price" => $this->decimal()->notNull(),
                "start_time" => $this->timestamp(),
                "end_time" => $this->timestamp(),
                "product_id" => $this->bigInteger(),
                "category_id" => $this->bigInteger(),
                "type" => $this->string(255)->notNull(),
                "image_banner" => $this->string(100),
                "image_small_landscape" => $this->string(100),
                "image_portrait" => $this->string(100),
                "FOREIGN KEY ([[category_id]]) REFERENCES main_category ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
                "FOREIGN KEY ([[product_id]]) REFERENCES main_product ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_featuredoffer");
    }
}

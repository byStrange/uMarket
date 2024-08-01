<?php

use yii\db\Schema;

class m240801_100101_createuser extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === "mysql") {
            $tableOptions =
                "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB";
        }

        $this->createTable(
            "main_user",
            [
                "id" => $this->primaryKey(),
                "created_at" => $this->timestamp()->notNull(),
                "updated_at" => $this->timestamp()->notNull(),
                "username" => $this->string(255)->notNull(),
                "password" => $this->text()->notNull(),
                "authkey" => $this->string(255)->notNull(),
                "accesstoken" => $this->string(255)->notNull(),
                "phone_number" => $this->string(13),
                "email" => $this->string(255)->notNull(),
                "first_name" => $this->string(255)->notNull(),
                "last_name" => $this->string(255)->notNull(),
                "is_superuser" => $this->boolean()->notNull(),
                "is_active" => $this->boolean()->notNull(),
                "profile_picture" => $this->string(255),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable("main_user");
    }
}

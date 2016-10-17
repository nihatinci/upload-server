<?php

use yii\db\Migration;

class m161016_230124_users extends Migration
{

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createUsersTable();

    }

    public function safeDown()
    {
    }

    public function createUsersTable()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS Users
        (
          id bigint NOT NULL AUTO_INCREMENT,
          username varchar(256) NOT NULL,
          password varchar(256) NOT NULL,
          created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          modified_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          CONSTRAINT users_pkey PRIMARY KEY (id),
          CONSTRAINT users_unique UNIQUE(username)
        )
        ";
        $this->execute($sql);
    }

}

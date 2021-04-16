m<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m210411_093719_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'displayname' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'token' => $this->string()->notNull(),
            'status' => $this->string()->defaultValue(0),
            'resetKey' => $this->string()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}

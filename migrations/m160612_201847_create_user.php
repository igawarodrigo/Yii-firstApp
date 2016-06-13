<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m160612_201847_create_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(250)->notNull(),
            'birth_date' => $this->date(),
            'email' => $this->string(250)->notNull()->unique(),
            'username' => $this->string(250)->notNull(),
            'password' => $this->string(250)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}

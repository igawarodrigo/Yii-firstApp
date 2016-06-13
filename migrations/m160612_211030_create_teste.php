<?php

use yii\db\Migration;

/**
 * Handles the creation for table `teste`.
 */
class m160612_211030_create_teste extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('teste', [
            'id' => $this->primaryKey(),
            'teste' => $this->string(30),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('teste');
    }
}

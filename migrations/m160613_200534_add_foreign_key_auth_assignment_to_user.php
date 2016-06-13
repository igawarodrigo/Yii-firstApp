<?php

use yii\db\Migration;

/**
 * Handles adding foreign_key_auth_assignment to table `user`.
 */
class m160613_200534_add_foreign_key_auth_assignment_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
      $this->addForeignKey(
          'fk-auth_assignment-user_id',
          'auth_assignment',
          'user_id',
          'user',
          'id',
          'CASCADE'
      );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
      $this->dropForeignKey('fk-auth_assignment-user_id','auth_assignment');
    }
}

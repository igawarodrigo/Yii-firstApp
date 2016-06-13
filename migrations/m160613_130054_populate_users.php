<?php

use yii\db\Migration;

class m160613_130054_populate_users extends Migration
{
    public function up()
    {
      $this->insert('user',['full_name'=>'Rodrigo Augusto Igawa',
                            'email'=>'igawa.rodrigo@gmail.com',
                            'username'=>'igawarodrigo',
                            'password'=>Yii::$app->getSecurity()->generatePasswordHash('teste1')]);
      $this->insert('user',['full_name'=>'Gustavo Vendramini',
                            'email'=>'vendramini.gu@gmail.com',
                            'username'=>'gu-vendramini',
                            'password'=>Yii::$app->getSecurity()->generatePasswordHash('teste2')]);
    }

    public function down()
    {
        echo "m160613_130054_populate_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

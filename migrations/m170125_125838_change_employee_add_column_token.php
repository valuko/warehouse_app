<?php

use yii\db\Migration;

class m170125_125838_change_employee_add_column_token extends Migration
{
    public function up()
    {
        $this->addColumn('employee', 'access_token', 'string');
        $this->addColumn('employee', 'auth_token', 'string');
    }

    public function down()
    {
        $this->dropColumn('employee', 'access_token');
        $this->dropColumn('employee', 'auth_token');
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

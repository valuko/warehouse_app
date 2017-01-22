<?php

use yii\db\Migration;

/**
 * Handles the creation of table `employee`.
 */
class m170122_124525_create_employee_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('employee', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(100),
            'last_name' => $this->string(100),
            'username' => $this->string(100),
            'password' => $this->string(100),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('employee');
    }
}

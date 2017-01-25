<?php

use yii\db\Migration;

class m170125_130639_change_tables_add_foreign_keys extends Migration
{
    public function up()
    {
        $this->addForeignKey('FK_employee_products', 'product', 'employee_id', 'employee', 'id', null, 'cascade');
        $this->addForeignKey('FK_product_productcategories', 'product_category', 'product_id', 'product', 'id', null, 'cascade');
        $this->addForeignKey('FK_category_productcategories', 'product_category', 'category_id', 'category', 'id', null, 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('FK_employee_products', 'product');
        $this->dropForeignKey('FK_product_productcategories', 'product_category');
        $this->dropForeignKey('FK_category_productcategories', 'product_category');
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

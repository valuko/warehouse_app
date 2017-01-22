<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product`.
 */
class m170122_124541_create_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'name' => $this->string(150),
            'quantity' => $this->integer(),
            'price' => $this->float(),
            'description' => $this->text(),
            'image_path' => $this->string(250),
            'employee_id' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product');
    }
}

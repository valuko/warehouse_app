<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property integer $quantity
 * @property double $price
 * @property string $description
 * @property string $image_path
 * @property integer $employee_id
 */
class Product extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quantity', 'employee_id'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 150],
            [['image_path'], 'string', 'max' => 250],
            [['name', 'quantity', 'description', 'price'], 'required'],
            ['name', 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'description' => 'Description',
            'image_path' => 'Image Path',
            'employee_id' => 'Employee ID',
        ];
    }

    /**
     * @return $this
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('product_category', ['product_id' => 'id']);
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 23/01/2017
 * Time: 01:43
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ProductForm extends Model
{

    public $name;
    public $description;
    public $quantity;
    public $price;
    public $image_path;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // required fields
            [['name', 'description', 'quantity', 'price'], 'required'],
            // extra type validations
            ['quantity', 'integer'],
            ['price', 'float'],
        ];
    }

    /**
     * Gets the category items to be displayed in the dropdown list menu
     * @return array
     */
    public function getCategoryListItems()
    {
        $categories = $this->getCategories();
        if (empty($categories)) {
            return [];
        }
        return ArrayHelper::map($categories, 'id', 'name');
    }

    /**
     * Gets the available categories while hiding the exception error
     * @return array|null|\yii\db\ActiveRecord[]
     */
    private function getCategories()
    {
        try {
            $categories = Category::find()->all();
            return $categories;
        } catch (\Exception $exception) {
            // Silently handle the exception here
            return null;
        }
    }
}
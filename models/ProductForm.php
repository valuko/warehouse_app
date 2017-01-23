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
use yii\web\UploadedFile;

class ProductForm extends Model
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $description;
    /**
     * @var integer
     */
    public $quantity;
    /**
     * @var double
     */
    public $price;
    /**
     * @var UploadedFile
     */
    public $image_path;
    /**
     * @var array
     */
    public $category_ids;
    /**
     * @var integer
     */
    public $employee_id;
    /**
     * @var boolean
     */
    public $isNewRecord;

    public $categories;


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
            ['price', 'double'],
            ['category_ids', 'each', 'rule' => ['integer']],
            [['image_path'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg,jpeg'],
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

    /**
     * @inheritdoc
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        if (!parent::validate($attributeNames, $clearErrors)) {
            return false;
        }

        // Validate the category IDs
        $this->categories = Category::findAll($this->category_ids);
        if (count($this->categories) != count($this->category_ids)) {
            $this->addError('category_ids', 'Some categories are not valid');
            return false;
        }
        if (!$this->upload()) {
            $this->addError('image_path', 'Image upload failed');
            return false;
        }

        return true;
    }

    /**
     * Handles the image file upload
     * @return bool Indicates successful image upload
     */
    private function upload()
    {
        return $this->image_path->saveAs('uploads/' . $this->image_path->baseName . '.' . $this->image_path->extension);
    }

    public function save()
    {

        // Populate the appropriate model and then save
        $product = new Product();
        // Prefill
        $categoryIds = $this->category_ids;
        $product->load($this->attributes);

        //$user->link('markets', $market);
    }
}
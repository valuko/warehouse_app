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

    private $fileUploaded = false;


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
            [['image_path'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg,jpeg'],
        ];
    }

    /**
     * Gets the category items to be displayed in the dropdown list menu
     * @return array
     */
    public function getCategoryListItems()
    {
        $categories = $this->getAllCategories();
        if (empty($categories)) {
            return [];
        }
        return ArrayHelper::map($categories, 'id', 'name');
    }

    /**
     * Gets the available categories while hiding the exception error
     * @return array|null|\yii\db\ActiveRecord[]
     */
    private function getAllCategories()
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
        if ($this->isNewRecord || !empty($this->image_path->error)) {
            if (empty($this->image_path->error)) {
                $this->addError('image_path', 'Image file must be provided');
                return false;
            }
            if (!$this->upload()) {
                $this->addError('image_path', 'Image upload failed');
                return false;
            }
            $this->fileUploaded = true;
        }

        return true;
    }

    /**
     * Handles the image file upload
     * @return bool Indicates successful image upload
     */
    private function upload()
    {
        return $this->image_path->saveAs(Yii::$app->params['uploadPath'] . $this->image_path->baseName . '.' . $this->image_path->extension);
    }

    /**
     * Saves the product to the DB
     * @param Product|null $product
     * @return bool
     */
    public function save(Product $product=null)
    {
        // Populate the appropriate model and then save
        if (empty($product)) {
            $product = new Product();
        }

        $currentImagePath = $product->image_path;
        $currentCategories = $product->categories;

        $product->load($this->attributes, '');
        // Fill this separately since its an object
        if (!empty($this->image_path)) {
            $product->image_path = $this->image_path->name;
        } else {
            $product->image_path = $currentImagePath;
        }

        if (!$product->save()) {
            // unexpected error
            return false;
        }

        // Compute the diff
        if (!empty($currentCategories)) {
            // compute the diff here
            $diff = $this->findCategoriesDiff($currentCategories);
            if (!empty($diff['removed'])) {
                foreach ($diff['removed'] as $item) {
                    $product->unlink('categories', $item);
                }
            }
            if (!empty($diff['added'])) {
                foreach ($diff['added'] as $item) {
                    $product->link('categories', $item);
                }
            }
        } else {
            foreach ($this->categories as $category) {
                $product->link('categories', $category);
            }
        }

        $this->id = $product->id;

        return true;
    }

    public function fill(Product $product)
    {
        $this->load($product->attributes, '');
        $this->isNewRecord = false;

        $this->category_ids = ArrayHelper::getColumn($product->categories, 'id');
    }

    /**
     * Finds the differences between the current categories passed in and the new categories in the form object
     * @param Category[] $categories
     * @return array
     */
    private function findCategoriesDiff($categories)
    {
        $categoryIds = ArrayHelper::getColumn($categories, 'id');
        $removedIds = array_diff($categoryIds, $this->category_ids);
        $addedIds = array_diff($this->category_ids, $categoryIds);

        // Now put together the list of the diff
        $diff = [];
        if (!empty($removedIds)) {
            $diff['removed'] = [];
            foreach ($categories as $category) {
                if (in_array($category->id, $removedIds)) {
                    $diff['removed'][] = $category;
                }
            }
        }
        if (!empty($addedIds)) {
            $diff['added'] = [];
            foreach ($this->categories as $category) {
                if (in_array($category->id, $addedIds)) {
                    $diff['added'][] = $category;
                }
            }
        }

        return $diff;
    }
}
<?php

namespace app\models;

use Yii;
use yii\base\Security;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "employee".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $password
 */
class Employee extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'username', 'password'], 'string', 'max' => 100],
            [['first_name', 'last_name', 'username', 'password'], 'required'],
            ['username', 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'username' => 'Username',
            'password' => 'Password',
        ];
    }

    public function getProducts() {
        return $this->hasMany(Product::className(), ['employee_id' =>'id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);

        return parent::beforeSave($insert);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return Employee|null
     */
    public static function findByUsername($username)
    {
        $employee = self::find()->where(['username' => $username])->one();
        if (empty($employee)) {
            return null;
        }

        return $employee;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
}

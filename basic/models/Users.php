<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Users".
 *
 * @property integer $id
 * @property string $username
 * @property integer $password
 * @property string $created_date
 * @property string $modified_date
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['password'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['username'], 'string', 'max' => 256],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
        ];
    }
}

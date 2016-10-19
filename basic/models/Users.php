<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $firstName
 * @property string $lastName
 * @property string $title
 * @property string $companyName
 * @property string $phone
 * @property string $alternatePhone
 * @property string $fax
 * @property integer $secretQuestionId
 * @property string $secretAnswer
 * @property integer $locationId
 *
 * @property Locations $location
 * @property SecretQuestions $secretQuestion
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
            [['username', 'password', 'email', 'firstName', 'lastName', 'companyName', 'phone', 'secretQuestionId', 'secretAnswer', 'locationId'], 'required'],
            [['secretQuestionId', 'locationId'], 'integer'],
            [['username', 'password', 'email', 'firstName', 'lastName', 'title', 'companyName', 'phone', 'alternatePhone', 'fax', 'secretAnswer'], 'string', 'max' => 256],
            [['username'], 'unique'],
            [['locationId'], 'exist', 'skipOnError' => true, 'targetClass' => Locations::className(), 'targetAttribute' => ['locationId' => 'id']],
            [['secretQuestionId'], 'exist', 'skipOnError' => true, 'targetClass' => SecretQuestions::className(), 'targetAttribute' => ['secretQuestionId' => 'id']],
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
            'email' => 'Email',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'title' => 'Title',
            'companyName' => 'Company Name',
            'phone' => 'Phone',
            'alternatePhone' => 'Alternate Phone',
            'fax' => 'Fax',
            'secretQuestionId' => 'Secret Question ID',
            'secretAnswer' => 'Secret Answer',
            'locationId' => 'Location ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Locations::className(), ['id' => 'locationId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSecretQuestion()
    {
        return $this->hasOne(SecretQuestions::className(), ['id' => 'secretQuestionId']);
    }
}

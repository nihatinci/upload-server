<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SecretQuestions".
 *
 * @property integer $id
 * @property string $question
 *
 * @property Users[] $users
 */
class SecretQuestions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SecretQuestions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question'], 'required'],
            [['question'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Question',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['secretQuestionId' => 'id']);
    }
}

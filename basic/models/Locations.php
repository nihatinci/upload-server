<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Locations".
 *
 * @property integer $id
 * @property string $locationName
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property integer $stateId
 * @property string $zip
 * @property integer $locationTypeId
 *
 * @property States $state
 * @property LocationTypes $locationType
 * @property Users[] $users
 */
class Locations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Locations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address1', 'city', 'stateId', 'zip', 'locationTypeId'], 'required'],
            [['stateId', 'locationTypeId'], 'integer'],
            [['locationName', 'address1', 'address2', 'city', 'zip'], 'string', 'max' => 256],
            [['stateId'], 'exist', 'skipOnError' => true, 'targetClass' => States::className(), 'targetAttribute' => ['stateId' => 'id']],
            [['locationTypeId'], 'exist', 'skipOnError' => true, 'targetClass' => LocationTypes::className(), 'targetAttribute' => ['locationTypeId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'locationName' => 'Location Name',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'city' => 'City',
            'stateId' => 'State ID',
            'zip' => 'Zip',
            'locationTypeId' => 'Location Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(States::className(), ['id' => 'stateId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocationType()
    {
        return $this->hasOne(LocationTypes::className(), ['id' => 'locationTypeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['locationId' => 'id']);
    }
}

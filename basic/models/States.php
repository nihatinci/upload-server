<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "States".
 *
 * @property integer $id
 * @property string $stateShort
 * @property string $state
 * @property integer $countryId
 *
 * @property Locations[] $locations
 * @property Countries $country
 */
class States extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'States';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stateShort', 'state', 'countryId'], 'required'],
            [['countryId'], 'integer'],
            [['stateShort', 'state'], 'string', 'max' => 256],
            [['countryId'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['countryId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stateShort' => 'State Short',
            'state' => 'State',
            'countryId' => 'Country ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocations()
    {
        return $this->hasMany(Locations::className(), ['stateId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['id' => 'countryId']);
    }
}

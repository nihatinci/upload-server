<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "LocationTypes".
 *
 * @property integer $id
 * @property string $locationType
 *
 * @property Locations[] $locations
 */
class LocationTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'LocationTypes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['locationType'], 'required'],
            [['locationType'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'locationType' => 'Location Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocations()
    {
        return $this->hasMany(Locations::className(), ['locationTypeId' => 'id']);
    }
}

<?php


namespace app\models;


use yii\db\ActiveRecord;

class Region extends ActiveRecord
{
    public static function tableName()
    {   
        return 'region';
    }

    public function getAddresses()
    {
        return $this->hasMany(Address::class, ['region_id' => 'id']);
    }
}
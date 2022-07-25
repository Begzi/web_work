<?php


namespace app\models;


use yii\db\ActiveRecord;

class Address extends ActiveRecord
{
    public static function tableName()
    {   
        return 'address';
    }
    
    public function getCustomer()
    {
        return $this->hasOne(Customers::class, ['id' => 'customer_id']);
    }
    public function getUzs()
    {
        return $this->hasMany(Uz::class, ['address_id' => 'id']);
    }
    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }
}
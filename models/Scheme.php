<?php


namespace app\models;


use yii\db\ActiveRecord;

class Scheme extends ActiveRecord
{
    public static function tableName()
    {
        return 'scheme';
    }
    public function getCustomer()
    {
        return $this->hasOne(Customers::class, ['id' => 'customer_id']);
    }


}
<?php


namespace app\models;


use yii\db\ActiveRecord;

class CustomerGroupName extends ActiveRecord
{
    public static function tableName()
    {
        return 'customer_group_name';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customers::class, ['customer_group_name_id' => 'id']);
    }
}
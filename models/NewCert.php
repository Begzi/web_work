<?php


namespace app\models;


use yii\db\ActiveRecord;

class NewCert extends ActiveRecord
{
    public static function tableName()
    {
        return 'new_cert';
    }
    public function getCustomer()
    {
        return $this->hasOne(Customers::class, ['id' => 'customer_id']);
    }
    public function getCertUz()
    {

        return $this->hasMany(CertUz::class, ['id' => 'uz_id']);
    }

}
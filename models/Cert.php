<?php


namespace app\models;


use yii\db\ActiveRecord;

class Cert extends ActiveRecord
{
    public static function tableName()
    {
        return 'cert';
    }
    public function getCustomer()
    {
        return $this->hasOne(Customers::class, ['id' => 'customer_id']);
    }
    public function getCertuzs()
    {

        return $this->hasMany(CertUz::class, ['cert_id' => 'id']);
    }

    public function getMail()
    {
        return $this->hasOne(Mail::class, ['cert_id' => 'id']);
    }
    
    public function getCertgroupname()
    {
        return $this->hasOne(CertGroupName::class, ['id' => 'cert_group_name_id']);
    }
    public function getCertgroup()
    {
        return $this->hasMany(CertGroup::class, ['cert_id' => 'id']);
    }


}
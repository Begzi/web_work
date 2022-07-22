<?php


namespace app\models;


use yii\db\ActiveRecord;

class Uz extends ActiveRecord
{
    public static function tableName()
    {
        return 'uz_list';
    }
    public function getCustomer()
    {
        return $this->hasOne(Customers::class, ['id' => 'customer_id']);
    }
    public function getLogTickets()
    {
        return $this->hasMany(LogTicket::class, ['uz_id' => 'id']);
    }

    public function getActualcert() //Последний добавленный сертификат
    {
        return $this->hasOne(Cert::class, ['id' => 'support_a']);
    }
    public function getCertuzs()
    {
        return $this->hasMany(CertUz::class, ['uz_id' => 'id']);
    }
    public function getUztype()
    {
        return $this->hasOne(UzType::class, ['id' => 'type_id']);
    }
    public function getUznet()
    {
        return $this->hasOne(UzNet::class, ['id' => 'net_id']);
    }
    public function getMailbase()
    {
        return $this->hasOne(MailBase::class, ['uz_id' => 'id']);
    }
}
<?php


namespace app\models;


use yii\db\ActiveRecord;

class Customers extends ActiveRecord
{
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUzs()
    {
        return $this->hasMany(Uz::class, ['customer_id' => 'id']);
    }
    public function getContacts()
    {
        return $this->hasMany(Contact::class, ['customer_id' => 'id']);
    }
    public function getScheme()
    {
        return $this->hasMany(Scheme::class, ['customer_id' => 'id']);
    }
    public function getCert()
    {
        return $this->hasMany(Cert::class, ['customer_id' => 'id']);
    }
    public function getDoctype()
    {
        return $this->hasOne(Doc::class, ['id' => 'doc_type_id']);
    }
    public function getLogTicket()
    {
        return $this->hasMany(LogTicket::class, ['customer_id' => 'id']);
    }
    public function getAddress()
    {
        return $this->hasMany(Address::class, ['customer_id' => 'id']);
    }
}
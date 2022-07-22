<?php


namespace app\models;


use yii\db\ActiveRecord;

class Contact extends ActiveRecord
{
    public static function tableName()
    {
        return 'contacts';
    }
    
    public function getCustomer()
    {
        return $this->hasOne(Customers::class, ['id' => 'customer_id']);
    }
    public function getContactPosition()
    {
        return $this->hasOne(ContactPosition::class, ['id' => 'department']);
    }
    public function getLogTicket()
    {
        return $this->hasOne(LogTicket::class, ['contact_id' => 'id']);
    }


//embed.src = 'scans/'+customer_id+'/'+uz_id+'/'+sc_link+'.'+scanfile_format+'';
//скан доставался в прошлом сайте
}
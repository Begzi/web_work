<?php


namespace app\models;


use yii\db\ActiveRecord;

class LogTicket extends ActiveRecord
{
    public static function tableName()
    {
        return 'log_ticket_list';
    }
    public function getCustomer()
    {
        return $this->hasOne(Customers::class, ['id' => 'customer_id']);
    }
    public function getUz()
    {
        return $this->hasOne(Uz::class, ['id' => 'uz_id']);
    }
    public function getKbase()
    {
        return $this->hasOne(Kbase::class, ['id' => 'kbase_link']);
    }
    public function getLogTicketType()
    {
        return $this->hasOne(LogTicketType::class, ['id' => 'type']);
    }
    public function getLogTicketPriority()
    {
        return $this->hasOne(LogTicketPriority::class, ['id' => 'priority']);
    }
    public function getLogTicketEvent()
    {
        return $this->hasMany(LogTicketEvent::class, ['ticket_id' => 'id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'res_person']);
    }
    public function getContact()
    {
        return $this->hasOne(Contact::class, ['id' => 'contact_id']);
    }
}
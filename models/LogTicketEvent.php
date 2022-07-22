<?php


namespace app\models;


use yii\db\ActiveRecord;

class LogTicketEvent extends ActiveRecord
{
    public static function tableName()
    {
        return 'log_events';
    }
    public function getLogTicket()
    {
        return $this->hasOne(LogTicket::class, ['id' => 'ticket_id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'res_person']);
    }
}
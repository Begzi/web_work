<?php


namespace app\models;


use yii\db\ActiveRecord;

class LogTicketPriority extends ActiveRecord
{
    public static function tableName()
    {
        return 'log_ticket_priority';
    }
    public function getLogticket()
    {
        return $this->hasOne(LogTicket::class, ['priority' => 'id']);
    }
}

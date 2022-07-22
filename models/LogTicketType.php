<?php


namespace app\models;


use yii\db\ActiveRecord;

class LogTicketType extends ActiveRecord
{
    public static function tableName()
    {
        return 'log_ticket_type';
    }
    public function getLogticket()
    {
        return $this->hasOne(LogTicket::class, ['type' => 'id']);
    }
}

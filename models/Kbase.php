<?php


namespace app\models;


use yii\db\ActiveRecord;

class Kbase extends ActiveRecord
{
    public static function tableName()
    {
        return 'kbase_list';
    }
    public function getLogTickets()
    {
        return $this->hasMany(LogTicket::class, ['kbase_link' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
}
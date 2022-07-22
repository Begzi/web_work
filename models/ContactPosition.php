<?php


namespace app\models;


use yii\db\ActiveRecord;

class ContactPosition extends ActiveRecord
{
    public static function tableName()
    {
        return 'contact_position';
    }
    
    public function getContacts()
    {
        return $this->hasMany(Contact::class, ['department' => 'id']);
    }


//embed.src = 'scans/'+customer_id+'/'+uz_id+'/'+sc_link+'.'+scanfile_format+'';
//скан доставался в прошлом сайте
}
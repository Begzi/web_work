<?php


namespace app\models;


use yii\db\ActiveRecord;

class MailBase extends ActiveRecord
{
    public static function tableName()
    {
        return 'mail_base';
    }
    public function getUz()
    {

        return $this->hasOne(Uz::class, ['id' => 'uz_id']);
    }


}
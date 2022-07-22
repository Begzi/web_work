<?php


namespace app\models;


use yii\db\ActiveRecord;

class Mail extends ActiveRecord
{
    public static function tableName()
    {
        return 'mail';
    }
    public function getCert()
    {

        return $this->hasOne(Cert::class, ['id' => 'cert_id']);
    }


}
<?php


namespace app\models;


use yii\db\ActiveRecord;

class UzNet extends ActiveRecord
{
    public static function tableName()
    {
        return 'net_list';
    }

    public function getUz()
    {
        return $this->hasOne(Uz::class, ['net_id' => 'id']);
    }
}
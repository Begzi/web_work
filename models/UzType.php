<?php


namespace app\models;


use yii\db\ActiveRecord;

class UzType extends ActiveRecord
{
    public static function tableName()
    {
        return 'uz_type';
    }

    public function getUz()
    {
        return $this->hasOne(Uz::class, ['type_id' => 'id']);
    }
}
<?php


namespace app\models;


use yii\db\ActiveRecord;

class UzTypeCategoria extends ActiveRecord
{
    public static function tableName()
    {
        return 'uz_type_categoria';
    }

    public function getUzType()
    {
        return $this->hasOne(UzType::class, ['type' => 'id']);
    }
}
<?php


namespace app\models;


use yii\db\ActiveRecord;

class Doc extends ActiveRecord
{
    public static function tableName()
    {
        return 'doc_type';
    }
}
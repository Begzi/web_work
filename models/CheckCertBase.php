<?php


namespace app\models;


use yii\db\ActiveRecord;

class CheckCertBase extends ActiveRecord
{
    public static function tableName()
    {
        return 'check_cert_base';
    }
}
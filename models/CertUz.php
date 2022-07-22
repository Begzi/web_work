<?php


namespace app\models;


use yii\db\ActiveRecord;

class CertUz extends ActiveRecord
{
    public static function tableName()
    {
        return 'cert_uz';
    }
    public function getNewcert()
    {
        return $this->hasOne(NewCert::class, ['id' => 'cert_id']);
    }

    public function getCert()
    {
        return $this->hasOne(Cert::class, ['id' => 'cert_id']);
    }

    public function getUz()
    {
        return $this->hasOne(Uz::class, ['id' => 'uz_id']);
    }
}
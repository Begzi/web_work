<?php


namespace app\models;


use yii\db\ActiveRecord;

class CertGroupName extends ActiveRecord
{
    public static function tableName()
    {
        return 'cert_group_name';
    }
    public function getCert()
    {
        return $this->hasMany(Cert::class, ['cert_group_name_id' => 'id']);
    }


//embed.src = 'scans/'+customer_id+'/'+uz_id+'/'+sc_link+'.'+scanfile_format+'';
//скан доставался в прошлом сайте
}
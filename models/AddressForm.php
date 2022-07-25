<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddressForm extends Model
{
    public $region;
    public $district;
    public $city;
    public $street;
    public $num;
    public $branch;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['region','branch', 'city'], 'required'],
            [['region', 'district', 'branch', 'city', 'street'], 'string', 'max' => 50],
            ['num', 'string', 'max' => 25],
        ];
    }

}

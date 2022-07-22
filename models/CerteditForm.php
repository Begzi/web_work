<?php


namespace app\models;


use yii\base\Model;

class CerteditForm extends Model
{
    public $num;
    public $st_date;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['num', 'st_date'], 'required' ],
            ['num', 'string', 'max' => 50],
            ['st_date', 'date'],
        ];
    }
}
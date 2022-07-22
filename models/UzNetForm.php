<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class UzNetForm extends Model
{
    public $num;
    public $name;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'num'], 'required'],
            [['name'], 'string', 'max' => 60],
            [['num'], 'integer', 'max' => 2147483647 ],

//            // verifyCode needs to be entered correctly
//            ['verifyCode', 'captcha'],
        ];
    }
}
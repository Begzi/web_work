<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class UzForm extends Model
{
    public $type_id;
    public $customer_id;
    public $net_id;
    public $support_a;
    public $number_for_add;
    public $supply_time;
    public $supply_ex_time;
    public $description;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['type_id', 'customer_id', 'net_id', 'support_a', 'number_for_add',
            'supply_ex_time'], 'required'],
            [['description'], 'string', 'max' => 250],
            [['supply_time'], 'date'],

//            // verifyCode needs to be entered correctly
//            ['verifyCode', 'captcha'],
        ];
    }
}
<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class KbaseForm extends Model
{
    public $name;
    public $description;
    public $solution;
    public $sc_link;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required. 
            [['name'], 'required'],
            [['name'], 'string', 'max' => 500],
            [['solution', 'description'], 'string', 'max' => 3000],
            [['sc_link'], 'file', 'maxFiles' => 0]

//            // verifyCode needs to be entered correctly
//            ['verifyCode', 'captcha'],
        ];
    }
}
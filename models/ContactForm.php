<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.  
 */
class ContactForm extends Model
{
    public $name;
    public $mail;
    public $position;
    public $w_tel;
    public $m_tel;
    public $department;
    public $description;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['department'], 'required'],
            // email has to be a valid email address
            [['w_tel', 'm_tel', 'department'], 'string', 'max' => 40],
            ['position', 'string', 'max' => 100],
            ['mail', 'email'],
            ['name', 'string', 'max' => 60],
            ['description', 'string', 'max' => 200],
        ];
    }

}

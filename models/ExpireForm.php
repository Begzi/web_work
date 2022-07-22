<?php


namespace app\models;


use yii\base\Model;

class ExpireForm extends Model
{
    public $next_step;
    public $mail;
    public $text;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['next_step','mail','text'], 'required' ],
            ['mail', 'email'],
            ['text', 'string', 'max' => 500],
        ];
    }
}
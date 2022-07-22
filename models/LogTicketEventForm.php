<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class LogTicketEventForm extends Model
{
    public $text_description;
    public $next_date_description;
    public $next_date;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required. 
            [['text_description'], 'required'],
            [['next_date_description', 'text_description'], 'string', 'max' => 500],
            [ 'next_date', 'date'],

        ];
    }
}
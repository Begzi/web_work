<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class LogTicketForm extends Model
{
    public $customer_id;
    public $topic;
    public $priority;
    public $type;
    public $solution_time;

    public $kbase_link;
    public $description;
    public $uz_id;
    public $contact_id;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required. 
            [['topic', 'priority', 'type', 'customer_id'], 'required'],
            [ 'topic', 'string', 'max' => 250],
            ['description', 'string', 'max' => 1000],
            ['kbase_link', 'string', 'max' => 250],
            ['solution_time', 'integer', 'max' => 2147483647],
            ['customer_id', 'validateCustomerid'],
            [['contact_id', 'uz_id'], 'string'],

        ];
    }

    public function validateCustomerid()
    {

        Yii::$app->session->setFlash('ForgetCumstomerPicked');
    }

}
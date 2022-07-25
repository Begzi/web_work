<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class CustomersForm extends Model
{
    public $fullname;
    public $shortname;
    public $leg_address;
    public $UHH;
    public $description;
    public $com_id;
    public $doc_type_id;
    public $CPP;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required. 
            [[ 'UHH',  'CPP', 'doc_type_id', 'fullname', 'shortname', 'leg_address'], 'required'],
            [['fullname', 'shortname', 'leg_address'], 'string', 'max' => 250],
            ['description', 'string', 'max' => 500],
            [['UHH'], 'integer', 'max' => 9999999999, 'message' => 'Введите не больше 10 чисел'],
            [['CPP'], 'integer', 'max' => 999999999],

//            // verifyCode needs to be entered correctly
//            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
//    public function attributeLabels()
//    {
//        return [
//            'verifyCode' => 'Verification Code',
//        ];
//    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
//    public function contact($email)
//    {
//        if ($this->validate()) {
//            Yii::$app->mailer->compose()
//                ->setTo($email)
//                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
//                ->setReplyTo([$this->email => $this->name])
//                ->setSubject($this->subject)
//                ->setTextBody($this->body)
//                ->send();
//
//            return true;
//        }
//        return false;
//    }
}


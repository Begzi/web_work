<?php


namespace app\models;


use yii\base\Model;

class SchemeForm extends Model
{
    public $description;
    public $sc_link;
    public $scheme_i;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['sc_link'], 'required' ],
            [['description', 'scheme_i', 'sc_link'], 'string', 'max' => 250]
            // [['sc_link'], 'sc_link', 'extensions' => 'png, jpg',  ХЗ почему эта хрень перестала работать!
            //         'skipOnEmpty' => false]

//            // verifyCode needs to be entered correctly
//            ['verifyCode', 'captcha'], 

            //required => проверяет на пустоту
        ];
    }
    // public function upload()
    // {
    //     if ($this->validate()) {
    //         $this->sc_link->saveAs('uploads/' . $this->sc_link->baseName . '.' . $this->sc_link->extension);
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
}
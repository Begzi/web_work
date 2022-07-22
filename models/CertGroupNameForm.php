<?php


namespace app\models;


use yii\base\Model;

class CertGroupNameForm extends Model
{
    public $name;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            ['name', 'required' ],
            ['name', 'string','max' => 100],
        ];
    }
}
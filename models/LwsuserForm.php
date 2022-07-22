<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class LwsuserForm extends Model
{
    public $username;
    public $password;
    public $name;
    public $role;

    public $edit_password;
    public $new_password;
    public $check_new_password;
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'name', 'role'], 'required'],
            // password is validated by validatePassword()
            ['edit_password', 'validatePassword'],
            [['new_password', 'check_new_password'], 'validateNewPassword'],
            [['username'], 'string', 'max' => 20],
            [['password', 'new_password', 'edit_password'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 40],
        ];
    }

    public function validatePassword()
    {

        if (!$this->hasErrors() && $this->edit_password != NULL) {
            $user = $this->getUser();
            if (Yii::$app->getSecurity()->validatePassword($this->edit_password, $user->getHash())) {
                return true;
            }

            Yii::$app->session->setFlash('Wrongeditpassword');
            return false;
        }
        Yii::$app->session->setFlash('Nopeeditpassword');
        return false;
    }


    public function validateNewPassword()
    {

        if (!$this->hasErrors()) {
            if ($this->new_password == $this->check_new_password) {
                return true;
            }
            Yii::$app->session->setFlash('Wrongchecknewpassword');
            return false;
        }
        return false;
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername((Yii::$app->user->identity->username));
        }

        return $this->_user;
    }

    public function getUserform()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}

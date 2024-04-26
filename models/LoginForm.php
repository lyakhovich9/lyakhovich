<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['login', 'password'], 'required', 'message'=>'Заполните поле.'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
        ];
    }

   
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if ($user) {
            return Yii::$app->user->login($user,$this->rememberMe ? 3600*24*30 : 0);      
        }
    }
        $this->addError($attribute, 'Некорректно введен логин или пароль.');
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::login($this->login, $this->password);
        }

        return $this->_user;
    }
}

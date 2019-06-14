<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            // password is validated by validatePassword()
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || md5($this->password) != $user->password) {
                $this->addError($attribute, 'Incorrect username or password.');
                return false;
            } else return true;
        } else return false;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login($update = true)
    {
        if ($this->validate() && $this->validatePassword('password')) {

            if($update) {
                $this->_user->auth_key = $hash = md5(rand(0, PHP_INT_MAX));
                $this->_user->end_token_time = time() + 360000;
                $this->_user->last_login_date = date('Y-m-d H:i:s');
                $this->_user->save();
            }
            if(Yii::$app->user->login($this->getUser(), 0)) {
                return $this->_user->auth_key;
            }
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
//        print_r($this);

        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}

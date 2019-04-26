<?php

namespace rushstart\user\models\forms;

use rushstart\user\models\Identity;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property Identity|null $identity This property is read-only.
 *
 */
class LoginForm extends Model {

    public $email;
    public $password;
    public $rememberMe = true;
    /**
     * @var Identity
     */
    private $_identity = false;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'password'   => 'Пароль',
            'rememberMe' => 'Запомнить',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validatePassword($attribute) {
        if (!$this->hasErrors()) {
            $identity = $this->identity;

            if (!$identity || !$identity->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный Email или Пароль.');
            }
        }
    }

    /**
     * Finds user by email
     *
     * @return Identity|null
     */
    public function getIdentity() {
        if ($this->_identity === false) {
            $this->_identity = Identity::findByEmail($this->email);
        }
        return $this->_identity;
    }

    /**
     * Logs in a user using the provided email and password.
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->identity, $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

}

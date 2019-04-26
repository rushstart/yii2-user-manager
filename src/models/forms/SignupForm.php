<?php

namespace rushstart\usermanager\models\forms;

use yii\base\Model;
use rushstart\usermanager\models\Identity;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $email;
    public $name;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => Identity::class, 'message' => 'Такой электронный адрес уже используется.'],
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels() {
        return [
            'password' => 'Пароль',
            'name' => 'Имя',
        ];
    }

    /**
     * Signs user up.
     *
     * @return Identity|null the saved model or null if saving fails
     */
    public function signup() {
        if (!$this->validate()) {
            return null;
        }

        $user = new Identity();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }

}

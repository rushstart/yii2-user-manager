<?php

namespace rushstart\usermanager\models\forms;

use rushstart\usermanager\models\Identity;
use Yii;

/**
 * This is the model class for table "user".
 *
 */
class UserForm extends Identity {

    public $newPassword;


    /**
     * {@inheritdoc}
     */
    public function rules(): array {
        return [
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['email'], 'required'],
            [['email', 'name'], 'string', 'max' => 255],
            [['email'], 'unique'],
            ['newPassword', 'string', 'min' => 6],
            ['roles', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array {
        return [
            'id'               => 'ID',
            'email'            => 'Email',
            'name'             => 'Логин',
            'status'           => 'Статус',
            'newPassword'      => 'Новый пароль',
            'roles'            => 'Роли',
            'statusViewFormat' => 'Статус',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert): bool {
        if ($this->newPassword && Yii::$app->user->can('change_user_password')) {
            $this->setPassword($this->newPassword);
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     * @throws \yii\db\Exception
     */
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $roles = $this->roles;
            $this->unlinkAll('roles', true);
            foreach ($roles as $role) {
                $this->link('roles', $role);
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollback();
            \Yii::$app->session->addFlash('error', $e->getMessage());
        }
    }
}

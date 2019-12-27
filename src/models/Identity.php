<?php

namespace rushstart\usermanager\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user" and implements IdentityInterface
 *
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property array $statuses
 * @property string $statusViewFormat
 * @property AuthRole[] $roles
 */
class Identity extends ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'user';
    }

    public static function getStatuses(): array
    {
        return [
            static::STATUS_ACTIVE => 'активный',
            static::STATUS_DELETED => 'отключенный'
        ];
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => static::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @throws NotSupportedException on failure.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return Identity|null
     */
    public static function findByEmail(string $email)
    {
        return static::findOne(['email' => $email, 'status' => static::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return Identity|null
     */
    public static function findByPasswordResetToken(string $token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => static::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid(string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Имя',
            'status' => 'Статус',
            'roles' => 'Роли',
            'statusViewFormat' => 'Статус',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId(): int
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws /yii/base/Exception on failure.
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws /yii/base/Exception on failure.
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws /yii/base/Exception on failure.
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }

    public function getStatusViewFormat(): string
    {
        return ArrayHelper::getValue($this->statuses, $this->status, '');
    }

    public function getRoles(): ActiveQuery
    {
        return $this->hasMany(AuthRole::class, ['name' => 'item_name'])
                        ->viaTable('auth_assignment', ['user_id' => 'id']);
    }

    public function setRoles($values)
    {
        $roles = [];
        foreach ((array) $values as $value) {
            if (($role = AuthRole::findOne($value))) {
                $roles[] = $role;
            }
        }
        $this->populateRelation('roles', $roles);
    }

}

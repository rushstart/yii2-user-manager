<?php

namespace rushstart\user\models;

use rushstart\user\models\queries\AuthPermissionQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property resource $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property Identity[] $users
 * @property AuthRule $ruleName
 * @property AuthPermission[] $children
 * @property AuthPermission[] $parents
 */
class AuthPermission extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'auth_item';
    }

    /**
     * {@inheritdoc}
     */
    public static function find(): AuthPermissionQuery
    {
        return new AuthPermissionQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['rule_name', 'description'], 'default', 'value' => null],
            [['name', 'type'], 'required'],
            [['name'], 'unique'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [
                ['rule_name'],
                'exist',
                'skipOnError' => TRUE,
                'targetClass' => AuthRule::class,
                'targetAttribute' => ['rule_name' => 'name']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'ID',
            'description' => 'Наименование',
            'rule_name' => 'Правила',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate(): bool
    {
        $this->type = \yii\rbac\Item::TYPE_PERMISSION;
        return parent::beforeValidate();
    }

    /**
     * 
     * @return ActiveQuery
     */
    public function getAuthAssignments(): ActiveQuery
    {
        return $this->hasMany(AuthAssignment::class, ['item_name' => 'name']);
    }

    /**
     * 
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(Identity::class, ['id' => 'user_id'])
                        ->viaTable('auth_assignment', ['item_name' => 'name']);
    }

    /**
     * 
     * @return ActiveQuery
     */
    public function getRuleName(): ActiveQuery
    {
        return $this->hasOne(AuthRule::class, ['name' => 'rule_name']);
    }

    /**
     * 
     * @return ActiveQuery
     */
    public function getChildren(): ActiveQuery
    {
        return $this->hasMany(AuthPermission::class, ['name' => 'child'])
                        ->viaTable('auth_item_child', ['parent' => 'name']);
    }

    /**
     * 
     * @return ActiveQuery
     */
    public function getParents(): ActiveQuery
    {
        return $this->hasMany(AuthPermission::class, ['name' => 'parent'])
                        ->viaTable('auth_item_child', ['child' => 'name']);
    }

    /**
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->description ? $this->description : $this->name;
    }

}

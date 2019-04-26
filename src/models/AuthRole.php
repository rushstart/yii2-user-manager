<?php

namespace rushstart\usermanager\models;

use rushstart\usermanager\models\queries\AuthRoleQuery;
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
 * @property Identity[] $users
 * @property AuthPermission[] $permissions
 */
class AuthRole extends ActiveRecord
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
    public static function find(): AuthRoleQuery
    {
        return new AuthRoleQuery(get_called_class());
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
            [['rule_name'], 'default', 'value' => null],
            [['name', 'description'], 'required'],
            [['name'], 'unique'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [
                ['rule_name'],
                'exist',
                'skipOnError' => true,
                'targetClass' => AuthRule::class,
                'targetAttribute' => ['rule_name' => 'name']
            ],
            ['permissions', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate(): bool
    {
        $this->type = \yii\rbac\Item::TYPE_ROLE;
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'ID',
            'description' => 'Наименование',
            'permissions' => 'Права доступа',
        ];
    }

    /**
     * @inheritdoc
     * @throws \yii\db\Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $permissions = $this->permissions;
            $this->unlinkAll('permissions', true);
            foreach ($permissions as $permission) {
                $this->link('permissions', $permission);
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollback();
            \Yii::$app->session->addFlash('error', $e->getMessage());
        }
    }

    /**
     * 
     * @return ActiveQuery
     */
    public function getPermissions(): ActiveQuery
    {
        return $this->hasMany(AuthPermission::class, ['name' => 'child'])
                        ->viaTable('auth_item_child', ['parent' => 'name'])
                        ->orderBy(['description' => SORT_ASC]);
    }

    /**
     * 
     * @param type $values
     */
    public function setPermissions($values)
    {
        $permissions = [];
        foreach ((array) $values as $value) {
            if (($permission = AuthPermission::findOne($value))) {
                $permissions[] = $permission;
            }
        }
        $this->populateRelation('permissions', $permissions);
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
     * @return string
     */
    public function __toString(): string
    {
        return $this->description ? $this->description : $this->name;
    }

}

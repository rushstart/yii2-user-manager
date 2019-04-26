<?php

namespace rushstart\user\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "auth_rule".
 *
 * @property string $name
 * @property resource $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 */
class AuthRule extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName(): string {
        return 'auth_rule';
    }

    public static function getRulesNamespace() {
        return 'rushstart\user\rules';
    }

    public function behaviors(): array {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array {
        return [
            [['name'], 'required'],
            [['data'], 'string'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array {
        return [
            'name' => 'Наименование',
            'data' => 'Data',
        ];
    }

    public function getRuleClass(): string {
        return get_class(unserialize($this->data));
    }

}

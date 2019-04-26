<?php

namespace rushstart\user\models\queries;

/**
 * This is the ActiveQuery class for [[\rushstart\user\models\AuthRole]].
 *
 * @see \rushstart\user\models\AuthRole
 */
class AuthRoleQuery extends \yii\db\ActiveQuery
{

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->andWhere(['type' => \yii\rbac\Item::TYPE_ROLE]);
    }

    /**
     * {@inheritdoc}
     * @return \rushstart\user\models\AuthRole[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \rushstart\user\models\AuthRole|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}

<?php

namespace rushstart\usermanager\models\queries;

/**
 * This is the ActiveQuery class for [[\rushstart\usermanager\models\AuthRole]].
 *
 * @see \rushstart\usermanager\models\AuthRole
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
     * @return \rushstart\usermanager\models\AuthRole[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \rushstart\usermanager\models\AuthRole|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}

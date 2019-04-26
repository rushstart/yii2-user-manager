<?php

namespace rushstart\usermanager\models\queries;

/**
 * This is the ActiveQuery class for [[\rushstart\usermanager\models\AuthPermission]].
 *
 * @see \rushstart\usermanager\models\AuthPermission
 */
class AuthPermissionQuery extends \yii\db\ActiveQuery
{

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->andWhere(['type' => \yii\rbac\Item::TYPE_PERMISSION]);
    }

    /**
     * {@inheritdoc}
     * @return \rushstart\usermanager\models\AuthPermission[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \rushstart\usermanager\models\AuthPermission|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}

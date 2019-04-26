<?php

namespace rushstart\user\rules;


class OrderServiceConclusionRule extends \yii\rbac\Rule {

    public $name = 'OrderServiceConclusionRule';

    public function execute($user, $item, $service) {
        return true;
    }

}

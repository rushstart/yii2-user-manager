<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace rushstart\user\assets;

use yii\web\AssetBundle;

class UserAsset extends AssetBundle {

    public $sourcePath = '@bower/multiselect';
    public $js = [
        'js/jquery.multi-select.js'
    ];
    public $css = [
        'css/multi-select.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}

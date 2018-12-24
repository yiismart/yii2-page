<?php

namespace smart\page\backend\assets;

use yii\web\AssetBundle;

class PageAsset extends AssetBundle
{

    public $js = [
        'page.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/page';
    }

}

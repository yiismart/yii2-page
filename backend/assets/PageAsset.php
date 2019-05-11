<?php

namespace smart\page\backend\assets;

use yii\web\AssetBundle;

class PageAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/page';

    public $js = [
        'page.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}

<?php

namespace unionco\querybuilder\assetbundles\querybuilder;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class QueryBuilderAsset extends AssetBundle
{
    public function init()
    {
        parent::init();
        $this->sourcePath = '@querybuilder/web/assets/dist';
        // if ((bool)getenv('DEV_MODE')) {
        //     $this->js = 'http://vite:3001/js/main.js';
        // } else {
        //     $this->js = 'js/main.js';
        // }
        $this->depends = [
            CpAsset::class,
        ];
    }
}

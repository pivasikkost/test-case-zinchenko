<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Orders module asset bundle.
 *
 * @author Zosimenko Konstantin <pivasikkost@gmail.com>
 * @since 2.0
 */
class OrdersAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/orders/web';

    public $css = [
        'bootstrap.min.css',
        'css/custom.css',
        'css/fonts.css'
    ];
    public $cssOptions = [
        'type' => 'text/css',
    ];

    public $js = [
        'bootstrap.min.js',
        'jquery.min.js',
    ];

    public $depends = [];
}

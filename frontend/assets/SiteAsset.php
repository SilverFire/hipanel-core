<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SiteAsset extends AssetBundle
{
    public $publishOptions = [

    ];
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
//        'adminlte/css/font-awesome/css/font-awesome.min.css',
//        'adminlte/css/morris/morris.css',
//        'adminlte/css/AdminLTE.css',
    ];
    public $js = [
//         'adminlte/js/AdminLTE/app.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
//         'yii\web\YiiAsset',
//         'yii\bootstrap\BootstrapAsset',
//         'yii\bootstrap\BootstrapPluginAsset'
    ];
}

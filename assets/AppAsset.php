<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $sourcePath  = '@webroot';
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        '/basic/web/packages/swiper/css/swiper.css',
        '/basic/web/css/style.css',
        '/basic/web/css/custom.css',
    ];
    public $js = [
        '/packages/mosaic/masonry.pkgd.min.js',
        '/packages/mosaic/imagesloaded.pkgd.min.js',
        '/packages/swiper/js/swiper.js',
        '/js/script.js'
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}

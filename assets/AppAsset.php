<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/font-awesome/css/font-awesome.min.css',
        'plugins/simple-line-icons/simple-line-icons.min.css',
        'plugins/bootstrap/css/bootstrap.min.css',
        'plugins/uniform/css/uniform.default.css',
        'plugins/bootstrap-switch/css/bootstrap-switch.min.css',
        'plugins/fullcalendar/fullcalendar.min.css',
        'plugins/jqvmap/jqvmap/jqvmap.css',
        'plugins/select2/select2.css',
        'css/components.css',
        'css/plugins.css',
        'css/layout.css',
        //'css/themes/default.css',
        'css/custom.css',
        'plugins/simple-line-icons/icomoon-1.css',
        'plugins/simple-line-icons/icomoon-2.css',
        'plugins/simple-line-icons/icomoon-3.css',
        'plugins/simple-line-icons/icomoon-4.css',
        'plugins/simple-line-icons/icomoon-5.css',
        'plugins/simple-line-icons/icomoon-6.css',
        'plugins/simple-line-icons/icomoon-7.css',
        'plugins/simple-line-icons/icomoon-8.css',
        'plugins/simple-line-icons/icomoon-9.css',
        'plugins/simple-line-icons/icomoon-10.css',
        'plugins/simple-line-icons/icomoon-11.css',
        'plugins/font-awesome/css/font-awesome.min.css',
        'plugins/bootstrap/css/bootstrap.min.css',
        /*'plugins/layer/skin/layer.css',*/
        'js/layer/skin/layer.css',
        'css/common.css',
        'plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css'
    ];
    public $js = [
        /*'plugins/layer/layer.min.js',*/
        'js/layer/layer.js',
        'plugins/jquery-migrate.min.js',
        'plugins/jquery-ui/jquery-ui.min.js',
        'plugins/bootstrap/js/bootstrap.min.js',
        'plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
        'plugins/jquery-slimscroll/jquery.slimscroll.min.js',
        'plugins/jquery.blockui.min.js',
        'plugins/jquery.cokie.min.js',
        'plugins/uniform/jquery.uniform.min.js',
        'plugins/bootstrap-switch/js/bootstrap-switch.min.js',
        'plugins/backstretch/jquery.backstretch.min.js',
        'plugins/jquery-validation/js/jquery.validate.min.js',
        'plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'plugins/select2/select2.min.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}

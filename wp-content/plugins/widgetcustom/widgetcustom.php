<?php
/*
 Plugin Name: Custom Files Widget
 Plugin URI: http://localhost/paul.cherry/widgetattachments
 Description: Simple attachment widget that uses native WordPress upload thickbox to add files link widgets to your site.
 Version: 1.1
 Author: Pavel Cherepenko (cherrypipka@gmail.com)
 Author URI: http://paulcherepenko.ru/
 */

$currentDir = dirname(__FILE__);
define("WIDGET_CUSTOM_DIR", $currentDir);
define('WIDGET_CUSTOM_VERSION', '1.0');
$pluginName = plugin_basename(WIDGET_CUSTOM_DIR);
$pluginUrl = trailingslashit(WP_PLUGIN_URL . '/' . $pluginName);
// Путь для CSS, JS скриптов и картинок
$assetsUrlCustom = $pluginUrl . '/assets';

add_action('admin_init', 'widget_custom_admin_init');
add_action('widgets_init', 'widget_custom_widgets_init');

function widget_custom_admin_init() {
    global $assetsUrlCustom;
    load_plugin_textdomain('ex_custom_widget');
    wp_enqueue_script('jquery');
}

function widget_custom_widgets_init() {
    include_once WIDGET_CUSTOM_DIR . '/WidgetExCustom.php';
    register_widget('WidgetExCustom');
}
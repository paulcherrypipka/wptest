<?php
/*
 Plugin Name: Attach Files Widget
 Plugin URI: http://localhost/paul.cherry/widgetattachments
 Description: Simple attachment widget that uses native WordPress upload thickbox to add files link widgets to your site.
 Version: 1.1
 Author: Pavel Cherepenko (cherrypipka@gmail.com)
 Author URI: http://paulcherepenko.ru/
 */

$currentDir = dirname(__FILE__);
define("WIDGET_ATTACHMENTS_DIR", $currentDir);
define('WIDGET_ATTACHMENTS_VERSION', '1.0');
$pluginName = plugin_basename(WIDGET_ATTACHMENTS_DIR);
$pluginUrl = trailingslashit(WP_PLUGIN_URL . '/' . $pluginName);
// Путь для CSS, JS скриптов и картинок
$assetsUrl = $pluginUrl . '/assets';

add_action('admin_init', 'widget_attachments_admin_init');

add_action('widgets_init', 'widget_attachments_widgets_init');

function widget_attachments_admin_init() {
    global $assetsUrl;
    load_plugin_textdomain('ex_attachments_widget');

    // Register scripts and css for admin panel
    wp_register_script('widget_attachments_js', $assetsUrl . '/js/admin-scripts.js', WIDGET_ATTACHMENTS_VERSION, true);
    wp_register_style('widget_attachments_css', $assetsUrl . '/css/admin-scripts.css', WIDGET_ATTACHMENTS_VERSION);

    wp_enqueue_script('jquery');

    // Include scripts for upload files
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');

    // Include other scripts
    wp_enqueue_scripts('widget_attachments_js');
    wp_enqueue_style('thickbox');
    wp_enqueue_style('widget_attachments_css');
}

function widget_attachments_widgets_init() {
    include_once WIDGET_ATTACHMENTS_DIR . '/WidgetExAttachments.php';
    register_widget('WidgetExAttachments');
}
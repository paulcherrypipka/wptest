<?php

/*
 Plugin Name: Attach Files Widget
 Plugin URI: http://wordpress.org/extend/plugins/attach-files-widget/
 Description: Simple attachment widget that uses native Wordpress upload manager to add files link widgets to your site.
 Version: 2.4
 Author: Vyacheslav Volkov (vexell@gmail.com)
 Author URI: http://vexell.ru/
*/

// Stop direct call
if (preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
    die('You are not allowed to call this page directly.');
}

$currentDir = dirname(__FILE__);

define('WIDGET_ATTACHMENTS_DIR', $currentDir);
define('WIDGET_ATTACHMENTS_VERSION', '2.4');

$pluginName = plugin_basename(WIDGET_ATTACHMENTS_DIR);
$pluginUrl  = trailingslashit(WP_PLUGIN_URL . '/' . $pluginName);
$assetsUrl  = $pluginUrl . '/assets';

$filetype_icons = array(
                'pdf' => 'pdf',
                'doc' => 'text',
                'docx' => 'text',
                'odt' => 'text',
                'txt' => 'text',
                'rtf' => 'text',
                'xls' => 'spreadsheet',
                'xlsx' => 'spreadsheet',
                'ods' => 'spreadsheet',
                'ppt' => 'presentation',
                'pptx' => 'presentation',
                'odp' => 'presentation',
                'zip' => 'compressed',
                'rar' => 'compressed',
                '7z' => 'compressed',
                'gz' => 'compressed',
                'jpg' => 'image',
                'png' => 'image',
                'gif' => 'image',
                'svg' => 'image',
                'mp3' => 'music',
                'aac' => 'music',
                'flac' => 'music',
                'mp4' => 'video',
                'avi' => 'video',
                'mov' => 'video',
                'mpg' => 'video',
                'file' => 'download'
            );

function widget_attachment_admin_init()
{
    if ( !function_exists('wp_enqueue_media') ) {

        function version_warning() {
            echo "
            <div class='updated fade'><p>".__('Please, update your WordPress to use Attach Files Widget. Minimum required version 3.5', 'ex_attachments_widget')."</p></div>
            ";
        }
        add_action('admin_notices', 'version_warning');

        return;
    }

    widget_attachment_setup();
}

function widget_attachment_widgets_init()
{
    include_once WIDGET_ATTACHMENTS_DIR  . '/WidgetExAttachments.php';
    register_widget( 'WidgetExAttachments' );
}

function widget_attachment_load_textdomain()
{
    load_plugin_textdomain( 'ex_attachments_widget', false, dirname( plugin_basename( __FILE__ ) ) .'/languages/' );
}

function widget_attachment_setup()
{

    if (did_action( 'wp_enqueue_media' ) === 0) {
        wp_enqueue_media();
    }

    widget_attachment_setup_assets();
}

function widget_attachment_setup_assets()
{
    global $assetsUrl;

    wp_register_script('widget_attachments_js', $assetsUrl . '/js/admin-scripts.js', array( 'jquery', 'media-upload', 'media-views'), WIDGET_ATTACHMENTS_VERSION, true);
    wp_register_style('widget_attachments_css', $assetsUrl . '/css/admin-style.css', array(), WIDGET_ATTACHMENTS_VERSION);

    wp_enqueue_script('widget_attachments_js');
    wp_enqueue_style('widget_attachments_css');

    wp_localize_script( 'widget_attachments_js', 'WidgetExAttachments', array(
        'frame_title' => __( 'Select an Image', 'ex_attachments_widget' ),
        'button_title' => __( 'Insert Into Widget', 'ex_attachments_widget' ),
    ) );
}

function widget_attachment_shortcode($args)
{
    global $assetsUrl, $filetype_icons;

    if (!isset($args['id']) || empty($args['id'])) {
        return '';
    }

    $id = $args['id'];
    $limit = 0;

    if (isset($args['limit']) || !empty($args['limit'])) {
        $limit = (int)$args['limit'];
    }

    $options = get_option('widget_widget_ex_attachments');

    if (!isset($options[$id]) || empty($options[$id])) {
        return '';
    }

    $data = json_decode($options[$id]['data'], true);
    $icons = empty( $options[$id]['icons'] ) ? 'no' : $options[$id]['icons'];

    if (!$data) {
        return '';
    }

    $out = '<div class="ex-attachments ex-attachments-not-widget-out"><ul class="ex-attachments-'.$icons.'icons">';
    $counter = 0;

    foreach($data as $element) {

        if ($limit > 0 && ($counter == $limit) ) {
            break;
        }

        $out .= '<li><a target="_blank" href="' . $element['link'].'">';

        if ($icons != 'no') {
            $path = parse_url( $element['link'], PHP_URL_PATH );
            $ext = strtolower( pathinfo( $path, PATHINFO_EXTENSION ) );
            if (!array_key_exists($ext, $filetype_icons))
                $ext = 'file';  // if no specific filetype icon, use a generic image

            $out .= '<img src="'.$assetsUrl.'/images/'.$filetype_icons[$ext].'.png" />';
        }

        $out .= '<div>'. $element['name'] .'</div></a>';

        if (!empty($element['description'])) {
            $out .= '<p>' . $element['description'] .'</p>';
        }

        $out .= '</li>';
        $counter++;
    }


    $out .= '</ul></div>';

    return $out;
}

add_action('admin_head', 'widget_attachment_setup', 100);
add_action('widgets_init', 'widget_attachment_widgets_init');
add_action('plugins_loaded', 'widget_attachment_load_textdomain');
add_shortcode('widget_attachments', 'widget_attachment_shortcode');
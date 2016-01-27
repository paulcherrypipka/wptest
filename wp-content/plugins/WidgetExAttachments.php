<?php
/**
 * Created by PhpStorm.
 * User: p.cherepenko
 * Date: 1/27/2016
 * Time: 1:25 PM
 */

class WidgetExAttachments extends WP_Widget {

    public function WidgetExAttachments() {
        $widget_ops = array(
            'classname' => 'widget_ex_atachments',
            'description' => __('Attach files in widget'),
        );

        // ID and Name for widget
        $this->WP_Widget('widget_ex_attachments', __('Attach Files'), $widget_ops);
        $this->alt_option_name = 'widget_ex_attachments';

        add_action('save_post', array(&$this, 'flush_widget_cache'));
        add_action('delete_post', array(&$this, 'flush_widget_cache'));
        add_action('switch_theme', array(&$this, 'flush_widget_cache'));
    }

    public function widget($args, $instance) {
        $output = 'test Attachments widget';
        print $output;
    }
}
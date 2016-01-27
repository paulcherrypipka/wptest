<?php
/**
 * Created by PhpStorm.
 * User: p.cherepenko
 * Date: 1/27/2016
 * Time: 1:25 PM
 */

class WidgetExCustom extends WP_Widget {

    public function WidgetExCustom() {
        $widget_ops = array(
            'classname' => 'widget_ex_custom',
            'description' => __('Custom Attach files in widget'),
        );

        // ID and Name for widget
        $this->WP_Widget('widget_ex_custom', __('Attach Custom Files'), $widget_ops);
        $this->alt_option_name = 'widget_ex_custom';

        add_action('save_post', array(&$this, 'flush_widget_cache'));
        add_action('delete_post', array(&$this, 'flush_widget_cache'));
        add_action('switch_theme', array(&$this, 'flush_widget_cache'));
    }

    public function widget($args, $instance) {
        $cache = wp_cache_get('widget_ex_custom', 'widget');
        if (!is_array($cache)) {
            $cache = array();
        }
        if (!isset($args['widget_id'])) {
            $args['widget_id'] = null;
        }
        if (isset($cache[$args['widget_id']])) {
            print $cache[$args['widget_id']];
            return;
        }

        ob_start();

        $title = (isset($instance['custom_title'])) ? $instance['custom_title'] : 'Lorem ipsum dolor title!';
        $text = (isset($instance['custom_text'])) ? $instance['custom_text'] : 'Lorem ipsum text content..';
        ?>
        <div>
            <div><?php print $title; ?></div>
            <div><?php print $text; ?></div>
        </div>
        <?php

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_ex_custom', $cache, 'widget');
    }

    public function form($instance) {
        $custom_title = (isset($instance['custom_title'])) ? esc_attr($instance['custom_title']) : '';
        $custom_text = (isset($instance['custom_text'])) ? esc_attr($instance['custom_text']) : '';
        ?>
        <div>
            <input type="text" placeholder="Input block title" value="<?php print esc_attr($custom_title); ?>" name="<?php print esc_attr($this->get_field_name('custom_title')); ?>" id="<?php print esc_attr($this->get_field_id('custom_title')); ?>" />
        </div>
        <div>
            <textarea placeholder="Input block text" name="<?php print esc_attr($this->get_field_name('custom_text')); ?>" id="<?php print esc_attr($this->get_field_id('custom_text')); ?>" rows="3" cols="50"><?php print esc_attr($custom_text); ?></textarea>
        </div>
<?php
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['custom_title'] = strip_tags($new_instance['custom_title']);
        $instance['custom_text'] = strip_tags($new_instance['custom_text']);

        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if (isset($alloptions['widget_ex_custom'])) {
            delete_option('widget_ex_custom');
        }
        return $instance;
    }

    public function flush_widget_cache() {
        wp_cache_delete('widget_ex_custom', 'widget');
    }
}
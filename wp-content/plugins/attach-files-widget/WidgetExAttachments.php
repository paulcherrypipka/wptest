<?php
/**
 * User: Vyacheslav Volkov (vexell@gmail.com)
 * Date: 07.03.13
 * Time: 0:08
 */
class WidgetExAttachments extends WP_Widget {

    function WidgetExAttachments() {
        $widget_ops = array(
            'classname'     => 'widget_ex_attachments',
            'description'   => __( 'Attach files in widget', 'ex_attachments_widget' )
        );

        $this->WP_Widget( 'widget_ex_attachments', __( 'Attach Files', 'ex_attachments_widget' ), $widget_ops );
        $this->alt_option_name = 'widget_ex_attachments';

        add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array An array of standard parameters for widgets in this theme
     * @param array An array of settings for this widget instance
     * @return void Echoes it's output
     **/
    function widget( $args, $instance )
    {
        global $wpdb, $assetsUrl, $filetype_icons;

        $cache = wp_cache_get( 'widget_ex_attachments', 'widget' );

        if ( !is_array( $cache ) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = null;

        if ( isset( $cache[$args['widget_id']] ) ) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract( $args, EXTR_SKIP );

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Attachments', 'ex_attachments_widget' ) : $instance['title'], $instance, $this->id_base);
        $icons = empty( $instance['icons']) ? 'no' : $instance['icons'];

        echo $before_widget;
        echo $before_title;
        echo $title; // Can set this with a widget option, or omit altogether
        echo $after_title;

        $data = json_decode($instance['data'], true);

        ?>

    <?php if (!empty($data)): ?>
    <div class="ex-attachments">

        <ul class="ex-attachments-<?php echo $icons; ?>icons">
            <?php foreach($data as $key => $element): ?>
            <li>
                <a target="_blank" href="<?php echo $element['link']?>">
                    <?php
                        if ($icons != 'no') {
                            $path = parse_url( $element['link'], PHP_URL_PATH );
                            $ext = strtolower( pathinfo( $path, PATHINFO_EXTENSION ) );
                            if (!array_key_exists($ext, $filetype_icons))
                                $ext = 'file';  // if no specific filetype icon, use a generic image

                            echo '<img src="'.$assetsUrl.'/images/'.$filetype_icons[$ext].'.png" />';
                        }
                        
                        echo '<div>'.$element['name'].'</div>';
                    ?>
                </a>
                <?php if (!empty($element['description'])): ?>
                    <p><?php echo $element['description']; ?></p>
                <?php endif;?>
            </li>
            <?php endforeach;?>
        </ul>

    </div>
    <?php endif; ?>

    <?php
        echo $after_widget;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set( 'widget_ex_attachments', $cache, 'widget' );
    }


    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['icons'] = $new_instance['icons'];

        $tempData = $new_instance['data'];
        $tempArray = array();

        foreach($tempData as $value) {
            if ( !empty($value) ) {
                $tempArray[] = json_decode($value, true);
            }
        }

        $instance['data'] = json_encode($tempArray);

        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset( $alloptions['widget_ex_attachments'] ) )
            delete_option( 'widget_ex_attachments' );

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete( 'widget_ex_attachments', 'widget' );
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     **/
    function form( $instance ) {
        $title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : __( 'Attachments', 'ex_attachments_widget' );
        $icons = isset( $instance['icons']) ? $instance['icons'] : 'no';
        $data = json_decode($instance['data'], true);

        preg_match('/.*?-([0-9]+)$/i', $this->id, $matches);
        ?>
    <p>
        <?php _e( 'Widget ID', 'ex_attachments_widget' ); ?>: <?php echo isset($matches[1]) ? $matches[1] : '-'; ?>
    </p>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'ex_attachments_widget' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'icons' ) ); ?>"><?php _e( 'Show file type icons:', 'ex_attachments_widget' ); ?></label><br />
        <input id="<?php echo esc_attr( $this->get_field_id( 'icons' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icons' ) ); ?>" type="radio" value="small" <?php if ($icons == 'small') echo 'checked'; ?> /><?php _e('Small icons', 'ex_attachments_widget'); ?> &nbsp;
        <input id="<?php echo esc_attr( $this->get_field_id( 'icons' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icons' ) ); ?>" type="radio" value="large" <?php if ($icons == 'large') echo 'checked'; ?> /><?php _e('Large icons', 'ex_attachments_widget'); ?> &nbsp;
        <input id="<?php echo esc_attr( $this->get_field_id( 'icons' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icons' ) ); ?>" type="radio" value="no" <?php if ($icons == 'no') echo 'checked'; ?> /><?php _e("Don't show", 'ex_attachments_widget'); ?>
    </p>

    <div>
        <a class="button-secondary ex-attachment-add-fieldset" id="ex-attachment-add-fieldset" href="#"><?php _e('Add attachment','ex_attachments_widget')?></a>
    </div>

    <ul class="ex-attachments sortable list">
        <li class="default">
            <span>
                <a class="up" href="#"></a>
                <a class="down" href="#"></a>
            </span>
            <div>
                <a target="_blank" class="a-link"></a>
                <a href="#" class="remove">(x)</a>
                <p class="desc-text"></p>
                <input name="<?php echo esc_attr( $this->get_field_name( 'data' ) ); ?>[]" type="hidden" class="link" value="" />
            </div>
        </li>
        <?php if (!empty($data)): ?>
            <?php foreach($data as $key => $value): ?>
                <li>
                    <span>
                        <a class="up" href="#"></a>
                        <a class="down" href="#"></a>
                    </span>
                    <div>
                        <a target="_blank" class="a-link" href="<?php echo $value['link']; ?>"><?php echo $value['name']; ?></a> <a href="#" class="remove">(x)</a>
                        <p class="desc-text"><?php echo $value['description']; ?></p>
                        <input name="<?php echo esc_attr( $this->get_field_name( 'data' ) ); ?>[]" type="hidden" class="link" value='<?php echo json_encode($value); ?>' />
                    </div>
                </li>
            <?php endforeach;?>
        <?php endif; ?>
    </ul>

    <?php
    }


    /**
     * Enqueue frontend CSS
     **/
    function register_widget_styles() {
        global $assetsUrl;

        wp_enqueue_style( 'widget_attachments_frontend_css', $assetsUrl.'/css/frontend.css' );
    }

}

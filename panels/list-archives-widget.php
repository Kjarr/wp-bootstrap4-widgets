<?php

class bootstrap4_list_archives_widget extends bootstrap4_base_widget {

    /** constructor -- name this the same as the class above */
    function bootstrap4_list_archives_widget() {
        parent::WP_Widget(false, $name = 'Bootstrap Archives', array('description' => 'List archives in a bootstrap panel element.'));
    }

    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {
        $widgetStyle = new WidgetStyle($instance['class']);
        $c = !empty($instance['count']) ? '1' : '0';
        $d = !empty($instance['dropdown']) ? '1' : '0';

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Archives') : $instance['title'], $instance, $this->id_base);
        $class = $instance['class'];

        if ($d) {
            $dropdown_id = "{$this->id_base}-dropdown-{$this->number}";
            ?>
            <label class="screen-reader-text" for="<?php echo esc_attr($dropdown_id); ?>"><?php echo $title; ?></label>
            <select id="<?php echo esc_attr($dropdown_id); ?>" name="archive-dropdown" onchange='document.location.href = this.options[this.selectedIndex].value;'>
                <?php
                /**
                 * Filters the arguments for the Archives widget drop-down.
                 *
                 * @since 2.8.0
                 *
                 * @see wp_get_archives()
                 *
                 * @param array $args An array of Archives widget drop-down arguments.
                 */
                $dropdown_args = apply_filters('widget_archives_dropdown_args', array(
                    'type' => 'monthly',
                    'format' => 'option',
                    'show_post_count' => $c
                ));

                switch ($dropdown_args['type']) {
                    case 'yearly':
                        $label = __('Select Year');
                        break;
                    case 'monthly':
                        $label = __('Select Month');
                        break;
                    case 'daily':
                        $label = __('Select Day');
                        break;
                    case 'weekly':
                        $label = __('Select Week');
                        break;
                    default:
                        $label = __('Select Post');
                        break;
                }
                ?>

                <option value=""><?php echo esc_attr($label); ?></option>
                <?php wp_get_archives($dropdown_args); ?>

            </select>
        <?php } else { ?>
            <div class="card <?php echo $widgetStyle->getCardClass(); ?> mb-3">
                <div class="card-header <?php echo $widgetStyle->getHeaderTextColor(); ?>"><?php echo $title ?></div>
                <div class="list-group list-group-flush">
                    <?php
                    /**
                     * Filters the arguments for the Archives widget.
                     *
                     * @since 2.8.0
                     *
                     * @see wp_get_archives()
                     *
                     * @param array $args An array of Archives option arguments.
                     */
                    wp_get_archives(apply_filters('widget_archives_args', array(
                        'type' => 'monthly',
                        'format' => 'custom',
                        'show_post_count' => $c
                    )));
                    ?>
                </div>
            </div>
            <?php
        }
    }

    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $new_instance = wp_parse_args((array) $new_instance, array('title' => '', 'count' => 0, 'dropdown' => ''));
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['class'] = strip_tags($new_instance['class']);
        $instance['count'] = $new_instance['count'] ? 1 : 0;
        $instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;

        return $instance;
    }

    /** @see WP_Widget::form -- do not rename this */
    public function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'count' => 0, 'dropdown' => ''));
        $title = sanitize_text_field($instance['title']);
        $current_class = $instance['class'];
        if (empty($current_class)) {
            $current_class = 'default';
        }
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <p>
            <input class="checkbox" type="checkbox"<?php checked($instance['dropdown']); ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" /> <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e('Display as dropdown'); ?></label>
            <br/>
            <input class="checkbox" type="checkbox"<?php checked($instance['count']); ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" /> <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show post counts'); ?></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Class:'); ?></label>
            <select class='widefat' id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>">
                <?php foreach ($this->classes as $class) { ?>
                    <option value='<?php echo $class; ?>'<?php echo ($current_class == $class) ? 'selected' : ''; ?>><?php echo $class; ?></option>
                <?php } ?>
            </select> 
        </p>
        <?php
    }

}

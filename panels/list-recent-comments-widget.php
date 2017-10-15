<?php

class bootstrap4_recent_comments_widget extends bootstrap4_base_widget {

    /** constructor -- name this the same as the class above */
    function bootstrap4_recent_comments_widget() {
        parent::WP_Widget(false, $name = 'Bootstrap Recent Comments', array('description' => 'List recent comments in a bootstrap panel element.'));
    }

    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {
        $widgetStyle = new WidgetStyle($instance['class']);
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Comments') : $instance['title'], $instance, $this->id_base);
        $class = $instance['class'];

        $number = (!empty($instance['number']) ) ? absint($instance['number']) : 5;
        if (!$number)
            $number = 5;

        $comments = get_comments(apply_filters('widget_comments_args', array(
            'number' => $number,
            'status' => 'approve',
            'post_status' => 'publish'
        )));
//        print_r($comments);
        ?>
        <div class="card <?php echo $widgetStyle->getCardClass(); ?> mb-3">
            <div class="card-header <?php echo $widgetStyle->getHeaderTextColor(); ?>"><?php echo $title ?></div>
            <ul class="list-group list-group-flush">
                <?php
                if (is_array($comments) && $comments) {
                    foreach ((array) $comments as $comment) {
                        $output = '<li class="list-group-item">';
                        /* translators: comments widget: 1: comment author, 2: post link */
                        $output .= sprintf(_x('%1$s on %2$s', 'widgets'), '<span class="comment-author-link">' . get_comment_author_link($comment) . '</span>', '<a href="' . esc_url(get_comment_link($comment)) . '">' . get_the_title($comment->comment_post_ID) . '</a>'
                        );
                        $output .= '</li>';

                        echo $output;
                    }
                }
                ?>
            </ul>
        </div>
        <?php
    }

    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['class'] = strip_tags($new_instance['class']);
        $instance['number'] = (int) $new_instance['number'];
        return $instance;
    }

    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {

        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $title = sanitize_text_field($instance['title']);
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $current_class = $instance['class'];
        if (empty($current_class)) {
            $current_class = 'default';
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
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

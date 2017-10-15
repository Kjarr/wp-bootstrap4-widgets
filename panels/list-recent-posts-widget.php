<?php

class bootstrap4_recent_posts_widget extends bootstrap4_base_widget {

    /** constructor -- name this the same as the class above */
    function bootstrap4_recent_posts_widget() {
        parent::WP_Widget(false, $name = 'Bootstrap Recent Posts', array('description' => 'List recent posts in a bootstrap panel element.'));
    }

    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {
        $widgetStyle = new WidgetStyle($instance['class']);
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
        $class = $instance['class'];

        $number = (!empty($instance['number']) ) ? absint($instance['number']) : 5;
        if (!$number)
            $number = 5;
        $show_date = isset($instance['show_date']) ? $instance['show_date'] : false;

        $r = new WP_Query(apply_filters('widget_posts_args', array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true
        )));
        ?>
        <div class="card <?php echo $widgetStyle->getCardClass(); ?> mb-3">
            <div class="card-header <?php echo $widgetStyle->getHeaderTextColor(); ?>"><?php echo $title ?></div>
            <div class="list-group list-group-flush">
                <?php while ($r->have_posts()) : $r->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="list-group-item">
                        <?php get_the_title() ? the_title() : the_ID(); ?>
                        <?php if ($show_date) : ?>
                            <span class="badge <?php echo $widgetStyle->getBadgeClass(); ?> float-right"><?php echo get_the_date(); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
    }

    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['class'] = strip_tags($new_instance['class']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = isset($new_instance['show_date']) ? (bool) $new_instance['show_date'] : false;
        return $instance;
    }

    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {

        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $title = sanitize_text_field($instance['title']);
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $show_date = isset($instance['show_date']) ? (bool) $instance['show_date'] : false;
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
            <input class="checkbox" type="checkbox"<?php checked($show_date); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" />
            <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Display post date?'); ?></label>
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

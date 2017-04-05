<?php

class bootstrap3_list_categories_widget extends WP_Widget {
 
	private $classes = array(
				'default',
				'primary',
				'success',
				'info',
				'warning',
				'danger',
			);
 
    /** constructor -- name this the same as the class above */
    function bootstrap3_list_categories_widget() {
        parent::WP_Widget(false, $name = 'Bootstrap Categories', array('description' => 'List categories in a bootstrap elements.'));
    }
 
	/** @see WP_Widget::widget -- do not rename this */
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title'], $instance, $this->id_base );
		$class = $instance['class'];
		
		// retrieves an array of categories or taxonomy terms
		$cats = get_categories();
		?>
			<div class="panel panel-<?php echo $class; ?>">
				<div class="panel-heading"><?php echo $title?></div>
				<div class="list-group">
					<?php foreach($cats as $cat) {?>
							<a href="<?php echo get_term_link($cat->slug, "category"); ?>" class="list-group-item" title="<?php sprintf( __( "View all posts in %s" ), $cat->name ); ?>">
							<span class="badge float-right"><?php echo $cat->count; ?></span>
								<?php echo $cat->name; ?>
							</a>
					<?php } ?>
				</div>
			</div>
		<?php
	}
 
	/** @see WP_Widget::update -- do not rename this */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['class'] = strip_tags($new_instance['class']);
		return $instance;
	}
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {
 
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = sanitize_text_field( $instance['title'] );
		$current_class = $instance['class'];
		if(empty($current_class)) {
			$current_class = 'default';
		}
        ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Class:'); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>">
				<?php foreach($this->classes as $class) { ?>
					<option value='<?php echo $class; ?>'<?php echo ($current_class==$class)?'selected':''; ?>><?php echo $class; ?></option>
				<?php } ?>
			</select> 
		</p>
        <?php
    }
 
 
}
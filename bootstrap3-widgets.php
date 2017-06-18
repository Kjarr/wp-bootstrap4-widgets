<?php

/*
  Plugin Name: Bootstrap Widgets Bundle
  Plugin URI: http://kiksoft.ro/
  Description: Customizable Bootstrap Widgets Bundle compatible with SiteOrigin Page Builder.
  Version: 1.0
  Author: Calin Ipate
  Author URI: http://kiksoft.ro
 */

include(plugin_dir_path(__FILE__) . 'panels/list-categories-widget.php');
include(plugin_dir_path(__FILE__) . 'panels/list-recent-posts-widget.php');
include(plugin_dir_path(__FILE__) . 'panels/list-recent-comments-widget.php');

function bootstrap3_widgets_register_widgets() {
    register_widget('bootstrap3_list_categories_widget');
    register_widget('bootstrap3_recent_posts_widget');
    register_widget('bootstrap3_recent_comments_widget');
}

add_action('widgets_init', 'bootstrap3_widgets_register_widgets');

// Add this to enqueue your scripts on Page Builder too
add_action('siteorigin_panel_enqueue_admin_scripts', 'bootstrap3_widgets_register_widgets');
?>
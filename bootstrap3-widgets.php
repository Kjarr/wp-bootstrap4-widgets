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
include(plugin_dir_path(__FILE__) . 'panels/list-archives-widget.php');

function bootstrap3_widgets_register_widgets() {
    register_widget('bootstrap3_list_categories_widget');
    register_widget('bootstrap3_recent_posts_widget');
    register_widget('bootstrap3_recent_comments_widget');
    register_widget('bootstrap3_list_archives_widget');
}

function bootstrap3_customize_archives_links($links) {
    $links = str_replace('<a ', '<a class="list-group-item"', $links);
    $links = str_replace('</a>&nbsp;(', '<span class="badge float-right">', $links);
    $links = str_replace(')', '</span></a>', $links);
    return $links;
}

add_filter('get_archives_link', 'bootstrap3_customize_archives_links');

add_action('widgets_init', 'bootstrap3_widgets_register_widgets');

// Add this to enqueue your scripts on Page Builder too
add_action('siteorigin_panel_enqueue_admin_scripts', 'bootstrap3_widgets_register_widgets');
?>
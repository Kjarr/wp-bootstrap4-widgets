<?php

/*
  Plugin Name: Bootstrap 4.0 Widgets Bundle
  Plugin URI: http://kiksoft.ro/
  Description: Customizable Bootstrap 4.0 Widgets Bundle compatible with SiteOrigin Page Builder.
  Version: 1.1
  Author: Calin Ipate
  Author URI: http://kiksoft.ro
 */

class bootstrap4_base_widget extends WP_Widget {

    public $text_color = "";
    public $class = "";
    public $badge_class = "";
    protected $classes = [
        'primary',
        'secondary',
        'success',
        'danger',
        'warning',
        'info',
        'light',
        'dark',
    ];

    function widget($args, $instance) {
        extract($args);
        $this->class = "bg-" . $instance['class'];
        $this->badge_class = "badge-" . $instance['class'];
        $this->text_color = "text-white";

        if ($this->class == "bg-light" || $this->class == "bg-warning") {
            $this->text_color = "";
        }
    }

}

class WidgetStyle {

    public $class = "";
    public $cardClass = "";
    public $badgeClass = "";
    public $headerTextColor = "text-white";

    function __construct($class) {
        $this->class = $class;
        $this->cardClass = "bg-" . $this->class;
        $this->$badgeClass = "badge-" . $this->class;
        if ($class == "light") {
            $this->headerTextColor = "";
        }
    }

    function getCardClass() {

        return $this->cardClass;
    }

    function getBadgeClass() {

        return $this->$badgeClass;
    }

    public function getHeaderTextColor() {

        return $this->headerTextColor;
    }

}

include(plugin_dir_path(__FILE__) . 'panels/list-categories-widget.php');
include(plugin_dir_path(__FILE__) . 'panels/list-recent-posts-widget.php');
include(plugin_dir_path(__FILE__) . 'panels/list-recent-comments-widget.php');
include(plugin_dir_path(__FILE__) . 'panels/list-archives-widget.php');

function bootstrap4_widgets_register_widgets() {
    register_widget('bootstrap4_list_categories_widget');
    register_widget('bootstrap4_recent_posts_widget');
    register_widget('bootstrap4_recent_comments_widget');
    register_widget('bootstrap4_list_archives_widget');
}

function bootstrap4_customize_archives_links($links) {
    $links = str_replace('<a ', '<a class="list-group-item"', $links);
    $links = str_replace('</a>&nbsp;(', '<span class="badge badge-dark float-right">', $links);
    $links = str_replace(')', '</span></a>', $links);
    return $links;
}

add_filter('get_archives_link', 'bootstrap4_customize_archives_links');

add_action('widgets_init', 'bootstrap4_widgets_register_widgets');

// Add this to enqueue your scripts on Page Builder too
add_action('siteorigin_panel_enqueue_admin_scripts', 'bootstrap4_widgets_register_widgets');
?>
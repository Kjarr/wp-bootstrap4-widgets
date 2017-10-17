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
    public $listGroupColor = "";

    function __construct($class) {
        $this->class = $class;
        $this->cardClass = "bg-" . $this->class;
        $this->badgeClass = "badge-" . $this->class;
        if ($class == "light" || $class == "warning") {
            $this->headerTextColor = "";
        }
        $this->listGroupColor = "list-group-item-" . $class;
    }

    /**
     * This method returns the class to be used for Bootstrap Cards
     * @return string
     */
    public function getCardClass() {

        return $this->cardClass;
    }

    public function getBadgeClass() {

        return $this->badgeClass;
    }

    public function getHeaderTextColor() {

        return $this->headerTextColor;
    }

    public function getListItemClass() {

        return $this->listGroupColor;
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

add_action('widgets_init', 'bootstrap4_widgets_register_widgets');

// Add this to enqueue your scripts on Page Builder too
add_action('siteorigin_panel_enqueue_admin_scripts', 'bootstrap4_widgets_register_widgets');
?>
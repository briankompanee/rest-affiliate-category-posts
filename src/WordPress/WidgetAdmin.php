<?php

/*
 * This file is part of WordPress Widget Boilerplate
 * (c) Tom McFarlin <tom@tommcfarlin.com>
 *
 * This source file is subject to the GPL license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WordPressWidgetBoilerplate\WordPress;

/**
 * Manages the administrative functionality of the widget.
 */
class WidgetAdmin extends Widget
{
    /**
     * {@inheritdoc}
     */
    public function __construct($widgetSlug)
    {
        parent::__construct($widgetSlug);
        $this->widgetSerializer = new WidgetSerializer($this->getWidgetSlug());
        $this->widgetDisplay = new WidgetDisplay($this->getWidgetSlug());
    }

    /**
     * Displays the administrative view of the form and includes the options
     * for the instance of the widget as arguments passed into the function.
     *
     * @param array $instance the options for the instance of this widget
     */
    public function form($instance)
    {   

        //Get values from widget form or set default
        $title      = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $category   = isset( $instance['category'] ) ? absint( $instance['category'] ) : 1;
        $number     = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $cache_time = isset( $instance['cache_time'] ) ? absint( $instance['cache_time'] ) : 1;
        $url        = isset ($instance['url'] ) ? esc_url( $instance['url'] ) : '';

        //Get all categories from REST URL
        $categories = '';
        if (isset ($instance['url'] )) {
            $url_cat = trailingslashit( $instance[ 'url' ] ) . 'wp-json/wp/v2/categories';
            $r_cat = wp_safe_remote_get( $url_cat );
            if( ! is_wp_error( $r_cat ) ){
                $categories = json_decode( wp_remote_retrieve_body( $r_cat ) );
            }
        }

        include plugin_dir_path(__FILE__).'Views/Admin.php';
    }
}

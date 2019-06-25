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
 * Validates and displays the content of the widget.
 */
class WidgetDisplay
{
    /**
     * @var string a reference to the slug of the widget to which this class is associated
     */
    private $widgetSlug;

    /**
     * Initializes the class.
     *
     * @param string a reference to the slug of the widget to which the serialier is associated
     */
    public function __construct(string $widgetSlug)
    {
        $this->widgetSlug = $widgetSlug;
    }

    /**
     * Displays the widget based on the contents of the included template.
     *
     * @param array $args     argument provided by WordPress that may be useful in rendering the widget
     * @param array $instance the values of the widget
     *
     * @SuppressWarnings("unused")
     */
    public function show($args, $instance)
    {   
        //Get Widget ID
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        //Create Cache Items
        $cache_time = ( ! empty( $instance['cache_time'] ) ) ? absint( $instance['cache_time'] ) : 5;
        $cache_key = md5( __CLASS__ . implode( $args ) );
        if( 0 < $cache_time && false != ($cached = get_transient( $cache_key ) ) ){
            echo $cached;
            return;
        }

        //Hold object Values
        ob_start();

        //Set Variables for options
        $title    = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts', 'josh-remote-recent-posts' );
        $number   = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        $category = ( ! empty( $instance['category'] ) ) ? absint( $instance['category'] ) : 1;

        //Get the selcted number of posts in the selected category using the REST API
        $url = trailingslashit( $instance[ 'url' ] ) . 'wp-json/wp/v2/posts?categories=' . $category;
        $url = add_query_arg( 'per_page', $number, $url );
        $r = wp_safe_remote_get( $url );
        if( ! is_wp_error( $r ) ){
            $posts = json_decode( wp_remote_retrieve_body( $r ) );
            if( ! empty( $posts ) ){
                echo $args['before_widget'];
                if ( $title ) {
                    echo $args[ 'before_title' ] . $title . $args[ 'after_title' ];
                    include plugin_dir_path(__FILE__).'Views/Widget.php';
                    echo $args['after_widget'];
                }
            }
        }

        //Print the cached output if enabled otherwise print the fresh posts
        $output = ob_get_clean();
        if( 0 < $cache_time ){
            set_transient( $cache_key, $output, $cache_time );
        }
        echo $output;
    }
}

<?php
/*
Plugin Name: MD Popular Posts
Plugin URI: http://github.com/ivillamil/md-popular-posts
Description: Create a new widget with two tabs, one for popular posts based on visits and other for pupular posta based on comments.
Version: 1.0
Author: Iván Villamil
Author URI: http://meridadesign.com
Author Email: ivillamil@meridadesign.com
Text Domain: md-popular-posts
Domain Path: /lang/
Network: false
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2012 (ivillamil@meridadesign.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define ( 'MD_PP_PATH', plugin_dir_path( __FILE__ ) );
define ( 'MD_PP_SLUG', 'md-popular-posts' );
define ( 'MD_PP_LOCALE', 'md-pp-locale' );

require( MD_PP_PATH . '/src/md_popular_posts.php' );

function call_md_pp() {
    return register_widget( 'MD_Popular_Posts_Widget' );
}
add_action( 'widgets_init', 'call_md_pp' );


/**
 * Increase the number of posts views
 */
function md_increase_visits() {
    global $post;

    if ( !is_single())
        return;

    $md_visits = (int) get_post_meta( $post->ID, '_md_visits', true );
    if( $md_visits == 0 )
        $md_visits = 1;
    else
        $md_visits++;

    if ( $md_visits === 1 )
        add_post_meta( $post->ID, '_md_visits', $md_visits );
    else
        update_post_meta( $post->ID, '_md_visits', $md_visits );
}
add_action( 'wp', 'md_increase_visits' );

function md_get_category_class( $post_id ) {
    $categories = get_the_category( $post_id );
    $cat_names = array_map( 'md_get_cat_slug', $categories );

    if ( in_array( 'articulos', $cat_names ) )
        return 'article';
    else if( in_array( 'tutoriales', $cat_names ) )
        return 'tutoria';
    else if( in_array( 'snippets', $cat_names ) )
        return 'snippet';
    else if( in_array( 'videos', $cat_names ) )
        return 'video';
    else if( in_array( 'recursos', $cat_names ) )
        return 'resource';
    else 'article';
}

function md_get_cat_slug( $cat ) {
    return $cat->slug;
}


function minima_custom_order_posts( $query ) {
    if ( $query->is_archive() && isset( $_GET['orderby'] ) && $_GET['orderby'] == 'popularity' ) {
        $query->set( 'meta_key', '_md_visits' );
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'order', 'DESC' );
        return;
    }
}
add_action( 'pre_get_posts', 'minima_custom_order_posts', 1 );
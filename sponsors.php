<?php
/*
Plugin Name: SBCG Sponsors
Plugin URI: https://github.com/michaeldfoley/sbcg-plugin-sponsors
Description: Custom post type for adding sponsors to the website.
Version: 0.1
Author: Michael Foley
Author URI: http://michaeldfoley.com
License: GNU General Public License v2.0
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: _sbcgsponsors
Domain Path: /languages/
*/

add_action( 'init', '_sbcg_create_sponsors' );


function _sbcg_create_sponsors() {
  register_post_type( '_sbcg_sponsors',
    array(
      'labels' => array(
        'name' => __( 'Sponsors', '_sbcgsponsors' ),
        'singular_name' => __( 'Sponsor', '_sbcgsponsors' ),
        'add_new' => __( 'Add New', '_sbcgsponsors' ),
        'add_new_item' => __( 'Add New Sponsor', '_sbcgsponsors' ),
        'edit' => __( 'Edit', '_sbcgsponsors' ),
        'edit_item' => __( 'Edit Sponsor', '_sbcgsponsors' ),
        'new_item' => __( 'New Sponsor', '_sbcgsponsors' ),
        'view' => __( 'View', '_sbcgsponsors' ),
        'view_item' => __( 'View Sponsor', '_sbcgsponsors' ),
        'search_items' => __( 'Search Sponsors', '_sbcgsponsors' ),
        'not_found' => __( 'No sponsors found', '_sbcgsponsors' ),
        'not_found_in_trash' => __( 'No sponsors found in the trash', '_sbcgsponsors' ),
        'parent' => __( 'Parent Sponsor', '_sbcgsponsors' ),
        'parent_item_colon' => __( 'Parent Sponsor', '_sbcgsponsors' ),
        'all_items' => __( 'All Sponsors', '_sbcgsponsors' )
      ),
      'rewrite' => array(
        'slug' => __( 'sponsors', '_sbcgsponsors' )
      ),
      'public' => true,
      'menu_position' => 30,
      'supports' => array( 'title', 'editor', 'thumbnail' ),
      'taxonomies' => array( 
        __( 'Founding Sponsor', '_sbcgsponsors' ),
      ),
      'menu_icon' => 'dashicons-money',
      'has_archive' => true
    )
  );
}

/**
 * Adds sponsors shortcode
 *
 */
require plugin_dir_path( __FILE__ ) . 'shortcode.php';


?>
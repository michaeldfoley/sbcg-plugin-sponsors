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
        'edit_item' => __( 'Edit Sponsor', '_sbcgsponsors' ),
        'new_item' => __( 'New Sponsor', '_sbcgsponsors' ),
        'all_items' => __( 'All Sponsors', '_sbcgsponsors' ),
        'view_item' => __( 'View Sponsor', '_sbcgsponsors' ),
        'search_items' => __( 'Search Sponsors', '_sbcgsponsors' ),
        'not_found' => __( 'No sponsors found', '_sbcgsponsors' ),
        'not_found_in_trash' => __( 'No sponsors found in the trash', '_sbcgsponsors' ),
        'parent_item_colon' => __( 'Parent Sponsor', '_sbcgsponsors' ),
        'menu_name' => __( 'Sponsors', '_sbcgsponsors' )
      ),
      'rewrite' => array(
        'slug' => __( 'sponsors', '_sbcgsponsors' )
      ),
      'public' => true,
      'menu_position' => 30,
      'supports' => array( 'title', 'thumbnail' ),
      'taxonomies' => array( ),
      'menu_icon' => 'dashicons-money',
      'has_archive' => true
    )
  );
}


/**
 * Add website field
 */
 
add_action("add_meta_boxes__sbcg_sponsors", "_sbcg_add_sponsors_website");
 
function _sbcg_add_sponsors_website(){
  add_meta_box('_sbcg_sponsors_website', __( 'Sponsor Website', '_sbcgsponsors' ), '_sbcg_sponsors_website_callback', '_sbcg_sponsors', 'normal');
}
 
function _sbcg_sponsors_website_callback( $post ){
	wp_nonce_field( '_sbcg_sponsors_website', '_sbcg_sponsors_website_nonce' );
	
  $value = get_post_meta( $post->ID, '_sbcg_sponsors_value_key', true );

	echo '<label for="_sbcg_sponsors_website">';
	_e( 'Website', '_sbcgsponsors' );
	echo '</label> ';
	echo '<input type="text" id="_sbcg_sponsors_website" name="_sbcg_sponsors_website" value="' . esc_attr( $value ) . '" style="width: calc(100% - 60px);" />';
}

function _sbcg_sponsors_meta_save( $post_id ) {
  
	// Check if our nonce is set.
	if ( ! isset( $_POST['_sbcg_sponsors_website_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['_sbcg_sponsors_website_nonce'], '_sbcg_sponsors_website' ) ) {
		return;
	}

	// Don't save on autosave.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	
	// Make sure that it is set.
	if ( ! isset( $_POST['_sbcg_sponsors_website'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = esc_url_raw( $_POST['_sbcg_sponsors_website'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_sbcg_sponsors_value_key', $my_data );
}
add_action( 'save_post', '_sbcg_sponsors_meta_save' );


/**
 * Adds sponsors shortcode
 */
require plugin_dir_path( __FILE__ ) . 'shortcode.php';


/**
 * Adds archive status
 */
require plugin_dir_path( __FILE__ ) . 'status.php';
?>
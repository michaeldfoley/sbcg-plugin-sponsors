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


/**
 * Check to make sure 
 */
 

add_action( 'admin_init', '_sbcg_sponsors_has_meta_box' );
function _sbcg_sponsors_has_meta_box() {
    if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'meta-box/meta-box.php' ) ) {
        add_action( 'admin_notices', 'child_plugin_notice' );

        deactivate_plugins( plugin_basename( __FILE__ ) ); 

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
}

function child_plugin_notice(){
    ?><div class="error"><p>Sorry, but SBCG Sponsors requires the Meta Box plugin to be installed and active.</p></div><?php
}


add_action( "init", "_sbcg_create_sponsors" );


function _sbcg_create_sponsors() {
  $textdomain = "_sbcgsponsors";
  register_post_type( "_sbcg_sponsors",
    array(
      "labels" => array(
        "name" => __( "Sponsors", $textdomain ),
        "singular_name" => __( "Sponsor", $textdomain ),
        "add_new" => __( "Add New", $textdomain ),
        "add_new_item" => __( "Add New Sponsor", $textdomain ),
        "edit_item" => __( "Edit Sponsor", $textdomain ),
        "new_item" => __( "New Sponsor", $textdomain ),
        "all_items" => __( "All Sponsors", $textdomain ),
        "view_item" => __( "View Sponsor", $textdomain ),
        "search_items" => __( "Search Sponsors", $textdomain ),
        "not_found" => __( "No sponsors found", $textdomain ),
        "not_found_in_trash" => __( "No sponsors found in the trash", $textdomain ),
        "parent_item_colon" => __( "Parent Sponsor", $textdomain ),
        "menu_name" => __( "Sponsors", $textdomain )
      ),
      "rewrite" => array(
        "slug" => __( "sponsors", $textdomain )
      ),
      "public" => true,
      "menu_position" => 30,
      "supports" => array( "title", "thumbnail" ),
      "taxonomies" => array( ),
      "menu_icon" => "dashicons-money",
      "has_archive" => true
    )
  );
}


/**
 * Custom Fields
 */
 
 
add_filter( "rwmb_meta_boxes", "_sbcg_sponsors_meta_boxes" );
function _sbcg_sponsors_meta_boxes( $meta_boxes ) {
    $prefix = "_sbcg_sponsors";
    $textdomain = "_sbcgsponsors";
    $meta_boxes[] = array(
        "title"      => __( "Sponsor Info", "textdomain" ),
        "post_types" => $prefix,
        "fields"     => array(
            array(
                "id"   => "{$prefix}_value_key",
                "name" => __( "Website", $textdomain ),
                "type" => "text"
            ),
            array(
                "id"      => "{$prefix}_current",
                "name"    => __( "Current Sponsor", $textdomain ),
                "type"    => "checkbox",
                "std"     => 1
            ),
            array(
                "id"      => "{$prefix}_season",
                "name"    => __( "Season Sponsor", $textdomain ),
                "type"    => "checkbox",
                "std"     => 0
            ),
        ),
    );
    return $meta_boxes;
}

/**
 * Adds sponsors shortcode
 */
require plugin_dir_path( __FILE__ ) . "shortcode.php";


/**
 * Adds archive status
 */
require plugin_dir_path( __FILE__ ) . "status.php";
?>
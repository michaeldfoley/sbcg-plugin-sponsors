<?php
/**
 * Adds sponsors archive status
 *
 */
 
function _sbcg_sponsors_status(){
  register_post_status( "archive", array(
    "label"                     => _x( "Archive", "sponsor", "_sbcgsponsors" ),
    "public"                    => true,
    "show_in_admin_all_list"    => false,
    "show_in_admin_status_list" => true,
    "label_count"               => _n_noop( "Archive <span class=\"count\">(%s)</span>", "Archive <span class=\"count\">(%s)</span>", "_sbcgsponsors" )
  ) );
}
add_action( "init", "_sbcg_sponsors_status" );


function _sbcg_append_sponsors_status_list(){
  global $post;
  $complete = "";
  $label = "";
  if($post->post_type == "_sbcg_sponsors"){
    if($post->post_status == "archive"){
      $complete = " selected=\"selected\"";
      $label = "<span id=\"post-status-display\"> Archived</span>";
    }
    echo '
    <script>
    jQuery(document).ready(function($){
      $("select#post_status").append("<option value=\"archive\" '.$complete.'>Archive</option>");
      $(".misc-pub-section label").append("'.$label.'");
    });
    </script>
    ';
  }
}
add_action("admin_footer-post.php", "_sbcg_append_sponsors_status_list");

?>
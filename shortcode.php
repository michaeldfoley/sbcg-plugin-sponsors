<?php
/**
 * Adds sponsors shortcode
 *
 */
 
function _sbcg_sponsors( $atts, $content = '' ) {
  $args = shortcode_atts( array(
    'id' => '',
    'name' => '',
  ), $atts );
  
  $out = null;
  $query = new WP_Query( 
    array(
      'post_type' => '_sbcg_sponsors',
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'caller_get_posts'=> 1
    )
  );
    
  if( $query->have_posts() ) :
    while ($query->have_posts()) : $query->the_post();
      $out .= sprintf( "\n<li class=\"sponsor\">%s</li>\n", 
          ( has_post_thumbnail() ) ? "<img src=\"" . wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' )[0] . "\" alt=\"" . get_the_title() . "\">" : get_the_title()
        );
    endwhile;
  endif;
  
  wp_reset_query();
    
  return "<ul class=\"sponsors\">{$out}</ul>";
}
add_shortcode( 'sponsors', '_sbcg_sponsors' );


?>
<?php
/**
 * The template for displaying Search Results pages.
 * Modified version of the AgriLife Today theme
 *
 * @package WordPress
 * @subpackage AgriLife Today
 */

// Remove search result meta data
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_content', 'genesis_do_post_permalink', 14 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Add search results page title
add_action( 'genesis_before_loop', function() {

	$heading = '<div class="archive-description heading-sideline"><div class="grid-x"><div class="cell auto title-line"></div><h1 class="archive-title two-line">Search Results</h1><div class="cell auto title-line"></div></div></div>';

  $title = sprintf( $heading, get_search_query() );

  echo $title;

});


remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_before_loop', 'agcs_results' );

function agcs_results(){

  $agcs_search_id = get_field( 'google_custom_search_id', 'option' );

  $template = file_get_contents( AGCS_DIR_PATH . 'views/google-cse.php' );
  echo str_replace( '%s', $agcs_search_id, $template );

}

genesis();

<?php
/**
 * The template for displaying Search Results pages.
 * Modified version of the AgriFlex4 theme
 *
 * @package WordPress
 * @subpackage AgriFlex4
 */

// Remove search result meta data
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_content', 'genesis_do_post_permalink', 14 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Add search results page title
add_action( 'genesis_before_loop', function() {

  $title = sprintf( '<div class="entry-header"><h1 class="entry-title">Search Results for: %s</h1></div>',
    get_search_query()
  );

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

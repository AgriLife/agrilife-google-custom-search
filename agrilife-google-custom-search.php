<?php
/**
 * Plugin Name: AgriLife Google Custom Search
 * Plugin URI: https://github.com/AgriLife/agrilife-google-custom-search
 * Description: Replaces default WordPress search with Google Custom Search Engine
 * Version: 1.0
 * Author: Zach Watkins
 * Author URI: https://github.com/ZachWatkins
 * Author Email: zachary.watkins@ag.tamu.edu
 * License: GPL2+
**/

// If this file is called directly, abort.
defined( 'ABSPATH' ) or die( 'access denied' );

define( 'AGCS_DIR_PATH', plugin_dir_path( __FILE__ ) );

require_once( AGCS_DIR_PATH . 'fields/settings.php');

// Register styles used in the plugin
function agcs_register_styles(){

  wp_register_style(
    'arilife-gcs-styles',
    plugin_dir_url( __FILE__ ) . 'css/agrilife-google-custom-search.css',
    array(),
    '',
    'screen'
  );

}

add_action( 'wp_enqueue_scripts', 'agcs_register_styles' );

// Queue styles used in the plugin
function agcs_enqueue_styles(){

    wp_enqueue_style( 'arilife-gcs-styles' );

}

add_action( 'wp_enqueue_scripts', 'agcs_enqueue_styles' );

// Add admin menu page for the site's Google Custom Search ID
function agcs_admin_menu(){

  if( !class_exists('acf') || !function_exists('acf_add_options_sub_page') ){

    add_action( 'admin_notices', 'agcs_error' );

  } else {

    acf_add_options_sub_page( array(
      'page_title'  => 'Google Custom Search',
      'menu_title'  => 'Google Custom Search',
      'menu_slug'   => 'agriflex-google-custom-search-settings',
      'capability'  => 'manage_options',
      'parent_slug' => 'options-general.php'
    ) );

  }

}

add_action( 'admin_menu', 'agcs_admin_menu' );

// Use custom archive template based on situation
function agcs_search_template( $template ){

  global $wp_query;

  // If on a search results page
  if ($wp_query->is_search){

    $theme = wp_get_theme()->Name;

    if( $theme == 'AgriLife-News' ){

      return AGCS_DIR_PATH . 'templates/archive-agrilifenews.php';

    } else if( $theme == 'AgriFlex3' ){

      return AGCS_DIR_PATH . 'templates/archive-agriflex3.php';

    } else if( $theme == 'AgriFlex4' ){

      return AGCS_DIR_PATH . 'templates/archive-agriflex4.php';

    }

  }

  return $template;

}

add_filter('template_include', 'agcs_search_template', 99);

// Handle some archives without using a custom template
function agcs_search_content( $content ){

  global $wp_query;

  // If on a search results page
  if ($wp_query->is_search){

    $theme = wp_get_theme()->Name;

    if( $theme != 'AgriLife-News' && $theme != 'AgriFlex3' ){

      $search_id = get_field( 'google_custom_search_id', 'option' );

      $template = file_get_contents( AGCS_DIR_PATH . 'views/google-cse.php' );

      $content = str_replace( '%s', $search_id, $template );

    }

  }

  return $content;

}

add_filter( 'the_content', 'agcs_search_content', 99 );

// Provide error message during installation if dependencies not present
function agcs_error(){

  if( !class_exists('acf') )
    $msg = 'Advanced Custom Fields is not installed';
  else if( !function_exists('acf_add_options_sub_page') )
    $msg = 'the function "acf_add_options_sub_page" is not defined';

  ?>
  <div class="error notice">
    <p>AgriLife Google Custom Search is unavailable because <?php echo $msg; ?>. Either install the Advanced Custom Fields Pro plugin version 5.0.0 or above, or Advanced Custom Fields plugin and the Options Page Add-on plugin.</p>
  </div>
  <?php

}

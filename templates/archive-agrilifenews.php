<?php
/**
 * The template for displaying Search Results pages.
 * Modified version of the AgriLife-News theme
 *
 * @package WordPress
 * @subpackage flexopotamus
 * @since flexopotamus 1.0
 */

get_header(); ?>

<div class="content-wrap">
  <section id="content" role="main" class="two-of-3 column">

    <header class="page-header">
      <h1 class="page-title section-title"><?php printf( __( 'Search Results for: %s', 'flexopotamus' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
    </header>

    <?php /* Start the Loop */

    $agcs_search_id = get_field( 'google_custom_search_id', 'option' );

    $template = file_get_contents( AGCS_DIR_PATH . 'views/google-cse.php' );
    echo str_replace( '%s', $agcs_search_id, $template );

    ?>

  </section><!-- /end #content -->

<?php get_sidebar(); ?>

</div><!-- /.content-wrap -->

<?php get_footer(); ?>

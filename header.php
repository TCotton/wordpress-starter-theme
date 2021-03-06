<?php require_once( TEMPLATEPATH . '/classes/Create_Menus.php' ); ?>
<!DOCTYPE HTML>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>
		<?php // http://css-tricks.com/snippets/wordpress/dynamic-title-tag/
		if ( function_exists( 'is_tag' ) && is_tag() ) {
			single_tag_title( "Tag Archive for &quot;" );
			echo '&quot; - ';
		} elseif ( is_archive() ) {
			wp_title( '' );
			echo ' Archive - ';
		} elseif ( is_search() ) {
			echo 'Search for &quot;' . esc_html( $s ) . '&quot; - ';
		} elseif ( ! ( is_404() ) && ( is_single() ) || ( is_page() ) ) {
			wp_title( '' );
			echo ' - ';
		} elseif ( is_404() ) {
			echo 'Not Found - ';
		}
		if ( is_home() ) {
			bloginfo( 'name' );
			echo ' - ';
			bloginfo( 'description' );
		} else {
			bloginfo( 'name' );
		}
		if ( $paged > 1 ) {
			echo ' - page ' . $paged;
		} ?>
  </title>
  <link rel="stylesheet" type="text/css" href="<?php get_stylesheet_uri() .print '?' . rand(); ?>"/>

  <link rel="alternate" type="application/rss+xml" href="<?php bloginfo( 'rdf_url' ); ?>" title="<?php printf( __
	( '%s latest posts' ), esc_html( get_bloginfo( 'name' ) ) ) ?>"/>

  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>"/>

  <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">

	<?php wp_head() // For plugins ?>
</head>

<body <?php body_class(); ?>>
<div class="access clearfix visuallyhidden">
  <div class="skip-link"><a href="#content" title="<?php echo 'Skip to content' ?>"><?php echo
			'Skip to content' ?></a></div>
</div>
<div class="wrapper">
  <div class="header">
    <div class="inner-header wrap clearfix">

      <!-- to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> -->
      <p class="logo"><a href="<?php echo home_url(); ?>" rel="nofollow">
					<?php bloginfo( 'name' ); ?>
        </a></p>

      <!-- if you'd like to use the site description you can un-comment it below -->
			<?php bloginfo( 'description' ); ?>
      <div>

				<?php

				if ( class_exists( '\\startertheme\\menu\\Create_Menus' ) ) {
					\startertheme\menu\Create_Menus::main_nav();
				} else {
					echo 'No class called Create Menus has been found';
				} ?>
      </div>
    </div>
    <!-- end #inner-header -->

  </div>
  <!-- end header -->

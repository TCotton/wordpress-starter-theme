<?php /*
Include classes below
*/
foreach ( scandir( TEMPLATEPATH . '/classes' ) as $result ) {

	if ( preg_match( '/\.php$/', $result ) ) {

		require_once( TEMPLATEPATH . '/classes/' . $result );

	}

} // end foreach loop


// we're firing all out initial functions at the start
add_action( 'after_setup_theme', 'starter_init', 15 );

function starter_init() {

	// cleaning up random code around images
	add_filter( 'the_content', 'starter_filter_ptags_on_images' );

	// add jquery
	add_action( 'wp_enqueue_scripts', 'call_jquery' );

	// enable all possible post formats

	add_theme_support( 'post-formats', array(
		'aside',
		'gallery',
		'link',
		'image',
		'quote',
		'status',
		'video',
		'audio',
		'chat',
	) );

	add_post_type_support( 'post', 'post-formats' );
	add_post_type_support( 'page', 'post-formats' );

	remove_action( 'wp_head', 'feed_links_extra', 3 ); // Removes the links to the extra feeds such as category feeds
	remove_action( 'wp_head', 'feed_links', 2 ); // Removes links to the general feeds: Post and Comment Feed
	remove_action( 'wp_head', 'rsd_link' ); // Removes the link to the Really Simple Discovery service endpoint, EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' ); // Removes the link to the Windows Live Writer manifest file.
	remove_action( 'wp_head', 'index_rel_link' ); // Removes the index link
	remove_action( 'wp_head', 'parent_post_rel_link' ); // Removes the prev link
	remove_action( 'wp_head', 'start_post_rel_link' ); // Removes the start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link' ); // Removes the relational links for the posts adjacent to the current post.
	remove_action( 'wp_head', 'wp_generator' ); // Removes the WordPress version i.e. - WordPress 2.8.4

	add_filter( 'the_category', 'snip_category_rel' );
	add_filter( 'wp_list_categories', 'snip_category_rel' );

	// wp menus
	add_theme_support( 'menus' );

	add_theme_support( 'post-thumbnails' );


}

// call jquery
function call_jquery() {

	wp_enqueue_script( 'jquery' );

}

// remove rel=category because it does not validate
function snip_category_rel( $result ) {
	$result = str_replace( 'rel="category"', '', $result );

	return $result;
}

/*********************
 * PAGE NAVI
 *********************/

// Numeric Page Navi (built into the theme by default)
function starter_page_navi( $before = '', $after = '' ) {
	global $wpdb, $wp_query;
	$request        = $wp_query->request;
	$posts_per_page = intval( get_query_var( 'posts_per_page' ) );
	$paged          = intval( get_query_var( 'paged' ) );
	$numposts       = $wp_query->found_posts;
	$max_page       = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) {
		return;
	}
	if ( empty( $paged ) || $paged == 0 ) {
		$paged = 1;
	}
	$pages_to_show         = 7;
	$pages_to_show_minus_1 = $pages_to_show - 1;
	$half_page_start       = floor( $pages_to_show_minus_1 / 2 );
	$half_page_end         = ceil( $pages_to_show_minus_1 / 2 );
	$start_page            = $paged - $half_page_start;
	if ( $start_page <= 0 ) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if ( ( $end_page - $start_page ) != $pages_to_show_minus_1 ) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if ( $end_page > $max_page ) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page   = $max_page;
	}
	if ( $start_page <= 0 ) {
		$start_page = 1;
	}
	echo $before . '<nav class="page-navigation"><ol class="bones_page_navi clearfix">' . "";
	if ( $start_page >= 2 && $pages_to_show < $max_page ) {
		$first_page_text = "First";
		echo '<li class="bpn-first-page-link"><a href="' . get_pagenum_link() . '" title="' . $first_page_text .
		     '">' . $first_page_text . '</a></li>';
	}
	echo '<li class="bpn-prev-link">';
	previous_posts_link( '<<' );
	echo '</li>';
	for ( $i = $start_page; $i <= $end_page; $i ++ ) {
		if ( $i == $paged ) {
			echo '<li class="bpn-current">' . $i . '</li>';
		} else {
			echo '<li><a href="' . get_pagenum_link( $i ) . '">' . $i . '</a></li>';
		}
	}
	echo '<li class="bpn-next-link">';
	next_posts_link( '>>' );
	echo '</li>';
	if ( $end_page < $max_page ) {
		$last_page_text = "Last";
		echo '<li class="bpn-last-page-link"><a href="' . get_pagenum_link( $max_page ) . '" title="' . $last_page_text .
		     '">' . $last_page_text . '</a></li>';
	}
	echo '</ol></nav>' . $after . "";
}

/* end page navi */

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
// debatable if you need this
function starter_filter_ptags_on_images( $content ) {

	return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );

}

wp_enqueue_style( 'customstyles', get_stylesheet_directory_uri() . '/resources/css/index.css' );

@ini_set( 'mysql.trace_mode', 0 );
@error_reporting(E_ALL);
@ini_set('display_errors', 1);


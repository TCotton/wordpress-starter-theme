<?php if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'search.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die( 'Please do not load this page directly. Thanks!' );
}
?>


<?php get_header(); ?>

  <div id="content">

    <div id="inner-content" class="wrap clearfix">

      <div id="main" class="ninecol first clearfix">

        <h1 class="archive-title"><span>Search Results for:</span> <?php echo esc_attr( get_search_query
					() ); ?></h1>

				<?php if ( have_posts() ):
					while ( have_posts() ):
						the_post(); ?>

            <div id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> >

              <div class="article-header">

                <h3 class="search-title"><a href="<?php the_permalink() ?>"
                                            title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

                <p class="meta"><?php echo 'Posted' ?>
                  <time datetime="<?php echo the_time( 'Y-m-j' ); ?>"
                        pubdate><?php the_time( 'F jS, Y' ); ?></time> <?php echo 'by'; ?> <?php the_author_posts_link(); ?>
                  <span class="amp">&</span> <?php echo "filed under"; ?> <?php the_category( ', ' ); ?>.
                </p>

              </div> <!-- end article header -->

              <div class="post-content">
								<?php the_excerpt( '<span class="read-more">Read more &raquo;</span>' ); ?>

              </div> <!-- end article section -->

              <div class="article-footer">

              </div> <!-- end article footer -->

            </div> <!-- end article -->

					<?php endwhile; ?>

					<?php if ( function_exists( 'starter_page_navi' ) ) { // if expirimental feature is active ?>

					<?php starter_page_navi(); // use the page navi function ?>

				<?php } else { // if it is disabled, display regular wp prev & next links ?>
          <nav class="wp-prev-next">
            <ul class="clearfix">
              <li class="prev-link"><?php next_posts_link( _e( '&laquo; Older Entries' ) ) ?></li>
              <li class="next-link"><?php previous_posts_link( _e( 'Newer Entries &raquo;' ) ) ?></li>
            </ul>
          </nav>
				<?php } ?>

				<?php else: ?>

          <div id="post-not-found" class="hentry clearfix">
            <div class="article-header">
              <h1><?php _e( "Sorry, No Results." ); ?></h1>
            </div>
            <div class="post-content">
              <p><?php _e( "UTry your search again." ); ?></p>
            </div>
            <div class="article-footer">
              <p><?php _e( "This is the error message in the search.php template." ); ?></p>
            </div>
          </div>

				<?php endif; ?>

      </div> <!-- end #main -->

			<?php get_sidebar(); // sidebar 1 ?>

    </div> <!-- end #inner-content -->

  </div> <!-- end #content -->

<?php get_footer(); ?>
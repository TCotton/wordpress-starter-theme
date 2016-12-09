<?php if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'single.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die( 'Please do not load this page directly. Thanks!' );
}
?>

<?php get_header(); ?>

<div class="content">
  <div class="inner-content wrap clearfix">
    <div class="main clearfix">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>
          <div class="article-header">
            <h1 class="single-title">
							<?php the_title(); ?>
            </h1>
            <p class="meta"><?php echo 'Posted'; ?>
							<?php the_time( 'F jS, Y' ); ?>
							<?php _e( "by" ); ?>
							<?php the_author_posts_link(); ?>
              <span class="amp">&</span>
							<?php _e( "filed under" ); ?>
							<?php the_category( ', ' ); ?>
              .</p>
          </div>
          <!-- end article header -->

          <div class="post-content clearfix">
						<?php the_content(); ?>
          </div>
          <!-- end article section -->

          <div class="article-footer">
						<?php the_tags( '<p class="tags"><span class="tags-title">Tags:</span> ', ', ', '</p>' ); ?>
          </div>
          <!-- end article footer -->

					<?php comments_template(); // comments should go inside the article element ?>
        </div>
        <!-- end article -->

			<?php endwhile; ?>
			<?php else : ?>
        <div class="post-not-found hentry clearfix">
          <div class="article-header">
            <h1>
							<?php _e( "Oops, Post Not Found!" ); ?>
            </h1>
          </div>
          <div class="post-content">
            <p>
							<?php _e( "Uh Oh. Something is missing. Try double checking things." ); ?>
            </p>
          </div>
          <div class="article-footer">
            <p>
							<?php _e( "This is the error message in the single.php template." ); ?>
            </p>
          </div>
        </div>
			<?php endif; ?>
    </div>
    <!-- end #main -->

		<?php get_sidebar(); // sidebar 1 ?>
  </div>
  <!-- end #inner-content -->

</div>
<!-- end #content -->

<?php get_footer(); ?>

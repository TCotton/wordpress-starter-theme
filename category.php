<?php if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'category.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die( 'Please do not load this page directly. Thanks!' );
}
?>

<?php get_header(); ?>

<div id="content">
  <div id="main" class="clearfix">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <div id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>
        <div class="article-header">
          <h1 class="h2"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
							<?php the_title(); ?>
            </a></h1>
          <p class="meta"><?php echo 'Posted'; ?>
						<?php the_time( get_option( 'date_format' ) ); ?>
						<?php echo 'by'; ?>
						<?php the_author_posts_link(); ?>
            <span class="amp">&</span> <?php echo 'filed under'; ?>
						<?php the_category( ', ' ); ?>
            .</p>
        </div>
        <!-- end article header -->

        <div class="post-content clearfix">
					<?php the_content(); ?>
        </div>
        <!-- end article section -->

        <div class="article-footer">
          <p class="tags">
						<?php the_tags( '<span class="tags-title">Tags:</span> ', ', ', '' ); ?>
          </p>
        </div>
        <!-- end article footer -->

				<?php // comments_template(); // uncomment if you want to use them ?>
      </div>
      <!-- end article -->

		<?php endwhile; ?>
			<?php if ( function_exists( 'starter_page_navi' ) ) { // if experimental feature is active ?>
				<?php starter_page_navi(); // use the page navi function ?>
			<?php } else { // if it is disabled, display regular wp prev & next links ?>
        <nav class="wp-prev-next">
          <ul class="clearfix">
            <li class="prev-link">
							<?php next_posts_link( _e( '&laquo; Older Entries' ) ) ?>
            </li>
            <li class="next-link">
							<?php previous_posts_link( _e( 'Newer Entries &raquo;' ) ) ?>
            </li>
          </ul>
        </nav>
			<?php } ?>
		<?php else : ?>
    <div id="post-not-found" class="clearfix">
      <div class="article-header">
        <h1><?php echo "Oops, Post Not Found!"; ?></h1>
        </header>
        <div class="post-content">
          <p><?php echo "Uh Oh. Something is missing. Try double checking things."; ?></p>
        </div>
        <div class="article-footer">
          <p><?php echo "This is the error message in the index.php template."; ?></p>
        </div>
      </div>
			<?php endif; ?>
    </div>
    <!-- end #main -->

		<?php //get_sidebar(); // sidebar 1 ?>
  </div>
  <!-- end #content -->

	<?php get_footer(); ?>

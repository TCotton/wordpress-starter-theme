<?php get_header() ?>

  <div class="content">

    <div id="post-0" class="post error404 not-found">
      <h2 class="entry-title"><?php echo 'Not Found'; ?></h2>
      <div class="entry-content">
        <p><?php echo 'Apologies, but we were unable to find what you were looking for. Perhaps  searching will help.'; ?></p>
      </div>
      <form class="searchform-404 blog-search" method="get" action="<?php home_url( '/' ); ?>">
        <div>
          <input id="s-404" name="s" class="text" type="text" value="<?php the_search_query() ?>" size="40"/>
          <input class="button" type="submit" value="<?php echo 'Find' ?>"/>
        </div>
      </form>
    </div><!-- .post -->

  </div><!-- #content -->

<?php get_sidebar() ?>
<?php get_footer() ?>
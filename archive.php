<?php get_header(); ?>
			
			<div id="content">
			
				<div id="inner-content" class="wrap clearfix">
				
				    <div id="main" class="clearfix">
				
					    <?php if (is_category()) { ?>
						    <h1 class="archive-title h2">
							    <span><?php echo 'Posts Categorized'; ?></span> <?php single_cat_title(); ?>
					    	</h1>
					    
					    <?php } elseif (is_tag()) { ?> 
						    <h1 class="archive-title h2">
							    <span><?php echo 'Posts Tagged:'; ?></span> <?php single_tag_title(); ?>
						    </h1>
					    
					    <?php } elseif (is_author()) { ?>
						    <h1 class="archive-title h2">
						    	<span><?php echo 'Posts By:'; ?></span> <?php get_the_author_meta('display_name'); ?>
						    </h1>
					    
					    <?php } elseif (is_day()) { ?>
						    <h1 class="archive-title h2">
	    						<span><?php echo 'Daily Archives'; ?></span> <?php the_time('l, F j, Y'); ?>
						    </h1>
		
		    			<?php } elseif (is_month()) { ?>
			    		    <h1 class="archive-title h2">
				    	    	<span><?php echo 'Monthly Archives:' ?></span> <?php the_time('F Y'); ?>
					        </h1>
					
					    <?php } elseif (is_year()) { ?>
					        <h1 class="archive-title h2">
					    	    <span><?php echo 'Yearly Archives:'; ?></span> <?php the_time('Y'); ?>
					        </h1>
					    <?php } ?>

					    <?php if (have_posts()):
    while (have_posts()):
        the_post(); ?>
					
					    <div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
						
						    <div class="article-header">
							
							    <h3 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
							
							    <p class="meta"><?php _e("Posted", "bonestheme"); ?> <time datetime="<?php echo the_time('Y-m-j'); ?>" pubdate><?php the_time('F jS, Y'); ?></time> <?php _e("by",
"bonestheme"); ?> <?php the_author_posts_link(); ?> <span class="amp">&</span> <?php echo 'filed under '; ?> <?php the_category(', '); ?>.</p>
						
						    </div> <!-- end article header -->
					
						    <div class="post-content clearfix">
						
							    <?php the_post_thumbnail('bones-thumb-300'); ?>
						
							    <?php the_excerpt(); ?>
					
						    </div> <!-- end article section -->
						
						    <div class="article-footer">
							
						    </div> <!-- end article footer -->
					
					    </div> <!-- end article -->
					
					    <?php endwhile; ?>	
					
					        <?php if (function_exists('bones_page_navi')) { // if experimental feature is active ?>
						
						        <?php bones_page_navi(); // use the page navi function ?>

					        <?php } else { // if it is disabled, display regular wp prev & next links ?>
						        <nav class="wp-prev-next">
							        <ul class="clearfix">
								        <li class="prev-link"><?php next_posts_link(_e('&laquo; Older Entries')) ?></li>
								        <li class="next-link"><?php previous_posts_link(_e('Newer Entries &raquo;')) ?></li>
							        </ul>
					    	    </nav>
					        <?php } ?>
					
					    <?php else: ?>
					
    					    <div id="post-not-found" class="hentry clearfix">
    						    <div class="article-header">
    							    <h1><?php echo 'Oops, Post Not Found!'; ?></h1>
    					    	</div>
    						    <div class="post-content">
    							    <p><?php echo 'Uh Oh. Something is missing. Try double checking things.'; ?></p>
        						</div>
    	    					<div class="article-footer">
    		    				    <p><?php echo 'This is the error message in the archive.php template.'; ?></p>
    			    			</div>
    				    	</div>
					
					    <?php endif; ?>
			
    				</div> <!-- end #main -->
    
	    			<?php get_sidebar(); // sidebar 1 ?>
                
                </div> <!-- end #inner-content -->
                
			</div> <!-- end #content -->

<?php get_footer(); ?>
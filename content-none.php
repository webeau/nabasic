<?php
/**
 * The template for displaying a "No posts found" message.
 */
?>

	<article id="post-0" class="post no-results not-found clearfix">
    <div class="nerd pull-right"></div>
    <header>
      <h1><?php _e( 'Nothing Found &nbsp;&nbsp;&nbsp; :-(', 'nabasic' ); ?></h1>
    </header>

    <div>
      <p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'nabasic' ); ?></p>
      <?php get_search_form(); ?>
    </div>
	    
	</article><!-- #post-0 -->

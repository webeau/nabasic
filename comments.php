<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to na_comment() which is
 * located in the functions.php file.
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

 // Do not delete these lines
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

 
 
 if ( post_password_required() )
	return;
?>

<section id="comments" class="comments-area">

	<?php if(have_comments()): ?>

    <header>
      <h1><?php

        if(get_theme_mod('display_post_rss_feed',true)) {
          
          echo '<a href="'.get_post_comments_feed_link().'" target="_blank" title="'.__( 'Comment Feed', 'nabasic' ).'"><i class="icon-bullhorn" title="'.__( 'Comment Feed', 'nabasic' ).'"></i> ';
          printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'nabasic' ),
            number_format_i18n(get_comments_number()),'<span>'.get_the_title().'</span>');
          echo '</a>';
        } else {
          printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'nabasic' ),
            number_format_i18n(get_comments_number()),'<span>'.get_the_title().'</span>');
        }

      ?></h1>
    </header>

		<ol class="commentlist">
			<?php wp_list_comments(array('callback' => 'na_comment', 'style' => 'ol')); ?>
		</ol><!-- .commentlist -->

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments') && !get_theme_mod('show_comments_pagination',true)): // are there comments to navigate through ?>
  		<nav id="comment-nav-below" class="navigation" role="navigation">
  			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'nabasic' ); ?></h1>
  			<ul class="pager">
          <li class="previous"><?php previous_comments_link( __( '&larr; Older Comments', 'nabasic' )); ?></li>
          <li class="next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'nabasic' ) ); ?></li>  			  
  			</ul>
  		</nav>
		<?php else: ?>
      <nav id="comment-nav-below" class="pagination" role="navigation">
        <h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'nabasic' ); ?></h1>
        <?php 
          paginate_comments_links(array(
            'type' => 'list'
          )); 
        ?>
      </nav>
    <?php endif; ?>


		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( !comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'nabasic' ); ?></p>
		<?php endif; ?>

	<?php endif; //have_comments() ?>

	<?php comment_form(); ?>

</section><!-- #comments .comments-area -->






















<?php
// link - A link to another site. Themes may wish to use the first <a href=””> tag in the post content as the external link for that post. An alternative approach could be if the post consists only of a URL, then that will be the URL and the title (post_title) will be the name attached to the anchor for it.
// @link: http://codex.wordpress.org/Post_Formats
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
  
  <header>
    <?php if (is_singular()): // single post, page, ... NOT any loop ?> 
      <hgroup>
        <?php
          //show category-name and link IF NOT default category
          $category = get_the_category(); 
          if(!empty($category[0]) && $category[0]->cat_name != get_the_category_by_id(get_option('default_category'))) {
            if(category_description($category[0]->cat_ID)){
              echo '<h2 class="category"><a href="'.get_category_link($category[0]->term_id ).'" title="'.category_description($category[0]->cat_ID).'" class="category">'.$category[0]->cat_name.'</a></h2>';
            } else {
              echo '<h2 class="category"><a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></h2>';
            };
          } elseif(!empty($category[1])) {
            if(category_description($category[1]->cat_ID)){
              echo '<h2 class="category"><a href="'.get_category_link($category[1]->term_id ).'" title="'.category_description($category[1]->cat_ID).'" class="category">'.$category[1]->cat_name.'</a></h2>';
            } else {
              echo '<h2 class="category"><a href="'.get_category_link($category[1]->term_id ).'">'.$category[1]->cat_name.'</a></h2>';
            };
          }
        ?>
        <h1>
          <?php the_title(); na_post_meta_bookmark(); ?>
          <?php if(is_sticky()): ?><span class="status-featured label label-important"><?php _e( 'featured', 'nabasic' ); ?></span><?php endif; ?>
        </h1>      
      </hgroup>
      <?php if (has_post_thumbnail() && !post_password_required()): // check if the post has a Post Thumbnail assigned to it. ?>
        <?php 
          //the_post_thumbnail('large');
          $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
          //echo $large_image_url[0];
        ?>
        <div class="teaserimg" style="background-image:url(<?php echo $large_image_url[0]; ?>)" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"></div>
      <?php endif; ?>
    <?php else: ?>
      <?php if ( has_post_thumbnail() && !post_password_required()): // check if the post has a Post Thumbnail assigned to it. ?>
        <?php 
          //the_post_thumbnail('large');
          $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
          //echo $large_image_url[0];
        ?>
        <a class="teaserimg" style="background-image:url(<?php echo $large_image_url[0]; ?>)" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"></a>
      <?php elseif(getImage('1') && !post_password_required()): ?>
        <a class="teaserimg" style="background-image:url(<?php echo getImage('1'); ?>)" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"></a>
      <?php endif; ?>
      <hgroup>
        <?php
          if(!is_category()) { //if not is category-page
            //show category-name and link IF NOT default category
            $category = get_the_category(); 
            if(!empty($category[0]) && $category[0]->cat_name != get_the_category_by_id(get_option('default_category'))) {
              if(category_description($category[0]->cat_ID)){
                echo '<h2 class="category"><a href="'.get_category_link($category[0]->term_id ).'" title="'.category_description($category[0]->cat_ID).'" class="category">'.$category[0]->cat_name.'</a></h2>';
              } else {
                echo '<h2 class="category"><a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></h2>';
              };
            } elseif(!empty($category[1])) {
              if(category_description($category[1]->cat_ID)){
                echo '<h2 class="category"><a href="'.get_category_link($category[1]->term_id ).'" title="'.category_description($category[1]->cat_ID).'" class="category">'.$category[1]->cat_name.'</a></h2>';
              } else {
                echo '<h2 class="category"><a href="'.get_category_link($category[1]->term_id ).'">'.$category[1]->cat_name.'</a></h2>';
              };
            }            
          }
        ?>
        <h1>
          <a href="<?php echo getLink(1); ?>" target="_blank" title="<?php the_title(); ?> - <?php echo getLink(1); ?>" rel="bookmark">
            <?php _e('Link: ','nabasic').the_title(); ?>
          </a>
          <?php if(is_sticky()): ?><span class="status-featured label label-important"><?php _e( 'featured', 'nabasic' ); ?></span><?php endif; ?>
        </h1>      
      </hgroup>
    <?php endif; ?>
  </header>
  
  <?php if ($wp_query->found_posts == 1 || is_singular()): ?>
    <?php the_content(); ?>
    <?php if(function_exists('enhanced_link_pages')) {
        enhanced_link_pages(array(
          'blink'=>'<li>', 
          'alink'=>'</li>', 
          'before' => '<div class="pagination pagination-right clearfix"><ul><li class="disabled"><a>' . __( 'Pages:', 'nabasic' ) . '</a></li>', 
          'after' => '</ul></div>', 
          'next_or_number' => 'number'
        ));
      } ?>
  <?php elseif (is_search()): ?>
    <?php echo na_the_excerpt('35'); ?>
  <?php else: ?>
    <?php //the_excerpt(); ?>    
  <?php endif; ?>

  <footer class="clearfix">
    
    <?php if ( comments_open() && !is_singular()) : ?>
      <span class="comments-link">
        <?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'nabasic' ) . '</span>', __( '1 Reply', 'nabasic' ), __( '% Replies', 'nabasic' ) ); ?>
      </span><!-- .comments-link -->
    <?php endif; // comments_open() ?>
    <?php 
      if(is_singular()) {
        edit_post_link( __( 'edit', 'nabasic' ), '<i class="icon-pencil" title="'.__( 'edit', 'nabasic' ).'"></i> <span class="edit-link">', '</span>' );
      }
    ?>
    
  </footer>
  
</article>
































<?php
// aside - Typically styled without a title. Similar to a Facebook note update.
// @link: http://codex.wordpress.org/Post_Formats
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
  
  <?php if (is_singular()): // single post, page, ... NOT any loop ?> 
    <header>
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
    </header>

    <?php the_content(); ?>

    <footer class="clearfix">
        <time datetime="<?php the_time( 'c' ); ?>"><?php the_date() ?> - <?php the_time() ?></time>
      <?php 
        if(is_singular()) {
          edit_post_link( __( 'Edit', 'nabasic' ), '<span class="edit-link">', '</span>' );
        }
      ?>
    </footer>

  <?php else: ?>
  <div class="aside">
    
    <header>
      <h1>
        <a href="<?php the_permalink() ?>" rel="bookmark">
          <?php the_title(); ?>
        </a>
      </h1>      
    </header>

    <?php echo na_the_excerpt('135'); ?>

    <footer class="clearfix">
      <time datetime="<?php the_time( 'c' ); ?>"><?php the_date() ?> - <?php the_time() ?></time>
      <?php if ( comments_open() && !is_singular()) : ?>
        <span class="comments-link">
          - <?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'nabasic' ) . '</span>', __( '1 Reply', 'nabasic' ), __( '% Replies', 'nabasic' ) ); ?>
        </span><!-- .comments-link -->
      <?php endif; // comments_open() ?>
      <?php 
        if(is_singular()) {
          edit_post_link( __( 'edit', 'nabasic' ), '<i class="icon-pencil" title="'.__( 'edit', 'nabasic' ).'"></i> <span class="edit-link">', '</span>' );
        }
      ?>
    </footer>
    
  </div>

  <?php endif; ?>
  

</article>
































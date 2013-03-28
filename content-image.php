<?php
// image - A single image. The first <img /> tag in the post could be considered the image. Alternatively, if the post consists only of a URL, that will be the image URL and the title of the post (post_title) will be the title attribute for the image.
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
    <?php else: ?>
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
          <a href="<?php the_permalink() ?>" rel="bookmark">
            <?php the_title(); ?>
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
    <?php if (has_post_thumbnail() && !post_password_required()): // check if the post has a Post Thumbnail assigned to it. ?>
      <?php 
        //the_post_thumbnail('large');
        $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
        //echo $large_image_url[0];
      ?>
      <div class="image-stage">
        <div>
          <a style="background-image:url(<?php echo getImage('1'); ?>" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
            <img src="<?php echo $large_image_url[0]; ?>" />
          </a>
        </div>
      </div>
    <?php elseif(getImage('1') && !post_password_required()): ?>
      <div class="image-stage">
        <div>
          <a style="background-image:url(<?php echo getImage('1'); ?>" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
            <img src="<?php echo getImage('1'); ?>" />
          </a>
        </div>
      </div>
    <?php endif; ?>
    <?php the_excerpt(); ?>    
  <?php endif; ?>

  <footer class="clearfix">
    
    <?php 
      if(is_singular()) {
        edit_post_link( __( 'edit', 'nabasic' ), '<i class="icon-pencil" title="'.__( 'edit', 'nabasic' ).'"></i> <span class="edit-link">', '</span>' );
      }
    ?>
    
  </footer>
  
</article>
































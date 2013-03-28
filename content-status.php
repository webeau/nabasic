<?php
// status - A short status update, similar to a Twitter status update.
// @link: http://codex.wordpress.org/Post_Formats
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

  <?php if (is_singular()): // single post, page, ... NOT any loop ?> 
    <?php if (has_post_thumbnail() && !post_password_required()): // check if the post has a Post Thumbnail assigned to it. ?>
      <?php 
        //the_post_thumbnail('large');
        $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
        //echo $large_image_url[0];
      ?>
      <div class="teaserimg" style="background-image:url(<?php echo $large_image_url[0]; ?>)" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"></div>
    <?php endif; ?>
  <?php endif; ?>

  <?php //if(validate_gravatar(get_the_author_meta( 'user_email' ))): ?>
    <div class="avatar"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'nabasic_status_avatar', '48' ) ); ?></a></div>
  <?php //endif; ?>
  <div class="content">
    <header>
      <span class="author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php the_author() ?></a></span>      
      <time datetime="<?php the_time( 'c' ); ?>"><?php the_date() ?> - <?php the_time() ?></time>
    </header>
    
    <span class="content-text">
      <h1>
        <a href="<?php the_permalink() ?>" rel="bookmark">
          <?php the_title(); na_post_meta_bookmark(); ?>
        </a>
      </h1>      
      <?php if($wp_query->found_posts == 1 || is_singular()) {
        the_content();
      } else {
        echo na_the_excerpt(60); 
      }; ?>
    </span>
  </div>
  

  <footer class="clearfix">
    
    <?php 
      if(is_singular()) {
        edit_post_link( __( 'edit', 'nabasic' ), '<i class="icon-pencil" title="'.__( 'edit', 'nabasic' ).'"></i> <span class="edit-link">', '</span>' );
      }
    ?>
    
  </footer>
  
</article>
































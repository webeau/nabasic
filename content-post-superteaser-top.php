<?php 
  // @link http://codex.wordpress.org/Function_Reference/post_class#Adding_More_Classes
  $classes = array(
    'clearfix',
    'highlight-first',
    'superteaser-top'
  ); 
  if($na_postcount) $classes[] = 'post-no'.$na_postcount;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
  
  <header>
    <hgroup>
      <?php 
        if(!is_category()) {
          //show category-name and link IF NOT default category
          $category = get_the_category(); 
          if(!empty($category[0]) && $category[0]->cat_name != get_the_category_by_id(get_option('default_category'))) {
            if(category_description($category[0]->cat_ID)){
              echo '<h2 class="category"><a href="'.get_category_link($category[0]->term_id ).'" title="'.category_description($category[0]->cat_ID).'" class="category">'.$category[0]->cat_name.'</a></h2>';
            } else {
              echo '<h2 class="category"><a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></h2>';
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
    <?php if(has_post_thumbnail() && !post_password_required() ): // check if the post has a Post Thumbnail assigned to it. ?>
      <?php 
        //the_post_thumbnail('large');
        $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
        //echo $large_image_url[0];
      ?>
      <a class="teaserimg" style="background-image: url(<?php echo $large_image_url[0]; ?>)" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"></a>
    <?php elseif(getImage('1') && !post_password_required() ): ?>
      <a class="teaserimg" style="background-image:url(<?php echo getImage('1'); ?>)" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"></a>
    <?php endif; ?>
  </header>
  
</article>

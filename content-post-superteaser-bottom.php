<?php 
  // @link http://codex.wordpress.org/Function_Reference/post_class#Adding_More_Classes
  $classes = array(
    'clearfix',
    'highlight-first',
    'superteaser-bottom'
  ); 
  if($na_postcount) $classes[] = 'post-no'.$na_postcount;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
  
  <?php if ($wp_query->found_posts == 1 && !get_theme_mod('show_categorized_blog')): ?>
    <?php the_content(); ?>
  <?php else: ?>
    <?php the_excerpt(); ?>    
  <?php endif; ?>

</article>

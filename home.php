<?php 
if(!get_theme_mod('show_categorized_blog')) {
  get_template_part( 'index' );
} else {
  
get_header(); ?>

          <?php
            $sidebar1 = false;
            $sidebar3 = false;
            switch (get_theme_mod('default_structure')) {
                  case '23':  $structure = 'na-column23';   $sidebar3 = true; break;
                  case '32':  $structure = 'na-column32';   $sidebar3 = true; break;
                  case '2':   $structure = 'na-column2';    break;
                  case '123': $structure = 'na-column123';  $sidebar1 = true;   $sidebar3 = true; break;
                  case '12':  $structure = 'na-column12';   $sidebar1 = true; break;
                  case '21':  $structure = 'na-column21';   $sidebar1 = true; break;
                  default:    $structure = 'na-column23';   $sidebar1 = false;  $sidebar3 = true; break;
            }
          ?>          
          
          <?php
            if(get_theme_mod('default_amount_of_featured_posts') !== false): 
              $numberhighlightposts = get_theme_mod('default_amount_of_featured_posts');
            else: 
              $numberhighlightposts = '3';
            endif;
            if(get_theme_mod('show_superteaser',true) && $numberhighlightposts != '0') {
              $args = array(
                'posts_per_page'    => '1',
                'ignore_sticky_posts' => true,
              );
                          
              // The Query
              $pre_query = new WP_Query( $args );
              
              // The Loop
              while ( $pre_query->have_posts() ) :
                $pre_query->the_post();
                if(!is_singular() && !is_paged() && !get_post_format() && has_post_thumbnail()) {
                  echo '<div class="supterteaser-'.$structure.'">';
                    get_template_part( 'content', 'post-superteaser-top' );
                  echo '</div>';
                } elseif(!is_singular() && !is_paged() && get_post_format() == 'gallery') {
                  echo '<div class="supterteaser-'.$structure.'">';
                    get_template_part( 'content', 'post-superteaser-top-gallery' );
                  echo '</div>';
                }
              endwhile;
              
              /* Restore original Post Data 
               * NB: Because we are using new WP_Query we aren't stomping on the 
               * original $wp_query and it does not need to be reset.
              */
              wp_reset_postdata();
            }            
          ?>

          <div class="<?php echo $structure ?>">
            
            <?php if($sidebar1 != false): ?>
              <div class="na-col1">
                <div class="na-cbox" role="complementary">
                  <?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
                    <?php get_sidebar('left'); ?>
                  <?php endif; ?>
                </div><?php // .na-cbox ?>
              </div><?php // .na-col1 ?>
            <?php endif; ?>


            <div class="na-col2">
              <section id="content" class="na-cbox clearfix categorized" role="main">
                
<?php

$category_ids = get_all_category_ids();
$category__in = $category_ids;
$post__not_in = array();
$postcount = 0; //count posts for featuring
$catcount = 0; //count categories
$max_categoies = get_theme_mod('max_no_categories'); //max categories to display
foreach($category_ids as $cat_id) {
  $catcount++;
  if($max_categoies >= $catcount) {
    $args = array(
      'posts_per_page'    => '1',
      'ignore_sticky_posts' => true,
      'category__in' => $category__in,
      'post__not_in' => $post__not_in,
    );
    query_posts( $args );
  
    if (have_posts()) :
      echo '<section>';
      while ( have_posts() ) : the_post(); // The Loop
        echo '<article>';
        $postcount++;
        $category = get_the_category();
        foreach($category as $postcat) {
          $cat = $postcat->cat_ID;
          if(array_search($postcat->cat_ID,$category__in) !== false) {
            $parent_cat_ID = $postcat->cat_ID;
            $pos=array_search($parent_cat_ID,$category__in);
            unset($category__in[$pos]);
            break;
          };
        }
    
        if($postcount <= $numberhighlightposts && $postcount == '1' && !is_singular() && !is_paged() && !get_post_format() && has_post_thumbnail() && get_theme_mod('show_superteaser',true)) {
          get_template_part( 'content', 'post-superteaser-bottom' );
        } elseif($postcount <= $numberhighlightposts && $postcount == '1' && !is_singular() && !is_paged() && get_post_format() == 'gallery' && has_post_thumbnail() && get_theme_mod('show_superteaser',true)) {
          get_template_part( 'content', 'post-superteaser-bottom' );
        } elseif($postcount <= $numberhighlightposts && $postcount == '1' && !get_post_format() && has_post_thumbnail()) {
          echo '<header><h2 class="category"><a href="'.get_category_link($parent_cat_ID).'">'.get_cat_name($parent_cat_ID).'</a></h2></header>';
          get_template_part( 'content', 'post-highlight-first' );
        } elseif($postcount <= $numberhighlightposts && !get_post_format()) {
          echo '<header><h2 class="category"><a href="'.get_category_link($parent_cat_ID).'">'.get_cat_name($parent_cat_ID).'</a></h2></header>';
          get_template_part( 'content', 'post-highlight' );
        } else {
          echo '<header><h2 class="category"><a href="'.get_category_link($parent_cat_ID).'">'.get_cat_name($parent_cat_ID).'</a></h2></header>';
          get_template_part( 'content', get_post_format() );
        };
        array_push($post__not_in, get_the_ID());
        
        echo '</article>';
      endwhile;
      wp_reset_query(); // Reset Query
      
    // ------------- subloop start -------------
      
      $args = array(
        'posts_per_page'    => '4',
        'ignore_sticky_posts' => true,
        'category__in' => $parent_cat_ID,
        'post__not_in' => $post__not_in,
      );
      query_posts( $args );
      
      if (have_posts()) :
        echo '
          <section class="category-articles">
          <h2 class="assistive-text" title="'.__('Further articles in this category','nabasic').'"><a href="'.get_category_link($parent_cat_ID).'">'.get_cat_name($parent_cat_ID).'</a></h2>
          <ul>
          ';
        while ( have_posts() ) : the_post(); // The Loop
      
            ?><li>
                <a href="<?php the_permalink() ?>" rel="bookmark">
                  <?php the_title(); ?>:
                </a>
                <a class="excerpt" href="<?php the_permalink() ?>" rel="bookmark">
                  <span class="excerpt"><?php echo na_the_excerpt('15',false); ?></span>
                </a>
              </li><?php
          array_push($post__not_in, get_the_ID());
          
        endwhile;
        
        echo '</ul></section>';
      endif;
    
    // ------------- subloop end -------------
      echo '</section>';
    endif;
    wp_reset_query(); // Reset Query
  }
}

?>
                
              </section><?php // #content.na-cbox ?>
            </div><?php // .na-col2 ?>
            

            <?php if($sidebar3 != false): ?>
              <div class="na-col3">
                <div class="na-cbox" role="complementary">
                  <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
                    <?php get_sidebar(); ?>
                  <?php endif; ?>
                </div><?php // .na-cbox ?>
              </div><?php // .na-col3 ?>
            <?php endif; ?>

          </div><?php // .na-column23 ?>
          
<?php get_footer(); }?>
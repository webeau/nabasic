<?php get_header(); ?>

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
              <section id="content" class="na-cbox clearfix" role="main">
                
                <?php if (have_posts()) : ?>
                  <?php 
                    $postcount = 0;
                  ?>
                  <?php while (have_posts()) : the_post(); ?>
                    <?php 
                      $postcount++;
                      // @link http://wordpress.stackexchange.com/a/78705
                      $wp_query->query_vars['na_postcount'] = $postcount;
                      if($postcount <= $numberhighlightposts && $postcount == '1' && !is_singular() && !is_paged() && !get_post_format() && has_post_thumbnail() && get_theme_mod('show_superteaser',true)) {
                        get_template_part( 'content', 'post-superteaser-bottom' );
                      } elseif($postcount <= $numberhighlightposts && $postcount == '1' && !is_singular() && !is_paged() && !get_post_format()) {
                        get_template_part( 'content', 'post-highlight-first' );
                      } elseif($postcount <= $numberhighlightposts && !is_singular() && !is_paged() && !get_post_format()) {
                        get_template_part( 'content', 'post-highlight' );
                      } else {
                        get_template_part( 'content', get_post_format() );
                      } ?>

                  <?php endwhile; ?>
                
                  <?php 
                    if(get_theme_mod('show_index_pagination')):
                      get_pagination(); 
                    else:
                      na_pager(); 
                    endif;
                  ?>
                  
                <?php else : ?>
                  
                  <?php get_template_part( 'content', 'none' ); ?>
                
                <?php endif; ?>
                
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
          
<?php get_footer(); ?>
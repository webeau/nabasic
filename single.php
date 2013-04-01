<?php get_header(); ?>

          <?php
            $sidebar1 = false;
            $sidebar3 = false;
            if (get_theme_mod('change_single_structure')) {
              switch (get_theme_mod('single_structure')) {
                  case '23':  $structure = 'na-column23';   $sidebar3 = true; break;
                  case '32':  $structure = 'na-column32';   $sidebar3 = true; break;
                  case '2':   $structure = 'na-column2';    break;
                  case '123': $structure = 'na-column123';  $sidebar1 = true; $sidebar3 = true; break;
                  case '12':  $structure = 'na-column12';   $sidebar1 = true; break;
                  case '21':  $structure = 'na-column21';   $sidebar1 = true; break;
                  default:    $structure = 'na-column23';   $sidebar1 = false;  $sidebar3 = true; break;
              }
            } else {
              switch (get_theme_mod('default_structure')) {
                  case '23':  $structure = 'na-column23';   $sidebar3 = true; break;
                  case '32':  $structure = 'na-column32';   $sidebar3 = true; break;
                  case '2':   $structure = 'na-column2';    break;
                  case '123': $structure = 'na-column123';  $sidebar1 = true; $sidebar3 = true; break;
                  case '12':  $structure = 'na-column12';   $sidebar1 = true; break;
                  case '21':  $structure = 'na-column21';   $sidebar1 = true; break;
                  default:    $structure = 'na-column23';   $sidebar1 = false;  $sidebar3 = true; break;
              }
            }
          ?>          

          <?php 
            while (have_posts()) : the_post();
              if(is_singular() && has_post_thumbnail() && !get_post_format() && get_theme_mod('show_superteaser',true)) {
                echo '<div class="supterteaser-'.$structure.'">';
                  get_template_part( 'content', 'single-superteaser-top' );
                echo '</div>';
              } elseif(is_singular() && get_post_format() == 'gallery' && get_theme_mod('show_superteaser',true)) {
                echo '<div class="supterteaser-'.$structure.'">';
                  get_template_part( 'content', 'single-superteaser-top-gallery' );
                echo '</div>';
              }
            endwhile; 
          ?>


          <div class="<?php echo $structure ?>">

            <?php if($sidebar1 != false): ?>
              <div class="na-col1">
                <div class="na-cbox" role="complementary">
                  <?php 
                    if(is_active_sidebar( 'sidebar-one-single' )) :
                      get_sidebar('one-single'); 
                    elseif(is_active_sidebar( 'sidebar-2' )) :
                      get_sidebar('left');
                    endif;
                  ?>
                </div><?php // .na-cbox ?>
              </div><?php // .na-col1 ?>
            <?php endif; ?>


            <div class="na-col2">
              <section id="content" class="na-cbox clearfix" role="main">
                
                <?php while (have_posts()) : the_post(); ?>

                  <?php if (get_theme_mod('display_post_navi_top')): ?>
                    <nav class="nav-single top">
                      <h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
                      <ul class="pager">
                        <li class="previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?></li>
                        <li class="next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></li>
                      </ul>
                    </nav>
                  <?php endif; ?>

                  <?php get_template_part( 'content', get_post_format() ); na_post_meta(); ?>
                  <!--
                  <?php trackback_rdf(); ?>
                  -->


                  
                  <?php if (get_theme_mod('display_post_navi_bottom')): ?>
                    <nav class="nav-single bottom">
                      <h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
                      <ul class="pager">
                        <li class="previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?></li>
                        <li class="next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></li>
                      </ul>
                    </nav>
                  <?php endif; ?>
                  
                  <?php comments_template( '', true ); ?>
                  
                <?php endwhile; ?>
              
              </section><?php // #content.na-cbox ?>
            </div><?php // .na-col2 ?>
            

            <?php if($sidebar3 != false): ?>
              <div class="na-col3">
                <div class="na-cbox" role="complementary">
                    
                    <?php
                      /**
                       * @link http://www.hongkiat.com/blog/wordpress-related-posts-without-plugins/
                       */
                      $orig_post = $post;
                      global $post;
                      $tags = wp_get_post_tags($post->ID);
                    
                      if ($tags) {
                        $tag_ids = array();
                        foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
                        $args=array(
                          'tag__in' => $tag_ids,
                          'post__not_in' => array($post->ID),
                          'posts_per_page'=>4, // Number of related posts to display.
                          'caller_get_posts'=>1
                        );
                        
                        $my_query = new wp_query( $args );
                        if ( $my_query->have_posts() ) : 
                          echo '<aside class="widget relatedposts"><h3>'.__('Related posts','nabasic').'</h3><ul>';
                          while( $my_query->have_posts() ) {
                            $my_query->the_post();
                            ?>
                              <li>
                                <a rel="external" href="<? the_permalink()?>"><?php the_title(); ?></a>
                              </li>
                          <? }
                          echo '</ul></aside>';
                        endif;
                      }
                      $post = $orig_post;
                      wp_reset_query();
                    ?>
                    
                    <?php 
                      if(is_active_sidebar( 'sidebar-three-single' )) :
                        get_sidebar('three-single'); 
                      elseif(is_active_sidebar( 'sidebar-1' )) :
                        get_sidebar();
                      endif;
                    ?>
                </div><?php // .na-cbox ?>
              </div><?php // .na-col3 ?>
            <?php endif; ?>

          </div><?php // .na-column23 ?>
          
<?php get_footer(); ?>
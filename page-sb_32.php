<?php
/**
 * Template Name: Left Sidebar Template (32)
 * Description: A Page Template that adds a left sidebar to pages for additional content
 */

get_header(); ?>

          <div class="na-column32">

            <div class="na-col2">
              <section id="content" class="na-cbox clearfix" role="main">
                
                  <?php while (have_posts()) : the_post(); ?>
                    
                    <?php get_template_part( 'content', 'page' ); ?>
                    <!--
                    <?php trackback_rdf(); ?>
                    -->
                    <?php comments_template( '', true ); ?>
                    
                  <?php endwhile; ?>
                
              </section><?php // #content.na-cbox ?>
            </div><?php // .na-col2 ?>
            

            <div class="na-col3">
              <div class="na-cbox" role="complementary">
                  <?php 
                    if(is_active_sidebar( 'sidebar-three-page' )) :
                      get_sidebar('three-page'); 
                    elseif(is_active_sidebar( 'sidebar-1' )) :
                      get_sidebar();
                    endif;
                  ?>
              </div><?php // .na-cbox ?>
            </div><?php // .na-col3 ?>

          </div><?php // .na-column23 ?>
          
<?php get_footer(); ?>
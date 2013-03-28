<?php
/**
 * Template Name: Template without Sidebar (2)
 * Description: A Page Template without sidebars
 */

get_header(); ?>

          <div class="na-column2">

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

          </div><?php // .na-column23 ?>
          
<?php get_footer(); ?>
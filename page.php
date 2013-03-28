<?php get_header(); ?>

          <?php
            $sidebar1 = false;
            $sidebar3 = false;
            if (get_theme_mod('change_page_structure')) {
              switch (get_theme_mod('page_structure')) {
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
          <div class="<?php echo $structure ?>">

            <?php if($sidebar1 != false): ?>
              <div class="na-col1">
                <div class="na-cbox" role="complementary">
                  <?php 
                    if(is_active_sidebar( 'sidebar-one-page' )) :
                      get_sidebar('one-page'); 
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
                    
                    <?php get_template_part( 'content', 'page' ); ?>
                    <!--
                    <?php trackback_rdf(); ?>
                    -->
                    <?php comments_template( '', true ); ?>
                    
                  <?php endwhile; ?>
                
              </section><?php // #content.na-cbox ?>
            </div><?php // .na-col2 ?>
            

            <?php if($sidebar3 != false): ?>
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
            <?php endif; ?>

          </div><?php // .na-column23 ?>
          
<?php get_footer(); ?>
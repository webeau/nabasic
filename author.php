<?php get_header(); ?>

          <?php
            $sidebar1 = false;
            $sidebar3 = false;
            switch (get_theme_mod('default_structure')) {
                  case '23':  $structure = 'na-column23';   $sidebar3 = true; break;
                  case '32':  $structure = 'na-column32';   $sidebar3 = true; break;
                  case '2':   $structure = 'na-column2';    break;
                  case '123': $structure = 'na-column123';  $sidebar1 = true; $sidebar3 = true; break;
                  case '12':  $structure = 'na-column12';   $sidebar1 = true; break;
                  case '21':  $structure = 'na-column21';   $sidebar1 = true; break;
                  default:    $structure = 'na-column23';   $sidebar1 = false;  $sidebar3 = true; break;
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
                    /* Queue the first post, that way we know
                     * what author we're dealing with (if that is the case).
                     *
                     * We reset this later so we can run the loop
                     * properly with a call to rewind_posts().
                     */
                    the_post();
                  ?>

                  <header>
                    <hgroup class="clearfix">
                      <div class="author-avatar">
                        <?php echo get_avatar(get_the_author_meta('ID'), apply_filters('twentytwelve_author_bio_avatar_size', 60 )); ?>
                      </div>
                      <h1>
                        <?php 
                          //echo '<a class="url fn n" href="'.esc_url(get_author_posts_url(get_the_author_meta( "ID" ))).'" rel="me">'.get_the_author().'</a>'; 
                          echo get_the_author();
                        ?>
                      </h1>
                      <?php if(get_the_author_meta('description')): ?>
                        <h2><?php the_author_meta('description'); ?></h2>
                      <?php endif; ?>
                    </hgroup>
                  </header>
                
                  <?php
                    /* Since we called the_post() above, we need to
                     * rewind the loop back to the beginning that way
                     * we can run the loop properly, in full.
                     */
                    rewind_posts();
                  ?>

                  <?php 
                    $postcount = 0;
                    $numberhighlightposts = get_theme_mod('default_amount_of_featured_posts');
                  ?>
                  <?php while (have_posts()) : the_post(); ?>
                    <?php 
                      $postcount++;
                      // @link http://wordpress.stackexchange.com/a/78705
                      $wp_query->query_vars['na_postcount'] = $postcount;
                      if($postcount <= $numberhighlightposts && $postcount == '1' && !is_singular() && !is_paged()) {
                        get_template_part( 'content', 'post-highlight-first' );
                      } elseif($postcount <= $numberhighlightposts && !is_singular() && !is_paged()) {
                        get_template_part( 'content', 'post-highlight' );
                      } else {
                        get_template_part( 'content', get_post_format() );
                      } ?>
                
                  <?php endwhile; ?>
                
                  <?php na_pager(); ?>
                 
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
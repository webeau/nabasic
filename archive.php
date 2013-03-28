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
                
                <header>
                  <hgroup>
                    <h1>
                      <?php
                        if(is_day()) {
                          $day = get_the_time( 'd' );
                          $year = get_the_time( 'Y' );
                          $month = get_the_time( 'm' );
                          $dailyarchivelink = '<a href="'.get_day_link( $year, $month, $day ).'" title="'.sprintf(__( 'Go to archive for %s', 'nabasic' ),get_the_date(_x('d.F Y','daily archives date format','nabasic'))).'">'.get_the_time(_x('d','daily archives link format','nabasic')).'</a>';
                          $monthlyarchivelink =  '<a href="'.get_month_link($year,$month).'" title="'.sprintf(__( 'Go to archive for %s', 'nabasic' ),get_the_date(_x('F Y','monthly archives date format','nabasic'))).'">'.get_the_time(_x('F','monthly archives link format','nabasic')).'</a>';
                          $annualarchivelink =  '<a href="'.get_year_link($year).'" title="'.sprintf(__( 'Go to archive for %s', 'nabasic' ),get_the_date(_x('Y','yearly archives date format','nabasic'))).'">'.get_the_time(_x('Y','yearly archives link format','nabasic')).'</a>';
                          printf( __( 'Archive for %1$s.%2$s %3$s', 'nabasic' ),  get_the_time(_x('d','daily archives link format','nabasic')), $monthlyarchivelink, $annualarchivelink);
                        } elseif (is_month()) {
                          $year = get_the_time( 'Y' );
                          $month = get_the_time( 'm' );
                          $monthlyarchivelink =  '<a href="'.get_month_link($year,$month).'" title="'.sprintf(__( 'Go to archive for %s', 'nabasic' ),get_the_date(_x('F Y','monthly archives date format','nabasic'))).'">'.get_the_time(_x('F','monthly archives link format','nabasic')).'</a>';
                          $annualarchivelink =  '<a href="'.get_year_link($year).'" title="'.sprintf(__( 'Go to archive for %s', 'nabasic' ),get_the_date(_x('Y','yearly archives date format','nabasic'))).'">'.get_the_time(_x('Y','yearly archives link format','nabasic')).'</a>';
                          printf( __( 'Archive for %1$s %2$s', 'nabasic' ),  get_the_time(_x('F','monthly archives link format','nabasic')), $annualarchivelink);
                        } elseif (is_year()) {
                          $year = get_the_time( 'Y' );
                          $annualarchivelink =  '<a href="'.get_year_link($year).'" title="'.sprintf(__( 'Go to archive for %s', 'nabasic' ),get_the_date(_x('Y','yearly archives date format','nabasic'))).'">'.get_the_time(_x('Y','yearly archives link format','nabasic')).'</a>';
                          printf( __( 'Archive for %1$s', 'nabasic' ), get_the_time(_x('Y','yearly archives link format','nabasic')));
                        } else {
                          _e( 'Archives', 'nabasic' );
                        }
                      ?>
                    </h1>
                  </hgroup>
                </header>

                <?php if (have_posts()) : ?>
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
                    <!--
                    <?php trackback_rdf(); ?>
                    -->
                
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
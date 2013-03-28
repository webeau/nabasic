<?php
/**
 * The template for displaying 404 pages (Not Found).
 */
//http://archgfx.net/blog/2007/geek/blogging/adding-search-results-to-wordpress-404-pages
$search_term = substr($_SERVER['REQUEST_URI'],1);
$search_term = urldecode(stripslashes($search_term));
$find = array ("'.html'", "'.+/'", "'[-/_]'") ;
$replace = " " ;
$search_term = trim(preg_replace ( $find , $replace , $search_term ));
$search_term_q = preg_replace('/ /', '%20', $search_term);

get_header();

// run the url as a query
query_posts('s='. $search_term_q );
?>

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
                <div class="nerd pull-right"></div>
                <header>
                  <hgroup>
                    <h1><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'nabasic' ); ?></h1>
                    <h2><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'nabasic' ); ?></h2>
                    <?php get_search_form(); ?>
                  </hgroup>
                </header>



                <?php if (have_posts()) : ?>
                  <div class="alert alert-info">
                    <?php _e( 'You might have been looking for these posts', 'nabasic' ); ?>
                  </div>
                  <?php 
                    $postcount = 0;
                    $numberhighlightposts = get_theme_mod('default_amount_of_featured_posts');
                    $highlightposts = 0;
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
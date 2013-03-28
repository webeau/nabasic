<?php get_header(); ?>

          <?php
            if (get_theme_mod('change_image_structure')) {
              switch (get_theme_mod('image_structure')) {
                  case '23':  $structure = 'na-column23';   $sidebar3 = true; break;
                  case '32':  $structure = 'na-column32';   $sidebar3 = true; break;
                  case '2':   $structure = 'na-column2';    break;
                  case '123': $structure = 'na-column123';  $sidebar1 = true; $sidebar3 = true; break;
                  case '12':  $structure = 'na-column12';   $sidebar1 = true; break;
                  case '21':  $structure = 'na-column21';   $sidebar1 = true; break;
              }
            } else {
              switch (get_theme_mod('default_structure')) {
                  case '23':  $structure = 'na-column23';   $sidebar3 = true; break;
                  case '32':  $structure = 'na-column32';   $sidebar3 = true; break;
                  case '2':   $structure = 'na-column2';    break;
                  case '123': $structure = 'na-column123';  $sidebar1 = true; $sidebar3 = true; break;
                  case '12':  $structure = 'na-column12';   $sidebar1 = true; break;
                  case '21':  $structure = 'na-column21';   $sidebar1 = true; break;
              }
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
              <section id="content" class="na-cbox clearfix image" role="main">
<!-- image -->
                <?php while ( have_posts() ) : the_post(); ?>
            
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'image-attachment' ); ?>>

                      <header>
                        <nav><?php printf( __('<nav><a href="%2$s" title="Back to the post %1$s"><i class="icon-arrow-left"></i> Back to the post "%3$s"</a></nav>', 'nabasic'),
                          esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
                          esc_url( get_permalink( $post->post_parent ) ),
                          get_the_title( $post->post_parent )
                        ); ?></nav>
                        <h1 class="assistive-text"><?php the_title(); ?></h1>
                        <nav id="image-navigation" class="navigation" role="navigation">
                          <ul class="pager">
                            <li class="previous"><?php previous_image_link( false, __( '&larr; Previous', 'nabasic' ) ); ?></li>
                            <li class="next"><?php next_image_link( false, __( 'Next &rarr;', 'nabasic' ) ); ?></li>
                          </ul>
                        </nav>
                      </header>
            
                      <div class="image-frame clearfix">
                        <div class="image-stage">
<?php
/**
 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
 */
$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
foreach ( $attachments as $k => $attachment ) :
  
  if ( $attachment->ID == $post->ID )
    break;
endforeach;

$k++;
// If there is more than 1 attachment in a gallery
if ( count( $attachments ) > 1 ) :
  if ( isset( $attachments[ $k ] ) ) :
    // get the URL of the next image attachment
    $next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
  else :
    // or get the URL of the first image attachment
    $next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
  endif;
else :
  // or, if there's only 1 image, get the URL of the image
  $next_attachment_url = wp_get_attachment_url();
endif;
?>
                          <div>
                            <a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php
                            $attachment_size = apply_filters( 'na_attachment_size', array( 1400, 1400 ) );
                            echo wp_get_attachment_image( $post->ID, $attachment_size );
                            ?></a>
                            <aside>
                              <?php if(get_edit_post_link()){
                                  printf(__('<a href="%1$s" title="Edit image %2$s" class="edit-link"><i class="icon-pencil"></i></a>','nabasic'),
                                    get_edit_post_link(),
                                    get_the_title()
                                ); };
                                $metadata = wp_get_attachment_metadata();
                                printf(__('<a href="%1$s" target="_blank" title="Full-size image %2$s - %3$s x %4$s" class="edit-link"><i class="icon-download-alt"></i></a>','nabasic'),
                                  esc_url( wp_get_attachment_url() ),
                                  get_the_title(),
                                  $metadata['width'],
                                  $metadata['height']                              
                                ); ?>
                            </aside>                          
                          </div>

  <?php
   // foreach ( $attachments as $attachment ) : echo get_attachment_link( $attachment->ID ).'<br>'; endforeach;
  ?>
         
                        </div><!-- .image-stage -->
                        <div class="caption">
                          <?php printf( __( '<time datetime="%1$s">%2$s</time>', 'nabasic' ),
                              esc_attr( get_the_date( 'c' ) ),
                              esc_html( get_the_date() )
                          );?>
                          <?php if ( ! empty( $post->post_excerpt ) ) : ?>
                            <?php the_excerpt(); ?>
                          <?php endif; ?>
                        </div>
                      </div><!-- .image-frame -->
            
                        <div class="description">
                          <?php the_content(); ?>
                          <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'nabasic' ), 'after' => '</div>' ) ); ?>
                        </div><!-- .description -->
            
                    </article><!-- #post -->
            
                    <?php comments_template(); ?>
            
                  <?php endwhile; // end of the loop. ?>
<!-- image end -->
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
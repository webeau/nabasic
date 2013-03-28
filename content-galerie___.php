<?php
// gallery - A gallery of images. Post will likely contain a gallery shortcode and will have image attachments.
// @link: http://codex.wordpress.org/Post_Formats
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
  
  <header>
    <?php if (is_singular()): // single post, page, ... NOT any loop ?> 
      <hgroup>
        <?php
          //show category-name and link IF NOT default category
          $category = get_the_category(); 
          if(!empty($category[0]) && $category[0]->cat_name != get_the_category_by_id(get_option('default_category'))) {
            if(category_description($category[0]->cat_ID)){
              echo '<h2 class="category"><a href="'.get_category_link($category[0]->term_id ).'" title="'.category_description($category[0]->cat_ID).'" class="category">'.$category[0]->cat_name.'</a></h2>';
            } else {
              echo '<h2 class="category"><a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></h2>';
            };
          } elseif(!empty($category[1])) {
            if(category_description($category[1]->cat_ID)){
              echo '<h2 class="category"><a href="'.get_category_link($category[1]->term_id ).'" title="'.category_description($category[1]->cat_ID).'" class="category">'.$category[1]->cat_name.'</a></h2>';
            } else {
              echo '<h2 class="category"><a href="'.get_category_link($category[1]->term_id ).'">'.$category[1]->cat_name.'</a></h2>';
            };
          }
        ?>
        <h1>
          <?php the_title(); na_post_meta_bookmark(); ?>
          <?php if(is_sticky()): ?><span class="status-featured label label-important"><?php _e( 'featured', 'nabasic' ); ?></span><?php endif; ?>
        </h1>      
      </hgroup>
        <?php
          $images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
          if ( $images ) : {
            ?>
            <div id="galleryCarousel-<?php echo $post->ID; ?>" class="carousel slide" data-interval="5000">
              <ol class="carousel-indicators">
                <?php 
                  $counter = 0;
                  foreach ( $images as $image ) : {
                    echo '<li data-target="#myCarousel" data-slide-to="'.$counter.'"';
                    if($counter == 0) : echo ' class="active"'; endif;
                    echo '></li>';
                    $counter++;
                  } endforeach;
                ?>
              </ol>
              <!-- Carousel items -->
              <div class="carousel-inner">
                <?php 
                  $counter = 0;
                  foreach ( $images as $image ) : {
                    $alt = get_post_meta($image->ID, '_wp_attachment_image_alt', true);
                    $image_title = $image->post_title;
                    $caption = $image->post_excerpt;
                    $description = $image->post_content;
                    echo '<a class="item';
                    if($counter == 0) : echo " active"; endif;
                    echo '" href="'.get_attachment_link( $image->ID ).'">';
                    //echo '<img alt="" src="'.wp_get_attachment_url( $image->ID ).'">';
                    echo wp_get_attachment_image( $image->ID, 'content-thumb' );
                    if ( $caption /*|| $description*/ ) :
                      echo '<div class="carousel-caption">';
                        echo '<h4>'.$image_title.'</h4>';
                        echo '<p>'.$caption.'</p>';
                        //echo '<p>'.$description.'</p>';
                      echo '</div>';
                    endif;
                    echo '</a>';
                    $counter++;
                  } endforeach;
                ?>
              </div>
              <!-- Carousel nav -->
              <a class="carousel-control left" href="#galleryCarousel-<?php echo $post->ID; ?>" data-slide="prev">&lsaquo;</a>
              <a class="carousel-control right" href="#galleryCarousel-<?php echo $post->ID; ?>" data-slide="next">&rsaquo;</a>
            </div>
            
            <?php
          } endif; ?>
    <?php else: ?>
      <hgroup>
        <?php
          if(!is_category()) { //if not is category-page
            //show category-name and link IF NOT default category
            $category = get_the_category(); 
            if(!empty($category[0]) && $category[0]->cat_name != get_the_category_by_id(get_option('default_category'))) {
              if(category_description($category[0]->cat_ID)){
                echo '<h2 class="category"><a href="'.get_category_link($category[0]->term_id ).'" title="'.category_description($category[0]->cat_ID).'" class="category">'.$category[0]->cat_name.'</a></h2>';
              } else {
                echo '<h2 class="category"><a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></h2>';
              };
            } elseif(!empty($category[1])) {
              if(category_description($category[1]->cat_ID)){
                echo '<h2 class="category"><a href="'.get_category_link($category[1]->term_id ).'" title="'.category_description($category[1]->cat_ID).'" class="category">'.$category[1]->cat_name.'</a></h2>';
              } else {
                echo '<h2 class="category"><a href="'.get_category_link($category[1]->term_id ).'">'.$category[1]->cat_name.'</a></h2>';
              };
            }            
          }
        ?>
        <h1>
          <a href="<?php the_permalink() ?>" rel="bookmark">
            <?php the_title(); ?>
          </a>
          <?php if(is_sticky()): ?><span class="status-featured label label-important"><?php _e( 'featured', 'nabasic' ); ?></span><?php endif; ?>
        </h1>      
      </hgroup>
    <?php endif; ?>
  </header>
  
  <?php if ($wp_query->found_posts == 1 || is_singular()): ?>
    <?php the_content(); ?>
    <?php if(function_exists('enhanced_link_pages')) {
        enhanced_link_pages(array(
          'blink'=>'<li>', 
          'alink'=>'</li>', 
          'before' => '<div class="pagination pagination-right clearfix"><ul><li class="disabled"><a>' . __( 'Pages:', 'nabasic' ) . '</a></li>', 
          'after' => '</ul></div>', 
          'next_or_number' => 'number'
        ));
      } ?>
  <?php elseif (is_search()): ?>
    <?php echo na_the_excerpt('35'); ?>
  <?php else: ?>
      <?php if ( post_password_required() ) : ?>
        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'nabasic' ) ); ?>

      <?php else : ?>
        <?php
          $images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
          if ( $images ) : {
            ?>
            <div id="galleryCarousel-<?php echo $post->ID; ?>" class="carousel slide" data-interval="5000">
              <ol class="carousel-indicators">
                <?php 
                  $counter = 0;
                  foreach ( $images as $image ) : {
                    echo '<li data-target="#myCarousel" data-slide-to="'.$counter.'"';
                    if($counter == 0) : echo ' class="active"'; endif;
                    echo '></li>';
                    $counter++;
                  } endforeach;
                ?>
              </ol>
              <!-- Carousel items -->
              <div class="carousel-inner">
                <?php 
                  $counter = 0;
                  foreach ( $images as $image ) : {
                    $alt = get_post_meta($image->ID, '_wp_attachment_image_alt', true);
                    $image_title = $image->post_title;
                    $caption = $image->post_excerpt;
                    $description = $image->post_content;
                    echo '<div class="item';
                    if($counter == 0) : echo " active"; endif;
                    echo '">';
                    //echo '<img alt="" src="'.wp_get_attachment_url( $image->ID ).'">';
                    echo wp_get_attachment_image( $image->ID, 'content-thumb' );
                    if ( $caption /*|| $description*/ ) :
                      echo '<div class="carousel-caption">';
                        echo '<h4>'.$image_title.'</h4>';
                        echo '<p>'.$caption.'</p>';
                        //echo '<p>'.$description.'</p>';
                      echo '</div>';
                    endif;
                    echo '</div>';
                    $counter++;
                  } endforeach;
                ?>
              </div>
              <!-- Carousel nav -->
              <a class="carousel-control left" href="#galleryCarousel-<?php echo $post->ID; ?>" data-slide="prev">&lsaquo;</a>
              <a class="carousel-control right" href="#galleryCarousel-<?php echo $post->ID; ?>" data-slide="next">&rsaquo;</a>
            </div>
            
            <?php
          } endif; ?>
      <?php the_excerpt(); ?>
    <?php endif; ?>
  <?php endif; ?>

  <footer class="clearfix">
    
    <?php 
      if(is_singular()) {
        edit_post_link( __( 'edit', 'nabasic' ), '<i class="icon-pencil" title="'.__( 'edit', 'nabasic' ).'"></i> <span class="edit-link">', '</span>' );
      }
    ?>
    
  </footer>


</article>


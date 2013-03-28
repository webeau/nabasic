<?php 
  // @link http://codex.wordpress.org/Function_Reference/post_class#Adding_More_Classes
  $classes = array(
    'clearfix',
    'highlight-first',
    'superteaser-top'
  ); 
  if($na_postcount) $classes[] = 'post-no'.$na_postcount;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
  
  <header>
    <hgroup>
      <?php 
        if(!is_category()) {
          //show category-name and link IF NOT default category
          $category = get_the_category(); 
          if(!empty($category[0]) && $category[0]->cat_name != get_the_category_by_id(get_option('default_category'))) {
            if(category_description($category[0]->cat_ID)){
              echo '<h2 class="category"><a href="'.get_category_link($category[0]->term_id ).'" title="'.category_description($category[0]->cat_ID).'" class="category">'.$category[0]->cat_name.'</a></h2>';
            } else {
              echo '<h2 class="category"><a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></h2>';
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
  </header>
  
</article>

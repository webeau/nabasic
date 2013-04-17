<?php

  global $post;
  $thumb_ID = get_post_thumbnail_id( $post->ID );
  
  // Attributes
  extract( shortcode_atts(
    array(
      'maxImages' => '-1',
      'order' => 'ASC',
      'postID' => $post->ID,
      'exclude' => '',
      'imgSize' => 'hd720-thumb' //content-thumb, hd720-thumb, thumb, thumbnail, medium, large, post-thumbnail // @link http://codex.wordpress.org/Function_Reference/add_image_size
    ), $atts )
  );

  // Code
  $exclude_arr = explode(",", $exclude);
  array_push($exclude_arr, $thumb_ID);

  $images = get_children( array( 
    'post_parent' => $postID, 
    'post_type' => 'attachment', 
    'post_mime_type' => 'image', 
    'order' => $order, 
    'orderby' => 'menu_order ID', 
    'numberposts' => $maxImages,
    'exclude' => $exclude_arr
  ) );

  if ( $images ) : {
    $first_key = key($images); // get first element in array
    $image_attributes = wp_get_attachment_image_src( $first_key, $imgSize ); // @link http://codex.wordpress.org/Function_Reference/wp_get_attachment_image_src#Return_Value
    ?>
    <div id="galleryCarousel-<?php echo $post->ID; ?>" class="carousel slide" data-interval="5000" style="width:<?php echo $image_attributes[1]; ?>px;max-width:100%;">
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
            echo wp_get_attachment_image( $image->ID, $imgSize );
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
  } endif;


?>
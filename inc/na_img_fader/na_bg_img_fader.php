<?php

/**
 * get uploaded background images
 * @link http://core.trac.wordpress.org/attachment/ticket/18623/choose-background-images.diff
 */
function na_get_uploaded_background_images() { 
  $background_images = array(); 
 
  // @todo caching 
  $backgrounds = get_posts( array( 
  'post_type' => 'attachment', 
  'meta_key' => '_wp_attachment_is_custom_background', 
  'meta_value' => get_option('stylesheet'), 
  'orderby' => 'none', 
  'nopaging' => true 
  ) ); 
         
  if ( empty( $backgrounds ) ) 
  return array(); 
 
  foreach ( (array) $backgrounds as $background ) { 
                 
    $url = esc_url_raw( $background->guid ); 
    $background_data = wp_get_attachment_metadata( $background->ID ); 
    $background_index = basename( $url ); 
    $background_images[$background_index] = array(); 
    //$background_images[$background_index]['attachment_id'] =  $background->ID; 
    $background_images[$background_index]['url'] =  $url; 
    //$background_images[$background_index]['thumbnail_url'] =  wp_get_attachment_thumb_url($background->ID); 
    //$background_images[$background_index]['width'] = $background_data['sizes']['thumbnail']['width']; 
    //$background_images[$background_index]['height'] = $background_data['sizes']['thumbnail']['height']; 
  } 

  return $background_images; 
}
 
wp_enqueue_script('bg-fader',   get_template_directory_uri() . '/inc/na_img_fader/js/na-bg-images-fader.js', array('jquery'), null, true );
$bg_images = na_get_uploaded_background_images();
wp_localize_script( 'bg-fader', 'bg_images', $bg_images );
if(get_theme_mod('bg_img_fader_sleep_time')): 
  $bg_fader_sleep_time = get_theme_mod('bg_img_fader_sleep_time');
else: 
  $bg_fader_sleep_time = '8000';
endif;
wp_localize_script( 'bg-fader', 'bg_fader_sleep_time', $bg_fader_sleep_time );
if(get_theme_mod('bg_img_fader_fade_time')): 
  $bg_fader_fade_time = get_theme_mod('bg_img_fader_fade_time');
else: 
  $bg_fader_fade_time = '1000';
endif;
wp_localize_script( 'bg-fader', 'bg_fader_fade_time', $bg_fader_fade_time );

?>
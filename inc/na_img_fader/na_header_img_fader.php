<?php

 
wp_enqueue_script('header-fader',   get_template_directory_uri() . '/inc/na_img_fader/js/na-header-images-fader.js', array('jquery'), null, true );
$header_images = get_uploaded_header_images();
wp_localize_script( 'header-fader', 'header_images', $header_images );
if(get_theme_mod('header_img_fader_sleep_time')): 
  $header_fader_sleep_time = get_theme_mod('header_img_fader_sleep_time');
else: 
  $header_fader_sleep_time = '8000';
endif;
wp_localize_script( 'header-fader', 'header_fader_sleep_time', $header_fader_sleep_time );
if(get_theme_mod('header_img_fader_fade_time')): 
  $header_fader_fade_time = get_theme_mod('header_img_fader_fade_time');
else: 
  $header_fader_fade_time = '1000';
endif;
wp_localize_script( 'header-fader', 'header_fader_fade_time', $header_fader_fade_time );

?>
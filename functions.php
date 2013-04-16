<?php 

/** CONTENT WIDTH 
 * @link https://codex.wordpress.org/Content_Width 
 */
if ( ! isset( $content_width ) )
  $content_width = 1400;
// ADJUST CONTENT WIDTH for other parts of the theme
/* 
function nabasic_content_width() {
  if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
    global $content_width;
    $content_width = 960;
  }
}
add_action( 'template_redirect', 'nabasic_content_width' );
*/


/** SETUP
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Twelve supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 *  custom background, custom header and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 * 
 * @link http://codex.wordpress.org/Plugin_API/Action_Reference/after_setup_theme
 *
 */
add_action( 'after_setup_theme', 'nabasic_setup' );
function nabasic_setup() {

/* --------------- CUSTOM START --------------- */

/** TEXTDOMAIN for translation/localization support
 * @link http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */
load_theme_textdomain( 'nabasic', get_template_directory() . '/languages' );

/** EDITOR Style
 * @link https://codex.wordpress.org/Editor_Style
 */
add_editor_style( 'css/bootstrap.min.css' );
add_editor_style( 'css/bootstrap-responsive-custom.css' );
add_editor_style( 'css/_editor.css' );

/** Automatic FEED LINKS
 * @link https://codex.wordpress.org/Automatic_Feed_Links
 */
add_theme_support( 'automatic-feed-links' );

/** POST FORMATS
 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Formats
 */
add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status', 'gallery', 'video' ) );

/** CUSTOM BACKGROUNDS
 * @link https://codex.wordpress.org/Custom_Backgrounds
 */
add_theme_support( 'custom-background', array(
  'default-color' => 'ffffff',
  //'default-image' => get_template_directory_uri() . '/images/background.jpg',
));

/** CUSTOM HEADERS
 * @link https://codex.wordpress.org/Custom_Headers
 */
add_theme_support( 'custom-header' );

/** POST THUMBNAILS
 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
 */
add_theme_support( 'post-thumbnails' );
if(function_exists('add_image_size')) { 
  add_image_size('hd720-thumb', 1280, 720, true); //(cropped)
  add_image_size('content-thumb', 1040, 380, true); //(cropped)
}
/** enable UPSCALING thumbs
 * @link http://wordpress.stackexchange.com/a/64953
 */
function image_crop_dimensions($default, $orig_w, $orig_h, $new_w, $new_h, $crop){
  if ( !$crop ) return null; // let the wordpress default function handle this

  $aspect_ratio = $orig_w / $orig_h;
  $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

  $crop_w = round($new_w / $size_ratio);
  $crop_h = round($new_h / $size_ratio);

  $s_x = floor( ($orig_w - $crop_w) / 2 );
  $s_y = floor( ($orig_h - $crop_h) / 2 );

  return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}
add_filter('image_resize_dimensions', 'image_crop_dimensions', 10, 6);

/** Navigation MENUS
 * @link https://codex.wordpress.org/Navigation_Menus
 */
register_nav_menus(array(
  'main-menu' => __( 'Main Menu', 'nabasic' ),
  'main-content-menu' => __( 'Main Content Menu', 'nabasic' ),
  'top-menu' => __( 'Top Menu', 'nabasic' )
));

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * >> Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function nabasic_wp_title( $title, $sep ) {
  global $paged, $page;

  if ( is_feed() )
    return $title;

  // Add the site name.
  $title .= get_bloginfo( 'name' );

  // Add the site description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) )
    $title = "$title $sep $site_description";

  // Add a page number if necessary.
  if ( $paged >= 2 || $page >= 2 )
    $title = "$title $sep " . sprintf( __( 'Page %s', 'nabasic' ), max( $paged, $page ) );

  return $title;
}
add_filter( 'wp_title', 'nabasic_wp_title', 10, 2 );

/** setup HTML >> HEAD
 */
if ( ! function_exists( 'setup_head' ) ) {
  function setup_head() {
    /** Add FAVICON to head
     */
    echo '<link rel="shortcut icon" type="image/x-icon" href="'.get_stylesheet_directory_uri().'/img/favicon.ico" />' . "\n";
    echo '<link rel="apple-touch-icon" href="'.get_stylesheet_directory_uri().'/img/apple-touch-icon.png" />' . "\n";

    /** SEO
     * @link http://wordpress.org/support/topic/anyway-to-add-meta-description-to-post-without-plugin?replies=10#post-2164231
     */
    if (is_single() || is_page() ) : if ( have_posts() ) : while ( have_posts() ) : the_post(); 
      echo '<meta name="description" content="'.esc_attr(na_the_excerpt('15',false)).'" />' . "\n";
    endwhile; endif; elseif(is_home()) : 
      echo '<meta name="description" content="'.get_bloginfo('description').'" />' . "\n";
    endif; 

    $posttags = get_the_tags();
    if ($posttags) {
      echo '<meta name="keywords" content="';
      foreach($posttags as $tag) {
        echo $tag->name . ' ';
      }
      echo '">' . "\n";
    }

    if(is_category() || is_search() || is_archive() || is_tag()) :
      echo '<meta name="robots" content="noindex, follow">' . "\n";
    else : 
      echo '<meta name="robots" content="index, follow">' . "\n";
    endif;
    
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
    //echo '<link rel="profile" href="http://gmpg.org/xfn/11" />' . "\n"; //http://wordpress.org/support/topic/header-link-httpgmpgorgxfn11?replies=7
    echo '<link rel="pingback" href="'.get_bloginfo( 'pingback_url' ).'" />' . "\n";
    
  }
  add_action( 'wp_head', 'setup_head', '1' );
}
/* --------------- CUSTOM END --------------- */

}


// THEME CUSTOMIZER
include_once('inc/theme-options.php');

/** Enqueues SCRIPTS and STYLES for front-end.
 */
function nabasic_scripts_styles() {
  
/* Loads our main scripts. */
// javascript for threaded comments-reply-form
function na_enqueue_comments_reply() {
  if( get_option( 'thread_comments' ) )  {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action('comment_form_before', 'na_enqueue_comments_reply');


/** Load jQuery from Google CDN (protocol relative) with local fallback when not available
 * @link http://wordpress.stackexchange.com/a/53205
 */
if ( false === ( $url = get_transient('jquery_url') ) ) {
    // Check if Google CDN is working
    $url = ( is_ssl() ? 'https:' : 'http:' ) . '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js';
    $resp = wp_remote_head($url);

    // Load local jquery if Google down
    if ( is_wp_error($resp) || 200 != $resp['response']['code'] ) {
        $url = get_template_directory_uri() . '/js/vendor/jquery-1.9.1.min.js';
    }

    // Cache the result for 5 minutes to save bandwidth
    set_transient('jquery_url', $url, 60*5);
}
// Deregister Wordpress' jquery and register theme's copy in the footer
wp_deregister_script('jquery');
wp_register_script('jquery', $url, array(), null, true);

// Load other theme scripts here
wp_enqueue_script('modernizr-respond', get_template_directory_uri() . '/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js', array(), null, false);
wp_enqueue_script('bootstrap',  get_template_directory_uri() . '/js/vendor/bootstrap.min.js',               array('jquery'), null, true );
/** @link http://gsgd.co.uk/sandbox/jquery/easing/ */
wp_enqueue_script('easing',     get_template_directory_uri() . '/js/vendor/jquery.easing.1.3.js',           array('jquery'), null, true );
/** @link http://flesler.blogspot.de/2007/10/jqueryscrollto.html */
wp_enqueue_script('scrollto',   get_template_directory_uri() . '/js/vendor/jquery.scrollTo-1.4.3.1-min.js', array('jquery'), null, true );
wp_enqueue_script('plugins',    get_template_directory_uri() . '/js/plugins.js',                            array('jquery'), null, true );
wp_enqueue_script('main',       get_template_directory_uri() . '/js/main.js',                               array('jquery'), null, true );
if ( has_nav_menu( 'main-menu' ) && get_theme_mod('fixed_main_navi') ) {
  wp_enqueue_script('naviAdjust', get_template_directory_uri() . '/js/naviAdjust.js',                         array('jquery'), null, true );
}

/* Loads our main stylesheets.
 */
wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css' );
wp_enqueue_style( 'bootstrap-responsive-style', get_template_directory_uri() . '/css/bootstrap-responsive-custom.css' );
wp_enqueue_style( 'structure-style', get_template_directory_uri() . '/css/structure.css' );
wp_enqueue_style( 'main-style', get_template_directory_uri() . '/css/main.css' );
wp_enqueue_style( 'nabasic-style', get_stylesheet_uri() );

}
add_action( 'wp_enqueue_scripts', 'nabasic_scripts_styles' );


/** Registers our WIDGET AREAS / SIDEBARS
 */
function nabasic_widgets_init() {

/** SIDEBARS
 * @link https://codex.wordpress.org/Sidebars
 */
register_sidebar( array(
  'name' => __( 'Sidebar3', 'nabasic' ),
  'id' => 'sidebar-1',
  'description' => __( 'Sidebar3 for displaying aside content', 'nabasic' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h1 class="widget-title">',
  'after_title' => '</h1>',
));
register_sidebar( array(
  'name' => __( 'Sidebar1', 'nabasic' ),
  'id' => 'sidebar-2',
  'description' => __( 'Sidebar1 for displaying pre-content like a navigation', 'nabasic' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h1 class="widget-title">',
  'after_title' => '</h1>',
));
register_sidebar( array(
  'name' => __( 'Footer1', 'nabasic' ),
  'id' => 'footer-1',
  'description' => __( 'Footer area for displaying content and footer navigations below the content area.', 'nabasic' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h1 class="widget-title">',
  'after_title' => '</h1>',
));
register_sidebar( array(
  'name' => __( 'Footer2', 'nabasic' ),
  'id' => 'footer-2',
  'description' => __( 'Footer area for displaying content and footer navigations below the content area.', 'nabasic' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h1 class="widget-title">',
  'after_title' => '</h1>',
));
register_sidebar( array(
  'name' => __( 'Footer3', 'nabasic' ),
  'id' => 'footer-3',
  'description' => __( 'Footer area for displaying content and footer navigations below the content area.', 'nabasic' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h1 class="widget-title">',
  'after_title' => '</h1>',
));
register_sidebar( array(
  'name' => __( 'Footer4', 'nabasic' ),
  'id' => 'footer-4',
  'description' => __( 'Footer area for displaying content and footer navigations below the content area.', 'nabasic' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h1 class="widget-title">',
  'after_title' => '</h1>',
));
register_sidebar( array(
  'name' => __( 'Copyright', 'nabasic' ),
  'id' => 'copyright',
  'description' => __( 'Area for showing copyright hint. Placed below site footer.', 'nabasic' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h1 class="widget-title">',
  'after_title' => '</h1>',
));
register_sidebar( array(
  'name' => __( 'Sidebar3 - Posts', 'nabasic' ),
  'id' => 'sidebar-three-single',
  'description' => __( 'Sidebar3 for displaying aside post content (shown if activated otherwise sidebar3)', 'nabasic' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h1 class="widget-title">',
  'after_title' => '</h1>',
));
register_sidebar( array(
  'name' => __( 'Sidebar1 - Posts', 'nabasic' ),
  'id' => 'sidebar-one-single',
  'description' => __( 'Sidebar1 for displaying pre post content (shown if activated otherwise sidebar1)', 'nabasic' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h1 class="widget-title">',
  'after_title' => '</h1>',
));
register_sidebar( array(
  'name' => __( 'Sidebar3 - Pages', 'nabasic' ),
  'id' => 'sidebar-three-page',
  'description' => __( 'Sidebar3 for displaying aside post content (shown if activated otherwise sidebar3)', 'nabasic' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h1 class="widget-title">',
  'after_title' => '</h1>',
));
register_sidebar( array(
  'name' => __( 'Sidebar1 - Pages', 'nabasic' ),
  'id' => 'sidebar-one-page',
  'description' => __( 'Sidebar1 for displaying pre post content (shown if activated otherwise sidebar1)', 'nabasic' ),
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h1 class="widget-title">',
  'after_title' => '</h1>',
));

}
add_action( 'widgets_init', 'nabasic_widgets_init' );


/** link all Post Thumbnails on your website to the Post Permalink
 * @link http://codex.wordpress.org/Function_Reference/the_post_thumbnail#Post_Thumbnail_Linking_to_the_Post_Permalink
 */
add_filter( 'post_thumbnail_html', 'my_post_image_html', 10, 3 );
function my_post_image_html( $html, $post_id, $post_image_id ) {
  $html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . $html . '</a>';
  return $html;
}


/** add CLASS for ACTIVE buttons in MENU
 * @link http://goo.gl/uUclf
 * not implementedv >> replaced by twitter_bootstrap_nav_walker.php
 * 
 * Register Custom NAVIGATION WALKER - BOOTSTRAP
 * @link https://github.com/twittem/wp-bootstrap-navwalker/blob/master/README.md
 */
require_once('js/vendor/wp-bootstrap-navwalker/twitter_bootstrap_nav_walker.php');


/** adjust EXCERPT length
 * @link http://codex.wordpress.org/Function_Reference/the_excerpt
 */ 
function custom_excerpt_length( $length ) {
  return 75;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/** define different EXCERPT/CONTENT LENGTH
 * @link: http://stackoverflow.com/a/4086542/874048 
 */
function na_the_excerpt($limit,$more=true) {
  $excerpt = explode(' ', strip_tags(get_the_content()), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt);
    if($more) {
      $excerpt .= ' <a href="'. get_permalink() . '">'.__('more...', 'nabasic').'</a>';
    } else {
      $excerpt .= ' ...';
    }
  } else {
    $excerpt = implode(" ",$excerpt);
  } 
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
function na_the_content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).' <a href="'. get_permalink() . '">'.__('more...', 'nabasic').'</a>';
  } else {
    $content = implode(" ",$content);
  } 
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}


/** wpAUTOP disabling filter
 * @link http://codex.wordpress.org/Function_Reference/wpautop
 */
// Category description without wrapped <p>
remove_filter('term_description','wpautop');
//remove_filter( 'the_content', 'wpautop' );
//remove_filter( 'the_excerpt', 'wpautop' );


// adjust text READ MORE - link
function new_excerpt_more($more) {
  global $post;
  return ' <a href="'. get_permalink($post->ID) . '">'.__('more...', 'nabasic').'</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');


// PAGER
if ( ! function_exists( 'na_pager' ) ) :
function na_pager($nav_class = '') {
  global $wp_query;
  if($wp_query->max_num_pages > 1): ?>
    <nav id="<?php echo $nav_id; ?>" class="na-nav <?php echo $nav_class; ?>">
      <h3 class="assistive-text"><?php _e( 'Post navigation', 'nabasic' ); ?></h3>
      <ul class="pager">
        <li class="previous"><?php next_posts_link( __( '<span class="meta-nav">&lt;&lt;</span> Older posts', 'nabasic' ) ); ?></li>
        <li class="next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&gt;&gt;</span>', 'nabasic' ) ); ?></li>
      </ul>
    </nav>
  <?php endif;
}
endif; // na_pager
// endless PAGER
if ( !function_exists( 'na_pager_rotation' ) ) :
// @link http://robertbasic.com/blog/wordpress-paging-navigation/
 function na_pager_rotation($nav_class = '') {
  global $paged, $wp_query;
  if(!$max_page){$max_page = $wp_query->max_num_pages;}  
  if($max_page > 1): ?>
    <nav class="na-nav <?php echo $nav_class; ?>">
      <h3 class="assistive-text"><?php _e( 'Post navigation', 'nabasic' ); ?></h3>
      <ul class="pager">
        <li class="next"><?php next_posts_link( __( '<span class="meta-nav">&gt;&gt;</span>', 'nabasic' ) ); ?></li>
        <li class="previous"><?php previous_posts_link( __( '<span class="meta-nav">&lt;&lt;</span>', 'nabasic' ) ); ?></li>
      
      <?php if($paged == 1): ?>
        <li class="previous"><a href="<?php echo get_pagenum_link($max_page) ?>"><?php _e( '<span class="meta-nav">&lt;&lt;</span>', 'nabasic' ); ?></a></li>
      <?php endif; ?>
      <?php if($paged == $max_page): ?>
        <li class="next"><a href="<?php echo get_pagenum_link(1) ?>"><?php _e( '<span class="meta-nav">&gt;&gt;</span>', 'nabasic' ); ?></a></li>
      <?php endif; ?>
      </ul>
    </nav>
  <?php endif;
}
endif; // na_pager_rotation

// PAGINATION
include_once('inc/pagination.php');

// ENHANCED_LINK_PAGES
include_once('inc/enhanced-link-pages.php');


/** GETIMAGE for getting an image aut of a post
 * @link http://bavotasan.com/tutorials/retrieve-the-first-image-from-a-wordpress-post/ 
 */
function getImage($num) {
  global $more;
  $more = 1;
  $link = get_permalink();
  $content = get_the_content();
  $count = substr_count($content, '<img');
  $start = 0;
  $image[] = null;
  for($i=1;$i<=$count;$i++) {
    $imgBeg = strpos($content, '<img', $start);
    $post = substr($content, $imgBeg);
    $imgEnd = strpos($post, '>');
    $postOutput = substr($post, 0, $imgEnd+1);
    $postOutput = preg_replace('/width="([0-9]*)" height="([0-9]*)"/', '',$postOutput);
    $image[$i] = $postOutput;
    $start=$imgEnd+1;
  }
  if(isset($image[$num])) {
    if(stristr($image[$num],'<img')) {
      $imageSrc = null;
      if(array_key_exists($num, $image)) {
        $searchStr = 'src="';
        $posStart = strpos($image[$num], $searchStr);
        if($posStart !== false) {
          $posStart = $posStart + strlen($searchStr);
          $posEnd = strpos($image[$num], '"', $posStart);
          if($posEnd !== false) {
             $strLength = $posEnd - $posStart; 
             $imageSrc = substr($image[$num], $posStart, $strLength);
          }
        }
      }
      if($imageSrc !== null) return $imageSrc;
    }
  }
  $more = 0;
}

/** GETLINK for getting a link aut of a post
 * @link http://bavotasan.com/tutorials/retrieve-the-first-image-from-a-wordpress-post/ 
 */
function getLink($num = 1) {
  global $more;
  $more = 1;
  $content = get_the_content();
  $count = substr_count($content, '<a');
  $start = 0;
  $link[] = null;
  for($i=1;$i<=$count;$i++) {
    $linkBeg = strpos($content, '<a', $start);
    $post = substr($content, $linkBeg);
    $linkEnd = strpos($post, '/a>');
    $postOutput = substr($post, 0, $linkEnd+1);
    //$postOutput = preg_replace('/width="([0-9]*)" height="([0-9]*)"/', '',$postOutput);
    $link[$i] = $postOutput;
    $start=$imgEnd+1;
  }
  if(isset($link[$num])) {
    if(stristr($link[$num],'<a')) {
      $linkSrc = null;
      if(array_key_exists($num, $link)) {
        $searchStr = 'href="';
        $posStart = strpos($link[$num], $searchStr);
        if($posStart !== false) {
          $posStart = $posStart + strlen($searchStr);
          $posEnd = strpos($link[$num], '"', $posStart);
          if($posEnd !== false) {
             $strLength = $posEnd - $posStart; 
             $linkSrc = substr($link[$num], $posStart, $strLength);
          }
        }
      }
      if($linkSrc !== null) return $linkSrc;
    }
  }
  $more = 0;
}

/** GETIFRAME for getting an image aut of a post
 * @link http://bavotasan.com/tutorials/retrieve-the-first-image-from-a-wordpress-post/ 
 */
function getIFrame($num) {
  global $more;
  $more = 1;
  $content = get_the_content();
  $count = substr_count($content, '<iframe');
  $start = 0;
  $iframe[] = null;
  for($i=1;$i<=$count;$i++) {
    $iframeBeg = strpos($content, '<iframe', $start);
    $post = substr($content, $iframeBeg);
    $iframeEnd = strpos($post, '/iframe>');
    $postOutput = substr($post, 0, $iframeEnd+8);
    $iframe[$i] = $postOutput;
    $start=$iframeEnd+1;
  }
  if(isset($iframe[$num])) {
    return $iframe[$num];
  }
  $more = 0;
}


/** Add class to EDIT POST LINK
 * @link http://wordpress.org/support/topic/add-class-to-edit_post_link?replies=3#post-2385665 
 */
/*
function custom_edit_post_link($output) {
 $output = str_replace('class="post-edit-link"', 'class="post-edit-link btn"', $output);
 return $output;
}
add_filter('edit_post_link', 'custom_edit_post_link');
*/

/** Add class to EDIT COMMENT LINK 
 */
/*
function custom_edit_comment_link($output) {
 $output = str_replace('class="comment-edit-link"', 'class="comment-edit-link btn btn-mini"', $output);
 return $output;
}
add_filter('edit_comment_link', 'custom_edit_comment_link');
*/

/** Add class to COMMENT REPLY LINK 
 */
/*
function na_comment_reply_link($args = array(), $comment = null, $post = null) {
  $output = get_comment_reply_link($args, $comment, $post);
  $output = preg_replace( '/comment-reply-link/', 'comment-reply-link btn btn-mini', $output, 1 );
  echo $output;
}
*/


/** enqueue COMMENTS POPUP SCRIPT
 * @link http://codex.wordpress.org/Function_Reference/comments_popup_link 
 */
function na_enqueue_comments_popup_script() {
  $width = 600;
  $height = 700;
  comments_popup_script($width, $height);
}
add_action('wp_enqueue_scripts', 'na_enqueue_comments_popup_script');

/** alter default COMMENT FORM FIELDS
 * @link http://codex.wordpress.org/Function_Reference/comment_form 
 */
function alter_comment_form_fields($fields){
  $commenter = wp_get_current_commenter();

  $req = get_option( 'require_name_email' );
  $aria_req = ( $req ? " aria-required='true'" : '' );

  $fields['author'] = '<p class="comment-form-author">
                        <label class="assistive-text" for="author">' . __( 'Name', 'nabasic' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label> 
                        <input id="author" class="input-xlarge" placeholder="' . __( 'Name', 'nabasic' ) . ( $req ? '*' : '' ) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />
                      </p>';
  $fields['email'] = '<p class="comment-form-email">
                        <label class="assistive-text" for="email">' . __( 'Email', 'nabasic' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label> 
                        <input id="email" class="input-xlarge" placeholder="' . __( 'Email', 'nabasic' ) . ( $req ? '*' : '' ) . '" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />
                        <span class="help-inline">' . __( 'Your email address will not be published.' ) . ( $req ? '*' : '' ) . '</span>
                      </p>';
  $fields['url'] = '<p class="comment-form-url">
                      <label class="assistive-text" for="url">' . __( 'Website', 'nabasic' ) . '</label>
                      <input id="url" class="input-xlarge" placeholder="' . __( 'Website', 'nabasic' ) . '" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
                    </p>';

  return $fields;
}
add_filter('comment_form_default_fields','alter_comment_form_fields');

/** alter default COMMENT FORM
 * @link http://codex.wordpress.org/Function_Reference/comment_form 
 */
function alter_comment_form($args){
  $args['comment_field'] = '<p class="comment-form-comment">
                              <label class="assistive-text" for="comment">' . /* translators: Comment is a noun. */ _x( 'Comment', 'noun' ) . '</label>
                              <textarea id="comment" class="input-xlarge" name="comment"  placeholder="' . _x( 'Comment', 'noun' ) . '"cols="45" rows="8" aria-required="true"></textarea>
                              <span class="help-inline">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <br><span class="allowed_tags">' . allowed_tags() . '</span>' ) . '</span>
                            </p>';
  $args['comment_notes_before'] = '';
  $args['comment_notes_after'] = '';
    return $args;
}
add_filter('comment_form_defaults','alter_comment_form');

/** Template for comments and pingbacks 
 */
if ( ! function_exists( 'na_comment' ) ) :
function na_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
    case 'pingback' :
    case 'trackback' :
    // Display trackbacks differently than normal comments.
  ?>
  <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
    <p>
      <?php _e( 'Pingback:', 'nabasic' ); ?> <?php comment_author_link(); ?> 
      <?php edit_comment_link( __( '(Edit)', 'nabasic' ), '<span class="edit-link">', '</span>' ); ?>
    </p>
  <?php
      break;
    default :
    // Proceed with normal comments.
    global $post;
  ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    <article id="comment-<?php comment_ID(); ?>" class="comment<?php echo ('0' == $comment->comment_approved )?' alert':''; ?>">

      <?php if ( '0' == $comment->comment_approved ) : ?>
        <div class="comment-awaiting-moderation alert"><?php _e( 'Your comment is awaiting moderation.', 'nabasic' ); ?></div>
      <?php endif; ?>

      <header class="comment-meta comment-author vcard">

        <?php 
          if(validate_gravatar($comment->comment_author_email)){
            $url = get_comment_author_url();
            if ( empty( $url ) || 'http://' == $url ) {
              $return = get_avatar( $comment, 44 );
            } else {
              $return = '<a href="'.$url.'" rel="external nofollow" target="_blank" title="'.__('Go to ', 'nabasic').$url.'">'.get_avatar( $comment, 44 ).'</a>';
            }
            echo '<div class="avatar pull-left">'.$return.'</div>'; 
          }
        ?>

        <?php printf('<time datetime="%1$s">%2$s</time>', 
          get_comment_time( 'c' ), 
          sprintf(__('%1$s at %2$s', 'nabasic'), get_comment_date(), get_comment_time())
        ); ?>

        <cite class="author fn">
          <?php 
            echo ($comment->user_id === $post->post_author) ? '<span title="'.__('Post author', 'nabasic').'">' . get_comment_author() . ' <i class="icon-star"></i></span>' : get_comment_author();
            $url = get_comment_author_url();
            echo ( !empty( $url ) && 'http://' != $url ) ? ' <a href="'.$url.'" rel="external nofollow" target="_blank" title="'.__('Go to ', 'nabasic').$url.'"><i class="icon-globe"></i></a>' : '';
          ?>
        </cite>
      </header><!-- .comment-meta -->

      
      <div class="comment-content comment">
        <?php comment_text(); ?>
      </div><!-- .comment-content -->

      <footer>
        <?php 
          printf('<a data-toggle="popover" title="" data-content="%1$sAnd here&acute;s some amazing content. It&acute;s very engaging. right?" data-original-title="A Title" id="permalink-link-'.get_comment_ID().'" class="permalink-link" title="'.__('Permalink', 'nabasic').'"><i class="icon-bookmark"></i> '.__('Permalink', 'nabasic').'</a>',esc_url(get_comment_link($comment->comment_ID)));
        ?>
        <div class="permalink-popover" style="display:none;">
          <input type="text" value="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>" onmouseover="this.select()" />
          <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>" title="<?php echo __('Go to permalink','nabasic'); ?>"><i class="icon-arrow-right"></i></a>
        </div>
        
        <?php edit_comment_link('<i class="icon-pencil"></i> '.__('Edit','nabasic')); ?>
        <?php comment_reply_link(array_merge($args, array( 
          'reply_text' => '<i class="icon-share-alt"></i> '.__('Reply','nabasic'), 
          'depth' => $depth, 
          'max_depth' => $args['max_depth'] 
        ))); ?>
      </footer>
    </article><!-- #comment-## -->
  <?php
    break;
  endswitch; // end comment_type check
}
endif;

// BREADCRUMBS
include_once('inc/breadcrumbs.php');

/** VALIDATE GRAVATAR
 * @link http://codex.wordpress.org/Using_Gravatars 
 */
function validate_gravatar($email) {
  // Craft a potential url and test its headers
  $hash = md5(strtolower(trim($email)));
  $uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
  $headers = @get_headers($uri);
  if (!preg_match("|200|", $headers[0])) {
    $has_valid_avatar = FALSE;
  } else {
    $has_valid_avatar = TRUE;
  }
  return $has_valid_avatar;
}


/** alter PASSWORT PROTECT FORM
 * @link: http://wordpress.org/support/topic/password-protected-change-message?replies=6#post-763052 
 */
function replace_the_password_form($content) {
  global $post;
  // if there's a password and it doesn't match the cookie
  if ( !empty($post->post_password) && stripslashes($_COOKIE['wp-postpass_'.COOKIEHASH])!=$post->post_password ) {
    $output = '

    <form action="'.get_option('siteurl').'/wp-pass.php" method="post">
      <p>
        '.__("This post is password protected. To view it please enter your password below.","nabasic").'
      </p>
      <div class="input-append">
        <label for="post_password" class="assistive-text">'.__("Password","nabasic").'</label>
        <input name="post_password" placeholder="'.__("Password","nabasic").'" class="input" type="password" size="20" />
        <input type="submit" name="Submit" class="btn abtn-primary" value="'.__("Go!","nabasic").'" />
      </div>
    </form>

    ';
    return $output;
  }
  else return $content;
}
add_filter('the_content','replace_the_password_form');

/** REMOVE "Private:" from PASSWORT PROTECTED PAGES
 * @link: http://www.vileworks.com/password-protected-area-in-wordpress 
 */
add_filter('the_title','remove_private_prefix');
function remove_private_prefix($title) {
  $title = str_replace('Private:','',$title);
  return $title;
}

/** styling LOGIN page
 * @link http://codex.wordpress.org/Customizing_the_Login_Form#Change_the_Login_Logo
 */
function my_login_logo_url() {
  return 'http://www.na-media.com';
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
  return 'Powered by NA-Media - Social Software';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function my_login_stylesheet() { ?>
  <link rel="stylesheet" id="custom_wp_admin_css"  href="<?php echo get_bloginfo( 'stylesheet_directory' ) . '/css/style-login.css'; ?>" type="text/css" media="all" />
<?php }
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

/**
 * FIX: WordPress Stripping iFrame Elements
 * @link http://www.tastyplacement.com/wordpress-stripping-iframe-elements-heres-the-fix
 * (alternative with custom fields: @link http://vividvisions.com/2009/02/11/wordpress-add-iframes-to-your-post/)
 */
// this function initializes the iframe elements 
function add_iframe($initArray) {
$initArray['extended_valid_elements'] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";
return $initArray;
}
// this function alters the way the WordPress editor filters your code
add_filter('tiny_mce_before_init', 'add_iframe');

/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 */
if ( ! function_exists( 'na_post_meta' ) ) :
function na_post_meta() {
  
  $date = sprintf( '<div class="meta-date"><i class="icon-calendar" title="'.__( 'Release Date', 'nabasic' ).'"></i> <time datetime="%1$s" title="%2$s - %3$s">%2$s - %3$s</time></div>',
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() ),
    esc_attr( get_the_time() )
  );
  
  $author = sprintf( '<div class="meta-author"><i class="icon-user" title="'.__( 'Author', 'nabasic' ).'"></i> <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></div>',
    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
    esc_attr( sprintf( __( 'View all posts by %s', 'nabasic' ), get_the_author() ) ),
    get_the_author()
  );

  // Translators: used between list items, there is a space after the comma.
  $categories_list = '<div class="meta-categories"><i class="icon-folder-open" title="'.__( 'Category', 'nabasic' ).'"></i> '.get_the_category_list( __( ', ', 'nabasic' ) ).'</div>';

  // Translators: used between list items, there is a space after the comma.
  $tag_list = get_the_tag_list( '<div class="meta-tags"><i class="icon-tags" title="'.__( 'Tags', 'nabasic' ).'"></i> <span class="badge badge-info">', '</span> <span class="badge badge-info">', '</span></div>');

  // Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
  if ( $tag_list ) {
    $utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'nabasic' );
  } elseif ( $categories_list ) {
    $utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'nabasic' );
  } else {
    $utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'nabasic' );
  }

  //printf($utility_text,$categories_list,$tag_list,$date,$author);
  if(get_theme_mod('display_post_date')) printf($date);
  if(get_theme_mod('display_post_author')) printf($author);
  if(get_theme_mod('display_post_categories')) printf($categories_list);
  if(get_theme_mod('display_post_tags')) printf($tag_list);
  
}
endif;

if ( ! function_exists( 'na_post_meta_bookmark' ) ) :
function na_post_meta_bookmark() {

  $bookmarklink = sprintf( '<span class="meta-bookmark"><a href="%1$s" rel="bookmark" title="'.__( 'Bookmark', 'nabasic' ).'"><i class="icon-bookmark"></i></a></span>',
    esc_url( get_permalink() )
  );

  //printf($utility_text,$categories_list,$tag_list,$date,$author);
  if(get_theme_mod('display_post_bookmark',true)) printf($bookmarklink);
}
endif;


// EVENTS - custom post format
if(get_theme_mod('activate_events_custom_post_type')):
  include_once('inc/na_events/na_events.php');
  include_once('inc/na_events/na_events_shortcode.php');
  include_once('inc/na_events/na_events_ical.php');
endif;

// BACKGROUNG IMG FADER
if(get_theme_mod('activate_bg_img_fader')) include_once('inc/na_img_fader/na_bg_img_fader.php');

// HEADER IMG FADER
if(get_theme_mod('activate_header_img_fader')) include_once('inc/na_img_fader/na_header_img_fader.php');


/** Add Shortcode for custom gallery carousel
 * @link http://generatewp.com/shortcodes/
 */
function na_gallery( $atts , $content = null ) {
  
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
}
add_shortcode( 'na_gallery', 'na_gallery' );



/** Custom TAXONOMIES
 * @link http://net.tutsplus.com/tutorials/wordpress/introducing-wordpress-3-custom-taxonomies/
 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
/* example */
/*
add_action( 'init', 'build_taxonomies', 0 );
function build_taxonomies() {
  register_taxonomy( 
    'taxonomy_name',                  // internal_name
    'post',                           // what to classify? Possible values are “post, page, attachment, revision, nav_menu_item”
    array(
      'hierarchical'  => true,         // If ‘true,’ this taxonomy has hierarchical abilities like WordPress Categories. If ‘false,’ this taxonomy behaves much like freeform Tags. If you want to ensure that your custom taxonomy behaves like a tag, you must add the option 'update_count_callback' => '_update_post_term_count'. Not doing so will result in multiple comma-separated items added at once being saved as a single value, not as separate values. This can cause undue stress when using get_the_term_list and other term display functions.
      'label'         => __( 'Taxonomy Name' ),  // human-readable name 
      'query_var'     => true,            // search capability within taxonomy
      'rewrite'       => true               // user friendly URL’s
    )
  );
}
*/



































?>
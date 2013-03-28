<?php
/**
 * @link http://www.noeltock.com/web-design/wordpress/custom-post-types-events-pt1/
 */

// 0. Base
add_action('admin_init', 'na_events_css');
function na_events_css() {
  wp_enqueue_style('na-events', get_template_directory_uri() . '/inc/na_events/css/na_events.css');
}
 
// 1. Custom Post Type Registration (Events)
add_action( 'init', 'create_event_postype' );
function create_event_postype() {
  
  $labels = array(
    'name' => _x('Events', 'post type general name'),
    'singular_name' => _x('Event', 'post type singular name'),
    'add_new' => _x('Add New', 'events'),
    'add_new_item' => __('Add New Event'),
    'edit_item' => __('Edit Event'),
    'new_item' => __('New Event'),
    'view_item' => __('View Event'),
    'search_items' => __('Search Events'),
    'not_found' =>  __('No events found'),
    'not_found_in_trash' => __('No events found in Trash'),
    'parent_item_colon' => '',
  );
   
  $args = array(
    'label' => __('Events'),
    'labels' => $labels,
    'public' => true,
    'can_export' => true,
    'show_ui' => true,
    '_builtin' => false,
    'capability_type' => 'post',
    'menu_icon' => get_bloginfo('template_url').'/img/glyphicons-halflings-icon-calendar.png',
    'hierarchical' => false,
    'rewrite' => array( "slug" => "events" ),
    'supports'=> array('title', 'thumbnail', 'excerpt', 'editor') ,
    'show_in_nav_menus' => true,
    'taxonomies' => array( 'na_eventcategory', 'post_tag')
  );
  
  register_post_type( 'na_events', $args);
}

// 2. Custom Taxonomy Registration (Event Types)
function create_eventcategory_taxonomy() {
 
  $labels = array(
    'name' => _x( 'Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Categories' ),
    'popular_items' => __( 'Popular Categories' ),
    'all_items' => __( 'All Categories' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Category' ),
    'update_item' => __( 'Update Category' ),
    'add_new_item' => __( 'Add New Category' ),
    'new_item_name' => __( 'New Category Name' ),
    'separate_items_with_commas' => __( 'Separate categories with commas' ),
    'add_or_remove_items' => __( 'Add or remove categories' ),
    'choose_from_most_used' => __( 'Choose from the most used categories' ),
  );
   
  register_taxonomy('na_eventcategory','na_events', array(
    'label' => __('Event Category'),
    'labels' => $labels,
    'hierarchical' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'event-category' ),
  ));
}
add_action( 'init', 'create_eventcategory_taxonomy', 0 );


// 3. Show Columns
add_filter ("manage_edit-na_events_columns", "na_events_edit_columns");
add_action ("manage_posts_custom_column", "na_events_custom_columns");
function na_events_edit_columns($columns) {
  $columns = array(
      "cb" => "<input type=\"checkbox\" />",
      "na_col_ev_date" => "Dates",
      "na_col_ev_times" => "Times",
      "title" => "Event",
      "na_col_ev_cat" => "Category",
      "na_col_ev_thumb" => "Thumbnail",
      //"na_col_ev_desc" => "Description",
    );
  return $columns;
}
 
function na_events_custom_columns($column) {
  global $post;
  $custom = get_post_custom();
  switch ($column) {
    case "na_col_ev_cat":
      // - show taxonomy terms -
      $eventcats = get_the_terms($post->ID, "na_eventcategory");
      $eventcats_html = array();
      if ($eventcats) {
        foreach ($eventcats as $eventcat)
        array_push($eventcats_html, $eventcat->name);
        echo implode($eventcats_html, ", ");
      } else {
        _e('None', 'themeforce');;
      }
      break;
    case "na_col_ev_date":
      // - show dates -
      $startd = $custom["na_events_startdate"][0];
      $endd = $custom["na_events_enddate"][0];
      $startdate = date("F j, Y", $startd);
      $enddate = date("F j, Y", $endd);
      echo $startdate . '<br /><em>' . $enddate . '</em>';
      break;
    case "na_col_ev_times":
      // - show times -
      $startt = $custom["na_events_startdate"][0];
      $endt = $custom["na_events_enddate"][0];
      $time_format = get_option('time_format');
      $starttime = date($time_format, $startt);
      $endtime = date($time_format, $endt);
      echo $starttime . ' - ' .$endtime;
      break;
    case "na_col_ev_thumb":
      // - show thumb -
      $post_image_id = get_post_thumbnail_id(get_the_ID());
      if ($post_image_id) {
        $thumbnail = wp_get_attachment_image_src( $post_image_id, 'post-thumbnail', false);
        if ($thumbnail) (string)$thumbnail = $thumbnail[0];
        echo '<img src="';
        echo bloginfo('template_url');
        echo '/timthumb/timthumb.php?src=';
        echo $thumbnail;
        echo '&h=60&w=60&zc=1" alt="" />';
      }
      break;
    case "na_col_ev_desc";
      the_excerpt();
      break;
  }
}

// 4. Show Meta-Box
 
add_action( 'admin_init', 'na_events_create' );
function na_events_create() {
  add_meta_box('na_events_meta', 'Events', 'na_events_meta', 'na_events');
}
function na_events_meta () {
  
  // - grab data -
  global $post;
  $custom = get_post_custom($post->ID);
  $meta_sd = $custom["na_events_startdate"][0];
  $meta_ed = $custom["na_events_enddate"][0];
  $meta_st = $meta_sd;
  $meta_et = $meta_ed;
   
  // - grab wp time format -
  $date_format = get_option('date_format'); // Not required in my code
  $time_format = get_option('time_format');
   
  // - populate today if empty, 00:00 for time -
  if ($meta_sd == null) { $meta_sd = time(); $meta_ed = $meta_sd; $meta_st = 0; $meta_et = 0;}
   
  // - convert to pretty formats -
  $clean_sd = date("D, M d, Y", $meta_sd);
  $clean_ed = date("D, M d, Y", $meta_ed);
  $clean_st = date($time_format, $meta_st);
  $clean_et = date($time_format, $meta_et);
   
  // - security -
  echo '<input type="hidden" name="na-events-nonce" id="na-events-nonce" value="' .
  wp_create_nonce( 'na-events-nonce' ) . '" />';
   
  // - output -
  ?>
  <div class="na-meta">
    <ul>
      <li><label>Start Date</label><input name="na_events_startdate" class="nadate" value="<?php echo $clean_sd; ?>" /></li>
      <li><label>Start Time</label><input name="na_events_starttime" value="<?php echo $clean_st; ?>" /><em>Use 24h format (7pm = 19:00)</em></li>
      <li><label>End Date</label><input name="na_events_enddate" class="nadate" value="<?php echo $clean_ed; ?>" /></li>
      <li><label>End Time</label><input name="na_events_endtime" value="<?php echo $clean_et; ?>" /><em>Use 24h format (7pm = 19:00)</em></li>
    </ul>
  </div>
  <?php
  
}

// 5. Save Data
add_action ('save_post', 'save_na_events');
function save_na_events(){

  global $post;
  
  // - still require nonce
  if ( !wp_verify_nonce( $_POST['na-events-nonce'], 'na-events-nonce' )) {
    return $post->ID;
  }
   
  if ( !current_user_can( 'edit_post', $post->ID ))
    return $post->ID;
   
  // - convert back to unix & update post
  if(!isset($_POST["na_events_startdate"])):
    return $post;
  endif;
  $updatestartd = strtotime ( $_POST["na_events_startdate"] . $_POST["na_events_starttime"] );
  update_post_meta($post->ID, "na_events_startdate", $updatestartd );
   
  if(!isset($_POST["na_events_enddate"])):
    return $post;
  endif;
  $updateendd = strtotime ( $_POST["na_events_enddate"] . $_POST["na_events_endtime"]);
  update_post_meta($post->ID, "na_events_enddate", $updateendd );
   
}

// 6. Customize Update Messages
add_filter('post_updated_messages', 'events_updated_messages');
function events_updated_messages( $messages ) {
 
  global $post, $post_ID;
  $messages['na_events'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Event updated. <a href="%s">View item</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Event updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Event restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Event published. <a href="%s">View event</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Event saved.'),
    8 => sprintf( __('Event submitted. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Event draft updated. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}

// 7. JS Datepicker UI
 
function events_styles() {
  global $post_type;
  if( 'na_events' != $post_type )
    return;
  wp_enqueue_style('ui-datepicker', get_bloginfo('template_url') . '/inc/na_events/css/jquery-ui-1.8.9.custom.css');
}
add_action( 'admin_print_styles-post.php', 'events_styles', 1000 );
add_action( 'admin_print_styles-post-new.php', 'events_styles', 1000 );



function events_scripts() {
  global $post_type;
  if( 'na_events' != $post_type )
    return;
  wp_enqueue_script('jquery-ui', get_bloginfo('template_url') . '/inc/na_events/js/jquery.ui.core.js', array('jquery'), null, true);
  //wp_enqueue_script('jquery-ui', get_bloginfo('template_url') . '/inc/na_events/js/jquery-ui-1.8.9.custom.min.js', array('jquery'), null, true);
  wp_enqueue_script('ui-datepicker', get_bloginfo('template_url') . '/inc/na_events/js/jquery.ui.datepicker.js', array('jquery'), null, true);
  wp_enqueue_script('datepicker-custom', get_bloginfo('template_url').'/inc/na_events/js/datepicker-custom.js', array('jquery'), null, true);
  $theme_data = array( 
    'template_url' => get_bloginfo('template_url') 
  );
  /** @link http://codex.wordpress.org/Function_Reference/wp_localize_script */
  wp_localize_script( 'datepicker-custom', 'theme_data', $theme_data );
}
add_action( 'admin_print_scripts-post.php', 'events_scripts', 1000 );
add_action( 'admin_print_scripts-post-new.php', 'events_scripts', 1000 );

?>
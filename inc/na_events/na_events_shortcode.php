<?php
/* ------------------- THEME FORCE ---------------------- */

/**
 * EVENTS SHORTCODES (CUSTOM POST TYPE)
 * @link http://www.noeltock.com/web-design/wordpress/how-to-custom-post-types-for-events-pt-2/
 */

// 1) FULL EVENTS
//***********************************************************************************

function na_events_full ( $atts ) {

// - define arguments -
extract(shortcode_atts(array(
  'limit' => '10', // # of events to show
  'group' => 'all', // # of events to show
   ), $atts));

// ===== OUTPUT FUNCTION =====

ob_start();

// ===== LOOP: FULL EVENTS SECTION =====

// - hide events that are older than 6am today (because some parties go past your bedtime) -

$today6am = strtotime('today 6:00') + ( get_option( 'gmt_offset' ) * 3600 );

// - query -
global $wpdb;

if ($group == 'all'):
  $querystr = "
    SELECT *
    FROM $wpdb->posts wposts, $wpdb->postmeta metastart, $wpdb->postmeta metaend
    WHERE (wposts.ID = metastart.post_id AND wposts.ID = metaend.post_id)
    AND (metaend.meta_key = 'na_events_enddate' AND metaend.meta_value > $today6am )
    AND metastart.meta_key = 'na_events_enddate'
    AND wposts.post_type = 'na_events'
    AND wposts.post_status = 'publish'
    ORDER BY metastart.meta_value ASC LIMIT $limit
  ";
else :
  $querystr = "
    SELECT *
    FROM $wpdb->postmeta metastart, $wpdb->postmeta metaend, $wpdb->posts
    LEFT JOIN $wpdb->term_relationships ON($wpdb->posts.ID = $wpdb->term_relationships.object_id)
    LEFT JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
    LEFT JOIN $wpdb->terms ON($wpdb->terms.term_id = $wpdb->term_taxonomy.term_id)
    WHERE ($wpdb->posts.ID = metastart.post_id AND $wpdb->posts.ID = metaend.post_id)
    AND $wpdb->term_taxonomy.taxonomy = 'na_eventcategory'
    AND $wpdb->terms.name = '$group'
    AND (metaend.meta_key = 'na_events_enddate' AND metaend.meta_value > $today6am )
    AND metastart.meta_key = 'na_events_enddate'
    AND $wpdb->posts.post_type = 'na_events'
    AND $wpdb->posts.post_status = 'publish'
    ORDER BY metastart.meta_value ASC LIMIT $limit
  ";
endif;
$events = $wpdb->get_results($querystr, OBJECT);

// - declare fresh day -
$daycheck = null;

// - loop -
if ($events):
  global $post;
  echo '<section class="event-list">';
  foreach ($events as $post):
    setup_postdata($post);
    
    // - custom variables -
    $custom = get_post_custom(get_the_ID());
    $sd = $custom["na_events_startdate"][0];
    $ed = $custom["na_events_enddate"][0];
    
    // - determine if it's a new day -
    $longdate = date("l, F j, Y", $sd);
    if ($daycheck == null) { echo '<h2 class="date next">' . $longdate . '</h2>'; }
    if ($daycheck != $longdate && $daycheck != null) { echo '<h2 class="date">' . $longdate . '</h2>'; }
    
    // - local time format -
    $time_format = get_option('time_format');
    $stime = date($time_format, $sd);
    $etime = date($time_format, $ed);
    
    // - output - 
    get_template_part( 'content', 'post-highlight' );
    
    // - fill daycheck with the current day -
    $daycheck = $longdate;
  endforeach;
  echo '</section>';
  else :
endif;

// ===== RETURN: FULL EVENTS SECTION =====

$output = ob_get_contents();
ob_end_clean();
return $output;
}

add_shortcode('events', 'na_events_full'); 
// You can now call onto this shortcode with [na-events-full limit='20' group='featured']

?>
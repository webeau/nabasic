<?php
/*
enhanced_link_pages() function taken from ePage Links plugin by Rich Pedley (http://quirm.net/)
Alternative for wp_link_pages to be able to specifiy wrappers for each link. Simply use <code>enhanced_link_pages(array('blink'=&gt;'&lt;li&gt;','alink'=&gt;'&lt;/li&gt;','before' =&gt; '&lt;ul&gt;', 'after' =&gt; '&lt;/ul&gt;', 'next_or_number' =&gt; 'number'));</code> in place of wp_link_pages in your themes. 
eg. enhanced_link_pages(array('blink'=>'<li>','alink'=>'</li>','before' => '<ul>', 'after' => '</ul>', 'next_or_number' => 'number')); 
*/
function enhanced_link_pages($args = '') {
  global $post;

  if ( is_array($args) )
    $r = &$args;
  else
    parse_str($args, $r);

  $defaults = array('before' => '<p>' . __('Pages:'), 'after' => '</p>', 'next_or_number' => 'number', 'nextpagelink' => __('Next page'),
      'previouspagelink' => __('Previous page'), 'pagelink' => '%', 'more_file' => '', 'echo' => 1, 'blink'=>'','alink'=>'');
  $r = array_merge($defaults, $r);
  extract($r, EXTR_SKIP);

  global $id, $page, $numpages, $multipage, $more, $pagenow;
  if ( $more_file != '' )
    $file = $more_file;
  else
    $file = $pagenow;

  $output = '';
  if ( $multipage ) {
    if ( 'number' == $next_or_number ) {
      $output .= $before;
      for ( $i = 1; $i < ($numpages+1); $i = $i + 1 ) {
        $j = str_replace('%',"$i",$pagelink);
        $output .= ' ';
        if ( ($i != $page) || ((!$more) && ($page==1)) ) {
          if ( 1 == $i ) {
            $output .= $blink.'<a href="' . get_permalink() . '">'.$j.'</a>'.$alink;
          } else {
            if ( '' == get_option('permalink_structure') || 'draft' == $post->post_status )
              $output .= $blink.'<a href="' . get_permalink() . '&amp;page=' . $i . '">'.$j.'</a>'.$alink;
            else
              $output .= $blink.'<a href="' . trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged') . '">'.$j.'</a>'.$alink;
          }
        }else{
          $output .= $blink.'<span>'.$j.'</span>'.$alink;
        }
      }
      $output .= $after;
    } else {
      if ( $more ) {
        $output .= $before;
        $i = $page - 1;
        if ( $i && $more ) {
          if ( 1 == $i ) {
            $output .= $blink.'<a href="' . get_permalink() . '">' . $previouspagelink . '</a>'.$alink;
          } else {
            if ( '' == get_option('permalink_structure') || 'draft' == $post->post_status )
              $output .= $blink.'<a href="' . get_permalink() . '&amp;page=' . $i . '">' . $previouspagelink . '</a>'.$alink;
            else
              $output .= $blink.'<a href="' . trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged') . '">' . $previouspagelink . '</a>'.$alink;
          }
        }
        $i = $page + 1;
        if ( $i <= $numpages && $more ) {
          if ( 1 == $i ) {
            $output .= $blink.'<a href="' . get_permalink() . '">' . $nextpagelink . '</a>'.$alink;
          } else {
            if ( '' == get_option('permalink_structure') || 'draft' == $post->post_status )
              $output .= $blink.'<a href="' . get_permalink() . '&amp;page=' . $i . '">' . $nextpagelink . '</a>'.$alink;
            else
              $output .= $blink.'<a href="' . trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged') . '">' . $nextpagelink . '</a>'.$alink;
          }
        }
        $output .= $after;
      }
    }
  }

  if ( $echo )
    echo $output;

  return $output;
}
<?php

/** BREADCRUMBS
 * @link http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
 * @link http://twitter.github.com/bootstrap/components.html#breadcrumbs
 */

function na_breadcrumbs() {

  /* === OPTIONS === */
  $text['home']     = __('HOME', 'nabasic'); // text for the 'Home' link
  $text['category'] = __('Archive by Category ', 'nabasic').'"%s"'; // text for a category page
  $text['search']   = __('Search results for ', 'nabasic').'"%s"'; // text for a search results page
  $text['tag']      = __('Posts tagged with ', 'nabasic').'"%s"'; // text for a tag page
  $text['author']   = __('Articles postet by ', 'nabasic').'%s'; // text for an author page
  $text['404']      = __('Error 404', 'nabasic'); // text for the 404 page

  //$showCurrent = 0; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $showOnPost = true; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $showOnPage = true; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $showOnOtherPostType = true; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $showOnAttachment = true; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $showOnHome  = false; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $showOnCategory  = false; // 1 - show breadcrumbs on the category page, 0 - don't show
  $showOnSearch  = false; // 1 - show breadcrumbs on the category page, 0 - don't show
  $showOnTimeArchive  = false; // 1 - show breadcrumbs on the category page, 0 - don't show
  $showOnTag  = false; // 1 - show breadcrumbs on the category page, 0 - don't show
  $showOnAuthor  = false; // 1 - show breadcrumbs on the category page, 0 - don't show
  $showOn404  = false; // 1 - show breadcrumbs on the category page, 0 - don't show
  $delimiter   = '<li class="divider">/</li>'; // delimiter between crumbs
  $before      = '<li class="active">'; // tag before the current crumb
  $after       = '</li>'; // tag after the current crumb
  /* === END OF OPTIONS === */

  global $post;
  $homeLink = get_bloginfo('url') . '/';
  $linkBefore = '<li typeof="v:Breadcrumb">';
  $linkAfter = '</li>';
  $linkAttr = ' rel="v:url" property="v:title"';
  $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
  $wrapstart = '<ul id="na_breadcrumbs" class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $text['home']) . $delimiter;
  $wrapend = '</ul>';
  $paged = '';
  if ( get_query_var('paged') ) {
    if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
    $paged = __('Page') . ' ' . get_query_var('paged');
    if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
  }

  if (is_home() || is_front_page()) {

    if ($showOnHome) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

  } else {

    //echo '<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

    if ( is_category() && $showOnCategory == 1) {
      $thisCat = get_category(get_query_var('cat'), false);
      if ($thisCat->parent != 0) {
        $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
        echo $cats;
      }
      echo $wrapstart . $before . sprintf($text['category'], single_cat_title('', false)) . $after . $paged . $wrapend;

    } elseif ( is_search() && $showOnSearch) {
      echo $wrapstart . $before . sprintf($text['search'], get_search_query()) . $after . $paged . $wrapend;

    } elseif ( is_day() && $showOnTimeArchive ) {
      echo $wrapstart . sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
      echo $before . get_the_time('d') . $after . $paged . $wrapend;

    } elseif ( is_month() && $showOnTimeArchive ) {
      echo $wrapstart . sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo $before . get_the_time('F') . $after . $paged . $wrapend;

    } elseif ( is_year() && $showOnTimeArchive ) {
      echo $wrapstart . $before . get_the_time('Y') . $after . $paged . $wrapend;

    } elseif ( is_single() && !is_attachment() && $showOnPost ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo $wrapstart;
        printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
        echo $delimiter . $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, $delimiter);
        //if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
        if (!$showOnPost) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
        echo $wrapstart . $cats;
        echo $before . get_the_title() . $after . $wrapend;
      }

    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() && $showOnOtherPostType ) {
      $post_type = get_post_type_object(get_post_type());
      echo $wrapstart . $before . $post_type->labels->singular_name . $after . $wrapend;

    } elseif ( is_attachment() && $showOnAttachment) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      $cats = get_category_parents($cat, TRUE, $delimiter);
      $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
      $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
      echo $wrapstart . $cats;
      printf($link, get_permalink($parent), $parent->post_title);
      echo $delimiter . $before . get_the_title() . $after . $wrapend;

    } elseif ( is_page() && !$post->post_parent && $showOnPage) {
      echo $wrapstart . $before . get_the_title() . $after . $wrapend;

    } elseif ( is_page() && $post->post_parent && $showOnPage) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      for ($i = 0; $i < count($breadcrumbs); $i++) {
        echo $breadcrumbs[$i];
        if ($i != count($breadcrumbs)-1) echo $delimiter;
      }
      echo $wrapstart . $delimiter . $before . get_the_title() . $after . $wrapend;

    } elseif ( is_tag() && $showOnTag ) {
      echo $wrapstart . $before . sprintf($text['tag'], single_tag_title('', false)) . $after . $paged . $wrapend;

    } elseif ( is_author() && $showOnAuthor ) {
      global $author;
      $userdata = get_userdata($author);
      echo $wrapstart . $before . sprintf($text['author'], $userdata->display_name) . $after . $paged . $wrapend;

    } elseif ( is_404() && $showOn404 ) {
      echo $wrapstart . $before . $text['404'] . $after . $wrapend;
    }

    //echo '</div>';

  }
} // end na_breadcrumbs()


?>
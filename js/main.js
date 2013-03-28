/* stick div to top after scrolling
 * @link http://stackoverflow.com/a/2153775/874048
 */


$(function() {
  firstlast(); // add first/last class to list items and articles within sections
  comment_permalink_toggle(); // show or hide permalink below comment
  wpml_topnavsubmenu_toggle(); // wpml language switcher topnavi
  comment_form_submit_add_class(); // add bootstrap class to submit button
  scrollto_defaults(); // various scrollTo functions
  smooth_anker_scroll();
});

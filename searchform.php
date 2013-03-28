<?php 
// search form 
// @link http://codex.wordpress.org/Function_Reference/get_search_form#Examples
?>
<form method="get" id="searchform" class="navbar-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <label for="s" class="assistive-text"><?php _e( 'Search', 'nabasic' ); ?></label>
  <input type="text" class="field" name="s" id="s" value="<?php get_search_query()?the_search_query():esc_attr_e( 'Search', 'nabasic' ); ?>" onfocus="if (this.value == '<?php get_search_query()?the_search_query():esc_attr_e( 'Search', 'nabasic' ); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php get_search_query()?the_search_query():esc_attr_e( 'Search', 'nabasic' ); ?>';}" />
  <button type="submit" class="submit btn btn-primary" name="submit" id="searchsubmit"><i class="icon-search icon-white"></i> <?php //esc_attr_e( 'Search', 'nabasic' ); ?></button>
</form>

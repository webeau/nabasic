<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php printf(__('%1$s - Comments on %2$s'), get_option('blogname'), the_title('','',false)); ?></title>
    <meta name="description" content="<?php bloginfo( 'description' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11" />

    <link rel="stylesheet" href="<?php bloginfo("template_url"); ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php bloginfo("template_url"); ?>/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="<?php bloginfo("template_url"); ?>/css/structure.css">
    <link rel="stylesheet" href="<?php bloginfo("template_url"); ?>/css/main.css">

    <script src="<?php bloginfo("template_url"); ?>/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php wp_head(); ?>

    <!--[if gte IE 9]>
      <style type="text/css">
        .gradient {
           filter: none;
        }
      </style>
    <![endif]-->
  </head>
<body id="commentspopup">

      <header id="masthead" class="" role="banner">
        <div class="na-wrapper">
          <div class="na-wbox">
        
            <hgroup class="page-header">
              <?php if(get_theme_mod('logo')): ?>
                <h1 id="site-title">
                  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?>" rel="home"><img src="<?php echo get_theme_mod('logo'); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
                  <?php if(get_theme_mod('display_description')): ?>
                    <small id="site-description"><?php bloginfo( 'description' ); ?></small>
                  <?php endif; ?>
                </h1>
              <?php else: ?>
                <h1 id="site-title">
                  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?>" rel="home">
                    <?php bloginfo( 'name' ); ?>
                  </a>
                  <?php if(get_theme_mod('display_description')): ?>
                    <small id="site-description"><?php bloginfo( 'description' ); ?></small>
                  <?php endif; ?>
                </h1>
              <?php endif; ?>
            </hgroup>
        
          </div><?php //.na-wrapper ?>
        </div><?php //.na-wbox ?>
      </header>

      <div id="main">

      <div class="na-wrapper">
        <div class="na-wbox">

          <div class="na-column2">

            <div class="na-col2">
              <section id="comments" class="na-cbox clearfix popup" role="main">

<?php
/* Don't remove these lines. */
add_filter('comment_text', 'popuplinks');
if ( have_posts() ) :
while( have_posts()) : the_post();
?>

<header>
  <h1 id="comments"><?php _e('Comments'); ?></h1>
  
  <div class="info">
    <a href="<?php echo esc_url( get_post_comments_feed_link($post->ID) ); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.'); ?></a>
    <?php if ( pings_open() ) { ?>
      <br><?php printf(__('The <abbr title="Universal Resource Locator">URL</abbr> to TrackBack this entry is: <em>%s</em>'), get_trackback_url()); ?>
    <?php } ?>
  </div>
</header>

<div class="comments-area">

  <?php
  // this line is WordPress' motor, do not delete it.
  $commenter = wp_get_current_commenter();
  extract($commenter);
  $comments = get_approved_comments($id);
  $post = get_post($id);
  if ( post_password_required($post) ) {  // and it doesn't match the cookie
  	echo(get_the_password_form());
  } else { ?>
  
  <?php if ($comments) { ?>
  <ol id="commentlist">
  <?php foreach ($comments as $comment) { ?>
  	<li id="comment-<?php comment_ID() ?>">

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

    </article><!-- #comment-## -->

  	</li>
  
  <?php } // end for each comment ?>
  </ol>


  <?php } else { // this is displayed if there are no comments so far ?>
  	<p><?php _e('No comments yet.'); ?></p>
  <?php } ?>
  


  <?php if ( comments_open() ) { ?>


  <div id="respond">
    
    <h3 id="reply-title"><?php _e('Leave a comment'); ?></h3>
    
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
    <?php if ( $user_ID ) : ?>
    	<p class="logged-in-as"><?php printf(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out &raquo;</a>'), get_edit_user_link(), $user_identity, wp_logout_url(get_permalink())); ?></p>
    <?php else : ?>
      <p class="comment-form-author">
        <label class="assistive-text" for="author"><?php _e( 'Name', 'nabasic' ) ?></label> 
        <input id="author" class="input-xlarge" placeholder="<?php  _e( 'Name', 'nabasic' ) ?>" name="author" type="text" value="<?php echo esc_attr($comment_author); ?>" size="30" />
      </p>
      <p class="comment-form-email">
        <label class="assistive-text" for="email"><?php  _e( 'Email', 'nabasic' ) ?></label> 
        <input id="email" class="input-xlarge" placeholder="<?php  _e( 'Email', 'nabasic' ) ?>" name="email" type="text" value="<?php echo esc_attr($comment_author_email); ?>" size="30" />
        <span class="help-inline"><?php  _e( 'Your email address will not be published.' ) ?></span>
      </p>
      <p class="comment-form-url">
        <label class="assistive-text" for="url"><?php  _e( 'Website', 'nabasic' ) ?></label>
        <input id="url" class="input-xlarge" placeholder="<?php  _e( 'Website', 'nabasic' ) ?>" name="url" type="text" value="<?php echo esc_attr($comment_author_url); ?>" size="30" />
      </p>
    <?php endif; ?>
    

      <p class="comment-form-comment">
        <label class="assistive-text" for="comment"><?php _ex( 'Comment', 'noun' ) ?></label>
        <textarea id="comment" class="input-xlarge" name="comment"  placeholder="<?php _ex( 'Comment', 'noun' ) ?>" cols="45" rows="8"></textarea>
        <span class="help-inline"><?php echo sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <br><span class="allowed_tags">' . allowed_tags() . '</span>' ) ?></span>
      </p>
    
    	<p>
    	  <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
    	  <input type="hidden" name="redirect_to" value="<?php echo esc_attr($_SERVER["REQUEST_URI"]); ?>" />
    	  <input class="btn btn-primary" name="submit" type="submit" tabindex="5" value="<?php esc_attr_e('Say It!' ); ?>" />
    	</p>
    	<?php do_action('comment_form', $post->ID); ?>
    </form>
    <?php } else { // comments are closed ?>
      <p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>
    <?php }
    } // end password check
    ?>
  
  </div><?php // #respond ?>

  <div class="windowclose"><a href="javascript:window.close()" class="btn btn-inverse"><i class="icon-remove icon-white"></i> <?php _e('Close this window.'); ?></a></div>
  
  <?php // if you delete this the sky will fall on your head
  endwhile; // have_posts()
  else: // have_posts()
  ?>
  <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
  <?php endif; ?>
  <!-- // this is just the end of the motor - don't touch that line either :) -->
  <?php //} ?>
  <script type="text/javascript">
  <!--
  document.onkeypress = function esc(e) {
  	if(typeof(e) == "undefined") { e=event; }
  	if (e.keyCode == 27) { self.close(); }
  }
  // -->
  </script>

</div><?php // .comments-area ?>

              </section><?php // #content.na-cbox ?>
            </div><?php // .na-col2 ?>

          </div><?php // .na-column23 ?>

        </div><?php // .na-wbox ?>
      </div><?php // .na-wrapper ?>

  </div><!-- #main .wrapper -->
</body>
</html>

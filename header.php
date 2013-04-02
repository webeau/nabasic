<!DOCTYPE HTML>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js gt-ie8" <?php language_attributes(); ?>> <!--<![endif]-->
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php wp_head(); ?>
  </head>
  
  <body <?php body_class(); ?>>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

    <pre id="console" style="position:fixed;bottom:0;width:50%;z-index: 3000;display:none;"></pre>

    <div id="stage" class="container">
    <div><?php //scroller-element >> first element after stage will be be scrolled ?>

      <header id="masthead" class="" role="banner">
        <div class="na-wrapper">
          <div class="na-wbox" id="header-stage">
        
            <hgroup class="page-header <?php echo display_header_text()?'':'assistive-text'; ?>">
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
                  <?php if(get_theme_mod( 'display_description', true ) != false): ?>
                    <small id="site-description"><?php bloginfo( 'description' ); ?></small>
                  <?php endif; ?>
                </h1>
              <?php endif; ?>
            </hgroup>

            <?php if(get_header_image() != '') {
              echo '<div class="teaser">';
              echo '<a href="';
              echo esc_url( home_url( '/' ) );
              echo '" title="'.esc_attr( get_bloginfo( 'description', 'display' ) ).'" rel="home">';
              echo '<img src="'.get_header_image().'" />';
              echo '</a>';
              echo '</div>';
            }; ?>

            <nav id="site-navigation" class="navbar" role="navigation">
              <h1 class="assistive-text"><?php _e( 'Site-Menu', 'nabasic' ); ?></h1>
              <a class="assistive-text" href="#main" id="scrollTo-Content" title="<?php esc_attr_e( 'Skip to content', 'nabasic' ); ?>"><?php _e( 'Skip to content', 'nabasic' ); ?></a>
              <div class="navbar-inner">
                <?php wp_nav_menu(array( 
                  'theme_location'  => 'top-menu',
                  'menu_class'      => 'nav top-menu',
                  'fallback_cb'     => false,
                  //Process nav menu using our custom nav walker
                  'walker' => new twitter_bootstrap_nav_walker(),
                )); ?>
              </div>
            </nav><!-- #main-navigation -->

            <?php if ( has_nav_menu( 'main-menu' ) ) : ?>
            <div id="main-navigation-anchor"></div>
            <nav id="main-navigation" class="navbar" role="navigation">
              <h1 class="assistive-text"><?php _e( 'Main-Menu', 'nabasic' ); ?></h1>
              <div class="navbar-inner">
                <a class="pull-right navbar-text" id="scrollTo-Top" title="<?php _e('Scroll to top','nabasic')?>"><i class="icon-arrow-up"></i></a>
                <?php if(!is_search()){get_search_form();}?>
                <?php if(get_theme_mod('logo')): ?>
                  <a class="brand img" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?>" rel="home"><img src="<?php echo get_theme_mod('logo'); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
                <?php else: ?>
                  <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                <?php endif; ?>
                <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                <a class="btn btn-navbar pull-left" data-toggle="collapse" data-target=".nav-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </a>
                <?php wp_nav_menu(array( 
                  'theme_location'  => 'main-menu',
                  'menu_class'      => 'nav nav-pills',
                  'container'       => 'div',
                  'container_class' => 'nav-collapse collapse',
                  'fallback_cb'     => false,
                  //Process nav menu using our custom nav walker
                  'walker' => new twitter_bootstrap_nav_walker(),
                  //'items_wrap'      => '<a class="brand" href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo( 'description', 'display' ) ).'" rel="home">'.get_bloginfo( 'name' ).'</a><ul id="%1$s" class="%2$s">%3$s</ul>',
                )); ?>
              </div>
            </nav><!-- #main-navigation -->
            <?php endif; ?>
                         
          </div><?php //.na-wrapper ?>
        </div><?php //.na-wbox ?>
      </header>
    
      <div id="main">

      <div class="na-wrapper">
        <div class="na-wbox">

        <?php if ( has_nav_menu( 'main-content-menu' ) ) : ?>
        <nav id="maincontent-navigation" role="navigation">
          <h1 class="assistive-text"><?php _e( 'Main-Content-Menu', 'nabasic' ); ?></h1>
          <?php wp_nav_menu(array( 
            'theme_location'  => 'main-content-menu',
            'menu_class'      => 'nav nav-pills',
            'container'       => 'div',
            'container_class' => '',
            'fallback_cb'     => false,
            //Process nav menu using our custom nav walker
            'walker' => new twitter_bootstrap_nav_walker(),
            //'items_wrap'      => '<a class="brand" href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo( 'description', 'display' ) ).'" rel="home">'.get_bloginfo( 'name' ).'</a><ul id="%1$s" class="%2$s">%3$s</ul>',
          )); ?>
        </nav><!-- #main-navigation -->
        <?php endif; ?>
                         
        <?php if (function_exists('na_breadcrumbs') && get_theme_mod('show_breadcrumb_navi')) na_breadcrumbs(); ?>

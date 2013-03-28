  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header>
      <h1<?php echo !get_theme_mod('display_page_title')?' class="assistive-text"':''; ?>><?php the_title(); ?></h1>
    </header>

    <div>
      <?php the_content(); ?>
    </div>
    
    <footer class="clearfix">
      <?php if(function_exists('enhanced_link_pages')) {
          enhanced_link_pages(array(
            'blink'=>'<li>', 
            'alink'=>'</li>', 
            'before' => '<div class="pagination pagination-right"><ul><li class="disabled"><a>' . __( 'Pages:', 'nabasic' ) . '</a></li>', 
            'after' => '</ul></div>', 
            'next_or_number' => 'number'
          ));
        } ?>
      <?php edit_post_link( __( 'edit', 'nabasic' ), '<i class="icon-pencil" title="'.__( 'edit', 'nabasic' ).'"></i> <span class="edit-link">', '</span>' ); ?>
    </footer>
  </article>

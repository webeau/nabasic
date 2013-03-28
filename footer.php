        </div><?php // .na-wbox ?>
      </div><?php // .na-wrapper ?>

      </div><?php //#main ?>
      
      <footer>
        <div class="na-wrapper">
          <div class="na-wbox">
            
            <?php 
              $sbcounter = 0;
              $sb_span_class = 'span12';
              if(is_active_sidebar( 'footer-1' )) {$sbcounter++;}
              if(is_active_sidebar( 'footer-2' )) {$sbcounter++;}
              if(is_active_sidebar( 'footer-3' )) {$sbcounter++;}
              if(is_active_sidebar( 'footer-4' )) {$sbcounter++;}
              switch($sbcounter){
                case 1: $sb_span_class = 'span12';break;
                case 2: $sb_span_class = 'span6';break;
                case 3: $sb_span_class = 'span4';break;
                case 4: $sb_span_class = 'span3';break;
              }
              if($sbcounter != 0){
                echo '<div class="footer-area row-fluid">';
                if(is_active_sidebar( 'footer-1' )){
                  echo '<div class="'.$sb_span_class.'">';
                  dynamic_sidebar('footer-1');
                  echo '</div>';
                }
                if(is_active_sidebar( 'footer-2' )){
                  echo '<div class="'.$sb_span_class.'">';
                  dynamic_sidebar('footer-2');
                  echo '</div>';
                }
                if(is_active_sidebar( 'footer-3' )){
                  echo '<div class="'.$sb_span_class.'">';
                  dynamic_sidebar('footer-3');
                  echo '</div>';
                }
                if(is_active_sidebar( 'footer-4' )){
                  echo '<div class="'.$sb_span_class.'">';
                  dynamic_sidebar('footer-4');
                  echo '</div>';
                }
                echo '</div>';  
              }
            ?>

            <?php 
              if(is_active_sidebar( 'copyright' )){
                echo '<div class="copyright">';
                dynamic_sidebar('copyright');
                echo '</div>';
              }
            ?>
            
          </div><?php //.na-wrapper ?>
        </div><?php //.na-wbox ?>
      </footer>

    </div><?php //scroller-element >> first element after stage will be be scrolled ?>
    </div><?php //#stage ?>

    <?php wp_footer(); ?>

  </body>
</html>
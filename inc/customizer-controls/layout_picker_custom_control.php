<?php
if (class_exists('WP_Customize_Control')) {
    /**
     * Class to create a custom layout control
     */
    class Layout_Picker_Custom_control extends WP_Customize_Control {
          /**
           * Render the content on the theme customizer page
           */
          public function render_content() {
                ?>  
                    <style>
                      .layout-picker li {width: 50%;float: left;}
                      .layout-picker input {height:40px;vertical-align:top;}
                    </style>
                    <div class="layout-picker">
                      <span class="customize-layout-control"><?php echo esc_html( $this->label ); ?></span>
                      <ul>
                        <li>
                          <input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>2" value="2" <?php $this->link(); ?><?php echo($this->value() == '2'?'checked="checked" ':''); ?>/>
                          <label for="<?php echo $this->id; ?>2"><img src="<?php bloginfo("template_url"); ?>/inc/customizer-controls/img/2.png" alt="No Sidebar" title="No Sidebar" /></label>
                        </li>
                        <li>
                          <input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>123" value="123" <?php $this->link(); ?><?php echo($this->value() == '123'?'checked="checked" ':''); ?>/>                          
                          <label for="<?php echo $this->id; ?>123"><img src="<?php bloginfo("template_url"); ?>/inc/customizer-controls/img/123.png" alt="Right and Left Sidebar" title="Right and Left Sidebar" /></label>
                        </li>
                        <li>
                          <input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>23" value="23" <?php $this->link(); ?><?php echo($this->value() == '23'?'checked="checked" ':''); ?>/>
                          <label for="<?php echo $this->id; ?>23"><img src="<?php bloginfo("template_url"); ?>/inc/customizer-controls/img/23.png" alt="Right Sidebar" title="Right Sidebar >> mobile on Bottom" /></label>
                        </li>
                        <li>
                          <input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>32" value="32" <?php $this->link(); ?><?php echo($this->value() == '32'?'checked="checked" ':''); ?>/>
                          <label for="<?php echo $this->id; ?>32"><img src="<?php bloginfo("template_url"); ?>/inc/customizer-controls/img/32.png" alt="Left Sidebar" title="Left Sidebar >> mobile on Bottom" /></label>
                        </li>
                        <li>
                          <input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>12" value="12" <?php $this->link(); ?><?php echo($this->value() == '12'?'checked="checked" ':''); ?>/>
                          <label for="<?php echo $this->id; ?>12"><img src="<?php bloginfo("template_url"); ?>/inc/customizer-controls/img/12.png" alt="Left Sidebar" title="Left Sidebar >> mobile on Top" /></label>
                        </li>
                        <li>
                          <input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>21" value="21" <?php $this->link(); ?><?php echo($this->value() == '21'?'checked="checked" ':''); ?>/>
                          <label for="<?php echo $this->id; ?>21"><img src="<?php bloginfo("template_url"); ?>/inc/customizer-controls/img/21.png" alt="Right Sidebar" title="Right Sidebar >> mobile on Top" /></label>
                        </li>
                      </ul>
                    </div>
                <?php
           }
    }
}
?>
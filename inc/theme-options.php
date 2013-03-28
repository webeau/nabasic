<?php
/**
 * Contains methods for customizing the theme customization screen.
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since nabasic 0.1
 */
class nabasic_Customize
{
   
   /**
    * This hooks into 'customize_register' (available as of WP 3.4) and allows
    * you to add new sections and controls to the Theme Customize screen.
    * 
    * Note: To enable instant preview, we have to actually write a bit of custom
    * javascript. See live_preview() for more.
    *  
    * @see add_action('customize_register',$func)
    * @param \WP_Customize_Manager $wp_customize
    * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
    * @link http://wp.tutsplus.com/tutorials/theme-development/digging-into-the-theme-customizer-practicing-i/
    * @since nabasic 0.1
    */
   public static function register ( $wp_customize )
   {
      
// * * * * * SECTION (default): title_tagline - Site Title & Tagline * * * * * //

      $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
      $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

      $wp_customize->add_setting( 'display_description', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => true, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_description', array(
            'label' => __( 'Show description', 'nabasic' ), //Admin-visible name of the control
            'section' => 'title_tagline', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_description', //Which setting to load and manipulate (serialized is okay)
            'priority' => 14, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'logo', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new WP_Customize_Image_Control(
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_logo', //Set a unique ID for the control
         array(
            'label' => __( 'Logo', 'nabasic' ), //Admin-visible name of the control
            'section' => 'title_tagline', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'logo', //Which setting to load and manipulate (serialized is okay)
            'priority' => 15, //Determines the order this control appears in for the specified section
         ) 
      ));

// * * * * * SECTION (default): colors - Colors  * * * * * //

      $wp_customize->add_setting( 'bg_textcolor', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#333', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_bg_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Text Color', 'nabasic' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'bg_textcolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 1, //Determines the order this control appears in for the specified section
         ) 
      ));

      $wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
      $wp_customize->get_setting( 'background_color' )->default = '#f2f2f2';

      $wp_customize->add_setting( 'bg_linkcolor', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#0088cc', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_bg_linkcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Link Color', 'nabasic' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'bg_linkcolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
         ) 
      ));

      $wp_customize->add_setting( 'bg_link_decoration', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_bg_link_decoration', array(
            'label' => __( 'Underline links', 'nabasic' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'bg_link_decoration', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'bg_linkcolor_hover', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#005580', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_bg_linkcolor_hover', //Set a unique ID for the control
         array(
            'label' => __( 'Link Color hover/focus', 'nabasic' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'bg_linkcolor_hover', //Which setting to load and manipulate (serialized is okay)
            'priority' => 12, //Determines the order this control appears in for the specified section
         ) 
      ));

      $wp_customize->add_setting( 'bg_link_decoration_hover', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => true, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_bg_link_decoration_hover', array(
            'label' => __( 'Underline links on hover/focus', 'nabasic' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'bg_link_decoration_hover', //Which setting to load and manipulate (serialized is okay)
            'priority' => 13, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));


// * * * * * SECTION (default): header_image - Header Image  * * * * * //

      $wp_customize->add_setting( 'activate_header_img_fader', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_activate_header_img_fader', array(
            'label' => __( 'Activate header image fader', 'nabasic' ), //Admin-visible name of the control
            'section' => 'header_image', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'activate_header_img_fader', //Which setting to load and manipulate (serialized is okay)
            'priority' => 20, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));
      
      $wp_customize->add_setting( 'header_img_fader_sleep_time', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '8000', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_positive_number'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_header_img_fader_sleep_time', array(
            'label' => __( 'Pause time between fading (ms)', 'nabasic' ), //Admin-visible name of the control
            'section' => 'header_image', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'header_img_fader_sleep_time', //Which setting to load and manipulate (serialized is okay)
            'priority' => 21, //Determines the order this control appears in for the specified section
      ));
      
      $wp_customize->add_setting( 'header_img_fader_fade_time', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '1000', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_positive_number'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_header_img_fader_fade_time', array(
            'label' => __( 'Fade time (ms)', 'nabasic' ), //Admin-visible name of the control
            'section' => 'header_image', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'header_img_fader_fade_time', //Which setting to load and manipulate (serialized is okay)
            'priority' => 22, //Determines the order this control appears in for the specified section
      ));
      
// * * * * * SECTION (default): background_image - Background Image  * * * * * //

      $wp_customize->add_setting( 'bg_cover', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_bg_cover', array(
            'label' => __( 'Background as Cover', 'nabasic' ), //Admin-visible name of the control
            'section' => 'background_image', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'bg_cover', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));
      
      $wp_customize->add_setting( 'activate_bg_img_fader', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_activate_bg_img_fader', array(
            'label' => __( 'Activate background image fader', 'nabasic' ), //Admin-visible name of the control
            'section' => 'background_image', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'activate_bg_img_fader', //Which setting to load and manipulate (serialized is okay)
            'priority' => 20, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));
      
      $wp_customize->add_setting( 'bg_img_fader_sleep_time', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '8000', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_positive_number'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_bg_img_fader_sleep_time', array(
            'label' => __( 'Pause time between fading (ms)', 'nabasic' ), //Admin-visible name of the control
            'section' => 'background_image', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'bg_img_fader_sleep_time', //Which setting to load and manipulate (serialized is okay)
            'priority' => 21, //Determines the order this control appears in for the specified section
      ));
      
      $wp_customize->add_setting( 'bg_img_fader_fade_time', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '1000', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_positive_number'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_bg_img_fader_fade_time', array(
            'label' => __( 'Fade time (ms)', 'nabasic' ), //Admin-visible name of the control
            'section' => 'background_image', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'bg_img_fader_fade_time', //Which setting to load and manipulate (serialized is okay)
            'priority' => 22, //Determines the order this control appears in for the specified section
      ));
      
// * * * * * SECTION (default): nav - Navigation  * * * * * //

      $wp_customize->add_setting( 'fixed_main_navi', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_fixed_main_navi', array(
            'label' => __( 'Keep main-Menu on top', 'nabasic' ), //Admin-visible name of the control
            'section' => 'nav', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'fixed_main_navi', //Which setting to load and manipulate (serialized is okay)
            'priority' => 20, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));
      
      $wp_customize->add_setting( 'show_breadcrumb_navi', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_show_breadcrumb_navi', array(
            'label' => __( 'Show breadcrumbs', 'nabasic' ), //Admin-visible name of the control
            'section' => 'nav', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'show_breadcrumb_navi', //Which setting to load and manipulate (serialized is okay)
            'priority' => 21, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));
      
      $wp_customize->add_setting( 'show_comments_pagination', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => true, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_show_comments_pagination', array(
            'label' => __( 'Show pagination for comments', 'nabasic' ), //Admin-visible name of the control
            'section' => 'nav', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'show_comments_pagination', //Which setting to load and manipulate (serialized is okay)
            'priority' => 24, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));
      
// * * * * * SECTION (default): static_front_page - Static Front Page  * * * * * //

// * * * * * SECTION: Theme Layout * * * * * //
      $wp_customize->add_section( 'theme_layout', array(
            'title' => __( 'Theme Layout', 'nabasic' ), //Visible title of section
            'priority' => 200, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to define the default theme layout.', 'nabasic'), //Descriptive tooltip
      ));

      $wp_customize->add_setting( 'default_structure', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '23', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new Layout_Picker_Custom_control( //Instantiate the Layout_Picker_Custom_control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_default_structure', //Set a unique ID for the control
         array(
            'label' => __( 'Default Structure', 'nabasic' ), //Admin-visible name of the control
            'section' => 'theme_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_structure', //Which setting to load and manipulate (serialized is okay)
            'priority' => 1, //Determines the order this control appears in for the specified section
         ) 
      ));
     
      $wp_customize->add_setting( 'default_width', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '100%%', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_dimension'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_default_width', array(
            'label' => __( 'Width', 'nabasic' ), //Admin-visible name of the control
            'section' => 'theme_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_width', //Which setting to load and manipulate (serialized is okay)
            'priority' => 5, //Determines the order this control appears in for the specified section
      ));
      
      $wp_customize->add_setting( 'default_max_width', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '1000px', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_dimension'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_default_max_width', array(
            'label' => __( 'Maximum Width', 'nabasic' ), //Admin-visible name of the control
            'section' => 'theme_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_max_width', //Which setting to load and manipulate (serialized is okay)
            'priority' => 6, //Determines the order this control appears in for the specified section
      ));
      
      $wp_customize->add_setting( 'default_align', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => 'center', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_default_align', array(
            'label' => __( 'Page Alignment', 'nabasic' ), //Admin-visible name of the control
            'section' => 'theme_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_align', //Which setting to load and manipulate (serialized is okay)
            'priority' => 7, //Determines the order this control appears in for the specified section
            'type' => 'select',
            'choices' => array(
                'center'   => 'Center',
                'left'   => 'Left',
                'right'   => 'Right',
            ),
      ));
      
      $wp_customize->add_setting( 'default_sidebar3_width', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '292px', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_dimension_pixel'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_default_sidebar3_width', array(
            'label' => __( '#sidebar3 Width (in px) - width + margin + borders + padding', 'nabasic' ), //Admin-visible name of the control
            'section' => 'theme_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_sidebar3_width', //Which setting to load and manipulate (serialized is okay)
            'priority' => 20, //Determines the order this control appears in for the specified section
      ));
      
      $wp_customize->add_setting( 'default_sidebar3_margin', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '1em', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_dimension'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_default_sidebar3_margin', array(
            'label' => __( '#sidebar3 Margin' ), //Admin-visible name of the control
            'section' => 'theme_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_sidebar3_margin', //Which setting to load and manipulate (serialized is okay)
            'priority' => 21, //Determines the order this control appears in for the specified section
      ));
      
      $wp_customize->add_setting( 'default_sidebar1_width', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '292px', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_dimension_pixel'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_default_sidebar1_width', array(
            'label' => __( '#sidebar1 Width (in px) - width + margin + borders + padding', 'nabasic' ), //Admin-visible name of the control
            'section' => 'theme_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_sidebar1_width', //Which setting to load and manipulate (serialized is okay)
            'priority' => 30, //Determines the order this control appears in for the specified section
      ));
      
      $wp_customize->add_setting( 'default_sidebar1_margin', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '1em', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_dimension'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_default_sidebar1_margin', array(
            'label' => __( '#sidebar1 Margin' ), //Admin-visible name of the control
            'section' => 'theme_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_sidebar1_margin', //Which setting to load and manipulate (serialized is okay)
            'priority' => 31, //Determines the order this control appears in for the specified section
      ));
      
// * * * * * SECTION: Blog Layout * * * * * //
      $wp_customize->add_section( 'blog_layout', array(
            'title' => __( 'Blog Layout', 'nabasic' ), //Visible title of section
            'priority' => 201, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to define the default blog layout.', 'nabasic'), //Descriptive tooltip
      ));

      $wp_customize->add_setting( 'show_categorized_blog', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_show_categorized_blog', array(
            'label' => __( 'Sort articles by category', 'nabasic' ), //Admin-visible name of the control
            'section' => 'blog_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'show_categorized_blog', //Which setting to load and manipulate (serialized is okay)
            'priority' => 1, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));
      
      $wp_customize->add_setting( 'max_no_categories', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '8', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_positive_number'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_max_no_categories', array(
            'label' => __( 'Maximum displayed categories', 'nabasic' ), //Admin-visible name of the control
            'section' => 'blog_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'max_no_categories', //Which setting to load and manipulate (serialized is okay)
            'priority' => 2, //Determines the order this control appears in for the specified section
      ));
      
      $wp_customize->add_setting( 'default_amount_of_featured_posts', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '3', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_default_amount_of_featured_posts', array(
            'label' => __( 'Number of featured posts', 'nabasic' ), //Admin-visible name of the control
            'section' => 'blog_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_amount_of_featured_posts', //Which setting to load and manipulate (serialized is okay)
            'priority' => 5, //Determines the order this control appears in for the specified section
            'type' => 'select',
            'choices' => array(
                '0'   => '0',
                '1'   => '1',
                '2'   => '2',
                '3'   => '3',
                '4'   => '4',
                '5'   => '5',
                '6'   => '6',
                '7'   => '7',
                '8'   => '8',
                '9'   => '9',
            ),
      ));
      
      $wp_customize->add_setting( 'show_superteaser', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => true, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_show_superteaser', array(
            'label' => __( 'Show supterteaser on blog-page', 'nabasic' ), //Admin-visible name of the control
            'section' => 'blog_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'show_superteaser', //Which setting to load and manipulate (serialized is okay)
            'priority' => 22, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));
      
      $wp_customize->add_setting( 'show_index_pagination', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_show_index_pagination', array(
            'label' => __( 'Show pagination on blog-page', 'nabasic' ), //Admin-visible name of the control
            'section' => 'blog_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'show_index_pagination', //Which setting to load and manipulate (serialized is okay)
            'priority' => 25, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));
      
      // * * * * * SECTION: Single Layout * * * * * //
      $wp_customize->add_section( 'single_layout', array(
            'title' => __( 'Post Layout - Single View', 'nabasic' ), //Visible title of section
            'priority' => 202, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to define the default theme layout.', 'nabasic'), //Descriptive tooltip
      ));

      $wp_customize->add_setting( 'change_single_structure', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_change_single_structure', array(
            'label' => __( 'Change post structure', 'nabasic' ), //Admin-visible name of the control
            'section' => 'single_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'change_single_structure', //Which setting to load and manipulate (serialized is okay)
            'priority' => 1, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'single_structure', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '23', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new Layout_Picker_Custom_control( //Instantiate the Layout_Picker_Custom_control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_single_structure', //Set a unique ID for the control
         array(
            'label' => __( 'Default Structure', 'nabasic' ), //Admin-visible name of the control
            'section' => 'single_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'single_structure', //Which setting to load and manipulate (serialized is okay)
            'priority' => 5, //Determines the order this control appears in for the specified section
         ) 
      ));
     
      $wp_customize->add_setting( 'display_post_navi_top', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_post_navi_top', array(
            'label' => __( 'Display post Navivigation top', 'nabasic' ), //Admin-visible name of the control
            'section' => 'single_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_post_navi_top', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'display_post_navi_bottom', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_post_navi_bottom', array(
            'label' => __( 'Display post Navivigation bottom', 'nabasic' ), //Admin-visible name of the control
            'section' => 'single_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_post_navi_bottom', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'display_post_date', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_post_date', array(
            'label' => __( 'Display post date', 'nabasic' ), //Admin-visible name of the control
            'section' => 'single_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_post_date', //Which setting to load and manipulate (serialized is okay)
            'priority' => 20, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'display_post_author', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_post_author', array(
            'label' => __( 'Display post author', 'nabasic' ), //Admin-visible name of the control
            'section' => 'single_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_post_author', //Which setting to load and manipulate (serialized is okay)
            'priority' => 21, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'display_post_categories', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_post_categories', array(
            'label' => __( 'Display post categories', 'nabasic' ), //Admin-visible name of the control
            'section' => 'single_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_post_categories', //Which setting to load and manipulate (serialized is okay)
            'priority' => 22, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'display_post_tags', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_post_tags', array(
            'label' => __( 'Display post tags', 'nabasic' ), //Admin-visible name of the control
            'section' => 'single_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_post_tags', //Which setting to load and manipulate (serialized is okay)
            'priority' => 23, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'display_post_bookmark', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => true, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_post_bookmark', array(
            'label' => __( 'Display post bookmark', 'nabasic' ), //Admin-visible name of the control
            'section' => 'single_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_post_bookmark', //Which setting to load and manipulate (serialized is okay)
            'priority' => 25, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'display_post_rss_feed', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => true, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_post_rss_feed', array(
            'label' => __( 'Display post bookmark', 'nabasic' ), //Admin-visible name of the control
            'section' => 'single_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_post_rss_feed', //Which setting to load and manipulate (serialized is okay)
            'priority' => 26, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

// * * * * * SECTION: Page Layout * * * * * //
      $wp_customize->add_section( 'page_layout', array(
            'title' => __( 'Page Layout', 'nabasic' ), //Visible title of section
            'priority' => 203, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to define the default theme layout.', 'nabasic'), //Descriptive tooltip
      ));

      $wp_customize->add_setting( 'change_page_structure', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_change_page_structure', array(
            'label' => __( 'Change default page structure', 'nabasic' ), //Admin-visible name of the control
            'section' => 'page_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'change_page_structure', //Which setting to load and manipulate (serialized is okay)
            'priority' => 1, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'page_structure', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '23', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new Layout_Picker_Custom_control( //Instantiate the Layout_Picker_Custom_control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_page_structure', //Set a unique ID for the control
         array(
            'label' => __( 'Default Structure', 'nabasic' ), //Admin-visible name of the control
            'section' => 'page_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'page_structure', //Which setting to load and manipulate (serialized is okay)
            'priority' => 5, //Determines the order this control appears in for the specified section
         ) 
      ));
     
      $wp_customize->add_setting( 'display_page_title', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_page_title', array(
            'label' => __( 'Display title of the page', 'nabasic' ), //Admin-visible name of the control
            'section' => 'page_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_page_title', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

// * * * * * SECTION: Image Layout * * * * * //
      $wp_customize->add_section( 'image_layout', array(
            'title' => __( 'Image Page Layout', 'nabasic' ), //Visible title of section
            'priority' => 204, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to define the default theme layout.', 'nabasic'), //Descriptive tooltip
      ));

      $wp_customize->add_setting( 'change_image_structure', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => true, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_change_image_structure', array(
            'label' => __( 'Change default image page structure', 'nabasic' ), //Admin-visible name of the control
            'section' => 'image_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'change_image_structure', //Which setting to load and manipulate (serialized is okay)
            'priority' => 1, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'image_structure', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '2', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new Layout_Picker_Custom_control( //Instantiate the Layout_Picker_Custom_control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_image_structure', //Set a unique ID for the control
         array(
            'label' => __( 'Default image page structure', 'nabasic' ), //Admin-visible name of the control
            'section' => 'image_layout', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'image_structure', //Which setting to load and manipulate (serialized is okay)
            'priority' => 5, //Determines the order this control appears in for the specified section
         ) 
      ));
     
// * * * * * SECTION: Main Design * * * * * //
      $wp_customize->add_section( 'main_design', array(
            'title' => __( '#main Design', 'nabasic' ), //Visible title of section
            'priority' => 210, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to define the default theme layout.', 'nabasic'), //Descriptive tooltip
      ));

      $wp_customize->add_setting( 'display_main_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_main_color', array(
            'label' => __( 'Change #main text-color', 'nabasic' ), //Admin-visible name of the control
            'section' => 'main_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_main_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 1, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'default_main_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#333333', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_default_main_color', //Set a unique ID for the control
         array(
            'label' => __( '#main Color', 'nabasic' ), //Admin-visible name of the control
            'section' => 'main_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_main_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 2, //Determines the order this control appears in for the specified section
         ) 
      ));

      $wp_customize->add_setting( 'display_main_bg', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => true, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_main_bg', array(
            'label' => __( 'Show #main background', 'nabasic' ), //Admin-visible name of the control
            'section' => 'main_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_main_bg', //Which setting to load and manipulate (serialized is okay)
            'priority' => 13, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'default_main_bg_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#ffffff', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_default_main_bg_color', //Set a unique ID for the control
         array(
            'label' => __( '#main Background-Color', 'nabasic' ), //Admin-visible name of the control
            'section' => 'main_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_main_bg_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 14, //Determines the order this control appears in for the specified section
         ) 
      ));

      $wp_customize->add_setting( 'display_main_border', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => true, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_main_border', array(
            'label' => __( 'Show #main border', 'nabasic' ), //Admin-visible name of the control
            'section' => 'main_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_main_border', //Which setting to load and manipulate (serialized is okay)
            'priority' => 25, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'default_main_border_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#cccccc', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_default_main_border_color', //Set a unique ID for the control
         array(
            'label' => __( '#main Border-Color', 'nabasic' ), //Admin-visible name of the control
            'section' => 'main_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_main_border_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 26, //Determines the order this control appears in for the specified section
         ) 
      ));

      $wp_customize->add_setting( 'display_main_shadow', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => true, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_main_shadow', array(
            'label' => __( 'Show #main shadow', 'nabasic' ), //Admin-visible name of the control
            'section' => 'main_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_main_shadow', //Which setting to load and manipulate (serialized is okay)
            'priority' => 30, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'main_padding', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '1em', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_dimension'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_main_padding', array(
            'label' => __( '#main padding' ), //Admin-visible name of the control
            'section' => 'main_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'main_padding', //Which setting to load and manipulate (serialized is okay)
            'priority' => 35, //Determines the order this control appears in for the specified section
      ));
      
// * * * * * SECTION: Content Design * * * * * //
      $wp_customize->add_section( 'content_design', array(
            'title' => __( '#content Design', 'nabasic' ), //Visible title of section
            'priority' => 220, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to define the default theme layout.', 'nabasic'), //Descriptive tooltip
      ));

      $wp_customize->add_setting( 'display_content_bg', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_content_bg', array(
            'label' => __( 'Show #content background', 'nabasic' ), //Admin-visible name of the control
            'section' => 'content_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_content_bg', //Which setting to load and manipulate (serialized is okay)
            'priority' => 14, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'default_content_bg_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#ffffff', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_default_content_bg_color', //Set a unique ID for the control
         array(
            'label' => __( '#content Background-Color', 'nabasic' ), //Admin-visible name of the control
            'section' => 'content_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_content_bg_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 15, //Determines the order this control appears in for the specified section
         ) 
      ));

      $wp_customize->add_setting( 'display_content_border', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_content_border', array(
            'label' => __( 'Show #content border', 'nabasic' ), //Admin-visible name of the control
            'section' => 'content_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_content_border', //Which setting to load and manipulate (serialized is okay)
            'priority' => 20, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'default_content_border_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#eeeeee', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_default_content_border_color', //Set a unique ID for the control
         array(
            'label' => __( '#content Border-Color', 'nabasic' ), //Admin-visible name of the control
            'section' => 'content_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_content_border_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 21, //Determines the order this control appears in for the specified section
         ) 
      ));

      $wp_customize->add_setting( 'display_content_shadow', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_content_shadow', array(
            'label' => __( 'Show #content shadow', 'nabasic' ), //Admin-visible name of the control
            'section' => 'content_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_content_shadow', //Which setting to load and manipulate (serialized is okay)
            'priority' => 25, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'content_padding_lr', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '1em', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_dimension'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_content_padding_lr', array(
            'label' => __( '#content padding left/right' ), //Admin-visible name of the control
            'section' => 'content_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'content_padding_lr', //Which setting to load and manipulate (serialized is okay)
            'priority' => 30, //Determines the order this control appears in for the specified section
      ));
      
      $wp_customize->add_setting( 'content_padding_tb', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '1em', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_dimension'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_content_padding_tb', array(
            'label' => __( '#content padding top/bottom' ), //Admin-visible name of the control
            'section' => 'content_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'content_padding_tb', //Which setting to load and manipulate (serialized is okay)
            'priority' => 30, //Determines the order this control appears in for the specified section
      ));
      
      // * * * * * SECTION: Sidebar3 Design * * * * * //
      $wp_customize->add_section( 'sidebar3_design', array(
            'title' => __( '#sidebar3 Design', 'nabasic' ), //Visible title of section
            'priority' => 230, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to define the default theme layout.', 'nabasic'), //Descriptive tooltip
      ));

      $wp_customize->add_setting( 'display_sidebar3_bg', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_sidebar3_bg', array(
            'label' => __( 'Show #sidebar3 background', 'nabasic' ), //Admin-visible name of the control
            'section' => 'sidebar3_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_sidebar3_bg', //Which setting to load and manipulate (serialized is okay)
            'priority' => 30, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'default_sidebar3_bg_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#ffffff', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_default_sidebar3_bg_color', //Set a unique ID for the control
         array(
            'label' => __( '#sidebar3 Background-Color', 'nabasic' ), //Admin-visible name of the control
            'section' => 'sidebar3_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_sidebar3_bg_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 35, //Determines the order this control appears in for the specified section
         ) 
      ));

      $wp_customize->add_setting( 'display_sidebar3_border', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_sidebar3_border', array(
            'label' => __( 'Show #sidebar3 border', 'nabasic' ), //Admin-visible name of the control
            'section' => 'sidebar3_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_sidebar3_border', //Which setting to load and manipulate (serialized is okay)
            'priority' => 40, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'default_sidebar3_border_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#eeeeee', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_default_sidebar3_border_color', //Set a unique ID for the control
         array(
            'label' => __( '#sidebar3 Border-Color', 'nabasic' ), //Admin-visible name of the control
            'section' => 'sidebar3_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_sidebar3_border_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 41, //Determines the order this control appears in for the specified section
         ) 
      ));

      $wp_customize->add_setting( 'display_sidebar3_shadow', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_sidebar3_shadow', array(
            'label' => __( 'Show #sidebar3 shadow', 'nabasic' ), //Admin-visible name of the control
            'section' => 'sidebar3_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_sidebar3_shadow', //Which setting to load and manipulate (serialized is okay)
            'priority' => 45, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'sidebar3_padding_lr', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '1em', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_dimension'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_sidebar3_padding_lr', array(
            'label' => __( '#sidebar3 padding left/right' ), //Admin-visible name of the control
            'section' => 'sidebar3_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'sidebar3_padding_lr', //Which setting to load and manipulate (serialized is okay)
            'priority' => 50, //Determines the order this control appears in for the specified section
      ));
      
      $wp_customize->add_setting( 'sidebar3_padding_tb', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '1em', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_dimension'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_sidebar3_padding_tb', array(
            'label' => __( '#sidebar3 padding top/bottom' ), //Admin-visible name of the control
            'section' => 'sidebar3_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'sidebar3_padding_tb', //Which setting to load and manipulate (serialized is okay)
            'priority' => 50, //Determines the order this control appears in for the specified section
      ));
      
      // * * * * * SECTION: Sidebar1 Design * * * * * //
      $wp_customize->add_section( 'sidebar1_design', array(
            'title' => __( '#sidebar1 Design', 'nabasic' ), //Visible title of section
            'priority' => 240, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to define the default theme layout.', 'nabasic'), //Descriptive tooltip
      ));

      $wp_customize->add_setting( 'display_sidebar1_bg', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_sidebar1_bg', array(
            'label' => __( 'Show #sidebar1 background', 'nabasic' ), //Admin-visible name of the control
            'section' => 'sidebar1_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_sidebar1_bg', //Which setting to load and manipulate (serialized is okay)
            'priority' => 50, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'default_sidebar1_bg_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#ffffff', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_default_sidebar1_bg_color', //Set a unique ID for the control
         array(
            'label' => __( '#sidebar1 Background-Color', 'nabasic' ), //Admin-visible name of the control
            'section' => 'sidebar1_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_sidebar1_bg_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 55, //Determines the order this control appears in for the specified section
         ) 
      ));

      $wp_customize->add_setting( 'display_sidebar1_border', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_sidebar1_border', array(
            'label' => __( 'Show #sidebar1 border', 'nabasic' ), //Admin-visible name of the control
            'section' => 'sidebar1_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_sidebar1_border', //Which setting to load and manipulate (serialized is okay)
            'priority' => 60, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'default_sidebar1_border_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#eeeeee', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'nabasic_default_sidebar1_border_color', //Set a unique ID for the control
         array(
            'label' => __( '#sidebar1 Border-Color', 'nabasic' ), //Admin-visible name of the control
            'section' => 'sidebar1_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'default_sidebar1_border_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 61, //Determines the order this control appears in for the specified section
         ) 
      ));

      $wp_customize->add_setting( 'display_sidebar1_shadow', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_display_sidebar1_shadow', array(
            'label' => __( 'Show #sidebar1 shadow', 'nabasic' ), //Admin-visible name of the control
            'section' => 'sidebar1_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'display_sidebar1_shadow', //Which setting to load and manipulate (serialized is okay)
            'priority' => 65, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));

      $wp_customize->add_setting( 'sidebar1_padding_lr', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '1em', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_dimension'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_sidebar1_padding_lr', array(
            'label' => __( '#sidebar1 padding left/right' ), //Admin-visible name of the control
            'section' => 'sidebar1_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'sidebar1_padding_lr', //Which setting to load and manipulate (serialized is okay)
            'priority' => 70, //Determines the order this control appears in for the specified section
      ));
      
      $wp_customize->add_setting( 'sidebar1_padding_tb', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '1em', // %% - Returns a percent sign >> http://www.w3schools.com/php/func_string_printf.asp
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'check_dimension'
         ) 
      );      
      $wp_customize->add_control( 'nabasic_sidebar1_padding_tb', array(
            'label' => __( '#sidebar1 padding top/bottom' ), //Admin-visible name of the control
            'section' => 'sidebar1_design', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'sidebar1_padding_tb', //Which setting to load and manipulate (serialized is okay)
            'priority' => 70, //Determines the order this control appears in for the specified section
      ));
      
// * * * * * SECTION (default): static_front_page - Static Front Page  * * * * * //

// * * * * * SECTION: CUSTOM POST TYPES * * * * * //
      $wp_customize->add_section( 'theme_custom_post_types', array(
            'title' => __( 'Custom Post Types', 'nabasic' ), //Visible title of section
            'priority' => 900, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to activate custom post types.', 'nabasic'), //Descriptive tooltip
      ));

      $wp_customize->add_setting( 'activate_events_custom_post_type', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      $wp_customize->add_control( 'nabasic_activate_events_custom_post_type', array(
            'label' => __( 'Activate events', 'nabasic' ), //Admin-visible name of the control
            'section' => 'theme_custom_post_types', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'activate_events_custom_post_type', //Which setting to load and manipulate (serialized is okay)
            'priority' => 1, //Determines the order this control appears in for the specified section
            'type' => 'checkbox',
      ));
      
   }

   /**
    * This will output the custom WordPress settings to the live theme's WP head.
    * 
    * Used by hook: 'wp_head'
    * 
    * @see add_action('wp_head',$func)
    * @since nabasic 0.1
    */
   public static function header_output() {
      ?>
      <!--Customizer CSS--> 
      <style type="text/css">
           <?php self::generate_css('body', 'color', 'bg_textcolor'); ?> 
           <?php self::generate_css('body', 'background-color', 'background_color', '#'); ?> 
           <?php self::generate_css('a', 'color', 'bg_linkcolor'); ?>
           <?php if (get_theme_mod('bg_link_decoration') == true): ?>
              a {
                text-decoration: underline;
              }
           <?php endif; ?>
           <?php self::generate_css('a:hover', 'color', 'bg_linkcolor_hover'); ?>
           <?php self::generate_css('a:focus', 'color', 'bg_linkcolor_hover'); ?>
           <?php if (get_theme_mod('bg_link_decoration_hover',true) == false): ?>
              a:hover, a:focus {
                text-decoration: none;
              }
           <?php endif; ?>
           <?php self::generate_css('.na-wrapper', 'width', 'default_width'); ?>
           <?php self::generate_css('.na-wrapper', 'max-width', 'default_max_width'); ?>
           <?php switch (get_theme_mod('default_align')) {
                  case 'left': ?> .na-wrapper {margin-right: 0;margin-left: 0;} <?php break;
                  case 'right': ?> .na-wrapper {margin-right: 0; margin-left: 0;float: right;} <?php break;
           }; ?>
           <?php self::structure_css('default_structure'); ?>
           <?php if(get_theme_mod('change_single_structure')){self::structure_css('single_structure');}; ?>
           <?php if(get_theme_mod('change_page_structure')){self::structure_css('page_structure');}; ?>
           <?php if(get_theme_mod('change_image_structure')){self::structure_css('image_structure');}; ?>
           <?php if (get_theme_mod('bg_cover') == true): ?>
              body {
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
              }
           <?php endif; ?>
           <?php if (get_theme_mod('display_main_color') == true){
             self::generate_css('#main > .na-wrapper > .na-wbox', 'color', 'default_main_color'); 
           }?>
           <?php self::generate_css('#main > .na-wrapper > .na-wbox', 'background-color', 'default_main_bg_color'); ?>
           <?php if (get_theme_mod('display_main_bg',true) == false): ?>
              #main > .na-wrapper > .na-wbox {background: none;}
           <?php endif; ?>
           <?php if (get_theme_mod('display_main_border',true) == false): ?>
              #main > .na-wrapper > .na-wbox {border: none;}
           <?php endif; ?>
           <?php self::generate_css('#main > .na-wrapper > .na-wbox', 'border-color', 'default_main_border_color'); ?>
           <?php if (get_theme_mod('display_main_shadow',true) == false): ?>
              #main > .na-wrapper > .na-wbox {
                -webkit-box-shadow: none;
                box-shadow: none;
              }
           <?php endif; ?>
           <?php self::generate_css('#main > .na-wrapper > .na-wbox', 'padding', 'main_padding'); ?>
           <?php self::generate_css('#main .na-col2 .na-cbox', 'background', 'default_content_bg_color'); ?>
           <?php if (get_theme_mod('display_content_bg') == false): ?>
              #main .na-col2 .na-cbox {background: none;}
           <?php endif; ?>
           <?php if (get_theme_mod('display_content_border') == false): ?>
              #main .na-col2 .na-cbox {border: none;}
           <?php endif; ?>
           <?php self::generate_css('#main .na-col2 .na-cbox', 'border-color', 'default_content_border_color'); ?>
           <?php if (get_theme_mod('display_content_shadow') == false): ?>
              #main .na-col2 .na-cbox {
                -webkit-box-shadow: none;
                box-shadow: none;
              }
           <?php endif; ?>
           <?php self::generate_css('#main .na-col2 .na-cbox', 'padding-left', 'content_padding_lr'); ?>
           <?php self::generate_css('#main .na-col2 .na-cbox', 'padding-right', 'content_padding_lr'); ?>
           <?php self::generate_css('#main .na-col2 .na-cbox', 'padding-top', 'content_padding_tb'); ?>
           <?php self::generate_css('#main .na-col2 .na-cbox', 'padding-bottom', 'content_padding_tb'); ?>
           <?php self::generate_css('#main .na-col3 .na-cbox', 'background', 'default_sidebar3_bg_color'); ?>
           <?php if (get_theme_mod('display_sidebar3_bg') == false): ?>
              #main .na-col3 .na-cbox {background: none;}
           <?php endif; ?>
           <?php if (get_theme_mod('display_sidebar3_border') == false): ?>
              #main .na-col3 .na-cbox {border: none;}
           <?php endif; ?>
           <?php self::generate_css('#main .na-col3 .na-cbox', 'border-color', 'default_sidebar3_border_color'); ?>
           <?php if (get_theme_mod('display_sidebar3_shadow') == false): ?>
              #main .na-col3 .na-cbox {
                -webkit-box-shadow: none;
                box-shadow: none;
              }
           <?php endif; ?>
           <?php self::generate_css('#main .na-col3 .na-cbox', 'padding-left', 'sidebar3_padding_lr'); ?>
           <?php self::generate_css('#main .na-col3 .na-cbox', 'padding-right', 'sidebar3_padding_lr'); ?>
           <?php self::generate_css('#main .na-col3 .na-cbox', 'padding-top', 'sidebar3_padding_tb'); ?>
           <?php self::generate_css('#main .na-col3 .na-cbox', 'padding-bottom', 'sidebar3_padding_tb'); ?>
           <?php self::generate_css('#main .na-col1 .na-cbox', 'background', 'default_sidebar1_bg_color'); ?>
           <?php if (get_theme_mod('display_sidebar1_bg') == false): ?>
              #main .na-col1 .na-cbox {background: none;}
           <?php endif; ?>
           <?php if (get_theme_mod('display_sidebar1_border') == false): ?>
              #main .na-col1 .na-cbox {border: none;}
           <?php endif; ?>
           <?php self::generate_css('#main .na-col1 .na-cbox', 'border-color', 'default_sidebar1_border_color'); ?>
           <?php if (get_theme_mod('display_sidebar1_shadow') == false): ?>
              #main .na-col1 .na-cbox {
                -webkit-box-shadow: none;
                box-shadow: none;
              }
           <?php endif; ?>
           <?php self::generate_css('#main .na-col1 .na-cbox', 'padding-left', 'sidebar1_padding_lr'); ?>
           <?php self::generate_css('#main .na-col1 .na-cbox', 'padding-right', 'sidebar1_padding_lr'); ?>
           <?php self::generate_css('#main .na-col1 .na-cbox', 'padding-top', 'sidebar1_padding_tb'); ?>
           <?php self::generate_css('#main .na-col1 .na-cbox', 'padding-bottom', 'sidebar1_padding_tb'); ?>
      </style> 
      <!--/Customizer CSS-->
      <?php
   }
   
   public static function structure_css($section) {
           switch (get_theme_mod($section)) {
              case '23': ?> 
                <?php self::generate_css('#main .na-column23', 'padding-right', 'default_sidebar3_width'); ?> 
                #main .na-column23 .na-col3 {margin-right:-<?php echo get_theme_mod('default_sidebar3_width'); ?>;}
                <?php self::generate_css('#main .na-column23 .na-col3', 'width', 'default_sidebar3_width'); ?> 
                <?php self::generate_css('#main .na-column23 .na-col3 .na-cbox', 'margin-left', 'default_sidebar3_margin'); ?> 
                <?php self::generate_css('body .supterteaser-na-column23 .superteaser-top', 'padding-left', 'content_padding_lr'); ?>
                <?php self::generate_css('body .supterteaser-na-column23 .superteaser-top', 'padding-right', 'sidebar3_padding_lr'); ?>
              <?php break;
              case '32': ?> 
                <?php self::generate_css('#main .na-column32', 'padding-left', 'default_sidebar3_width'); ?> 
                <?php self::generate_css('#main .na-column32 .na-col3', 'width', 'default_sidebar3_width'); ?> 
                #main .na-column32 .na-col3 {right:<?php echo get_theme_mod('default_sidebar3_width'); ?>;_right:0;/* fix for ie6 */}
                <?php self::generate_css('#main .na-column32 .na-col3 .na-cbox', 'margin-right', 'default_sidebar3_margin'); ?> 
                <?php self::generate_css('body .supterteaser-na-column32 .superteaser-top', 'padding-left', 'sidebar3_padding_lr'); ?>
                <?php self::generate_css('body .supterteaser-na-column32 .superteaser-top', 'padding-right', 'content_padding_lr'); ?>
              <?php break;
              case '123': ?> 
                <?php self::generate_css('#main .na-column123', 'padding-left', 'default_sidebar1_width'); ?> 
                <?php self::generate_css('#main .na-column123', 'padding-right', 'default_sidebar3_width'); ?> 
                #main .na-column123 .na-col1 {margin-left:-<?php echo get_theme_mod('default_sidebar1_width'); ?>;}
                <?php self::generate_css('#main .na-column123 .na-col1', 'width', 'default_sidebar1_width'); ?> 
                <?php self::generate_css('#main .na-column123 .na-col1 .na-cbox', 'margin-right', 'default_sidebar1_margin'); ?> 
                #main .na-column123 .na-col3 {margin-right:-<?php echo get_theme_mod('default_sidebar3_width'); ?>;}
                <?php self::generate_css('#main .na-column123 .na-col3', 'width', 'default_sidebar3_width'); ?> 
                <?php self::generate_css('#main .na-column123 .na-col3 .na-cbox', 'margin-left', 'default_sidebar3_margin'); ?> 
                <?php self::generate_css('body .supterteaser-na-column123 .superteaser-top', 'padding-left', 'sidebar1_padding_lr'); ?>
                <?php self::generate_css('body .supterteaser-na-column123 .superteaser-top', 'padding-right', 'sidebar3_padding_lr'); ?>
              <?php break;
              case '12': ?> 
                <?php self::generate_css('#main .na-column12', 'padding-left', 'default_sidebar1_width'); ?> 
                #main .na-column12 .na-col1 {margin-left:-<?php echo get_theme_mod('default_sidebar1_width'); ?>;}
                <?php self::generate_css('#main .na-column12 .na-col1', 'width', 'default_sidebar1_width'); ?> 
                <?php self::generate_css('#main .na-column12 .na-col1 .na-cbox', 'margin-right', 'default_sidebar1_margin'); ?> 
                <?php self::generate_css('body .supterteaser-na-column12 .superteaser-top', 'padding-left', 'sidebar1_padding_lr'); ?>
                <?php self::generate_css('body .supterteaser-na-column12 .superteaser-top', 'padding-right', 'content_padding_lr'); ?>
              <?php break;
              case '21': ?> 
                <?php self::generate_css('#main .na-column21', 'padding-right', 'default_sidebar1_width'); ?> 
                #main .na-column21 .na-col1 {margin-right:-<?php echo get_theme_mod('default_sidebar1_width'); ?>;}
                <?php self::generate_css('#main .na-column21 .na-col1', 'width', 'default_sidebar1_width'); ?> 
                <?php self::generate_css('#main .na-column21 .na-col1 .na-cbox', 'margin-left', 'default_sidebar1_margin'); ?> 
                <?php self::generate_css('body .supterteaser-na-column21 .superteaser-top', 'padding-left', 'content_padding_lr'); ?>
                <?php self::generate_css('body .supterteaser-na-column21 .superteaser-top', 'padding-right', 'sidebar1_padding_lr'); ?>
              <?php break;
              case '2': ?> 
                <?php self::generate_css('body .supterteaser-na-column2 .superteaser-top', 'padding-left', 'content_padding_lr'); ?>
                <?php self::generate_css('body .supterteaser-na-column2 .superteaser-top', 'padding-right', 'content_padding_lr'); ?>
              <?php break;
           };
   }


   /**
    * This outputs the javascript needed to automate the live settings preview.
    * Also keep in mind that this function isn't necessary unless your settings 
    * are using 'transport'=>'postMessage' instead of the default 'transport'
    * => 'refresh'
    * 
    * Used by hook: 'customize_preview_init'
    * 
    * @see add_action('customize_preview_init',$func)
    * @since nabasic 0.1
    */
   public static function live_preview() {
      wp_enqueue_script( 
           'nabasic-themecustomizer', //Give the script an ID
           get_template_directory_uri().'/js/theme-customizer.js', //Define it's JS file
           array( 'jquery','customize-preview' ), //Define dependencies
           '', //Define a version (optional) 
           true //Specify whether to put in footer (leave this true)
      );
   }

    /**
     * This will generate a line of CSS for use in header output. If the setting
     * ($mod_name) has no defined value, the CSS will not be output.
     * 
     * @uses get_theme_mod()
     * @param string $selector CSS selector
     * @param string $style The name of the CSS *property* to modify
     * @param string $mod_name The name of the 'theme_mod' option to fetch
     * @param string $prefix Optional. Anything that needs to be output before the CSS property
     * @param string $postfix Optional. Anything that needs to be output after the CSS property
     * @param bool $echo Optional. Whether to print directly to the page (default: true).
     * @return string Returns a single line of CSS with selectors and a property.
     * @since nabasic 0.1
     */
    public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true) {
      $return = '';
      $mod = get_theme_mod($mod_name);
      if ( !empty($mod) ) {
         $return = sprintf('%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) { echo $return; }
      }
      return $return;
    }
}

function check_dimension( $value ) {
  $pattern = '/^auto$|^[+-]?[0-9]+\\.?([0-9]+)?(px|em|ex|%|in|cm|mm|pt|pc)?$/';
  if( preg_match($pattern, $value ) == '1') {
    return $value;
  }
}
function check_dimension_pixel( $value ) {
  $pattern = '/^auto$|^[+-]?[0-9]+\\.?([0-9]+)?(px)?$/';
  if( preg_match($pattern, $value ) == '1') {
    return $value;
  }
}
function check_positive_number( $value ) {
  $pattern = '/^([1-9][0-9]*)$/';
  if( preg_match($pattern, $value ) == '1') {
    return $value;
  }
}
// add Layout-Picker
include_once('customizer-controls/layout_picker_custom_control.php');

// Surfacing the Customizer - add the Customize link to the admin menu
// @link http://ottopress.com/2012/theme-customizer-part-deux-getting-rid-of-options-pages/
// @link http://codex.wordpress.org/Function_Reference/add_theme_page
add_action ('admin_menu', 'themedemo_admin');
function themedemo_admin() {
  add_theme_page( __( 'Customize', 'nabasic' ), __( 'Customize', 'nabasic' ), 'edit_theme_options', 'customize.php' );
}
     
//Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'nabasic_Customize' , 'register' ) );

//Output custom CSS to live site
add_action( 'wp_head' , array( 'nabasic_Customize' , 'header_output' ) );

//Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'nabasic_Customize' , 'live_preview' ) );


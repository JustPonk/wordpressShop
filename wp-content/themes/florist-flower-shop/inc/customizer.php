<?php
/**
 * Florist Flower Shop Theme Customizer
 *
 * @package Florist Flower Shop
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function florist_flower_shop_custom_controls() {
	load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'florist_flower_shop_custom_controls' );

function florist_flower_shop_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.logo .site-title a',
	 	'render_callback' => 'florist_flower_shop_customize_partial_blogname',
	));

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => 'p.site-description',
		'render_callback' => 'florist_flower_shop_customize_partial_blogdescription',
	));

	//add home page setting pannel
	$florist_flower_shop_parent_panel = new Florist_Flower_Shop_WP_Customize_Panel( $wp_customize, 'florist_flower_shop_panel_id', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => esc_html__( 'Homepage Settings', 'florist-flower-shop' ),
		'priority' => 10,
	));

	//Top Header
	$wp_customize->add_section( 'florist_flower_shop_top_header' , array(
    	'title' => esc_html__( 'Top Header', 'florist-flower-shop' ),
		'panel' => 'florist_flower_shop_panel_id'
	) );

	$wp_customize->add_setting( 'florist_flower_shop_hide_show_topbar_section',array(
	  	'default' => 1,
	  	'transport' => 'refresh',
	  	'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
  	));
  	$wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_hide_show_topbar_section',array(
	  	'label' => esc_html__( 'Show / Hide Topbar','florist-flower-shop' ),
	  	'section' => 'florist_flower_shop_top_header',
  	)));

   	// Header Background color
	$wp_customize->add_setting('florist_flower_shop_header_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'florist_flower_shop_header_background_color', array(
		'label'    => __('Header Background Color', 'florist-flower-shop'),
		'section'  => 'header_image',
	)));

	$wp_customize->add_setting('florist_flower_shop_header_img_position',array(
	  'default' => 'center top',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_header_img_position',array(
		'type' => 'select',
		'label' => __('Header Image Position','florist-flower-shop'),
		'section' => 'header_image',
		'choices' 	=> array(
			'left top' 		=> esc_html__( 'Top Left', 'florist-flower-shop' ),
			'center top'   => esc_html__( 'Top', 'florist-flower-shop' ),
			'right top'   => esc_html__( 'Top Right', 'florist-flower-shop' ),
			'left center'   => esc_html__( 'Left', 'florist-flower-shop' ),
			'center center'   => esc_html__( 'Center', 'florist-flower-shop' ),
			'right center'   => esc_html__( 'Right', 'florist-flower-shop' ),
			'left bottom'   => esc_html__( 'Bottom Left', 'florist-flower-shop' ),
			'center bottom'   => esc_html__( 'Bottom', 'florist-flower-shop' ),
			'right bottom'   => esc_html__( 'Bottom Right', 'florist-flower-shop' ),
		),
	));

	$wp_customize->add_setting('florist_flower_shop_top_bar_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_top_bar_text',array(
		'label'	=> esc_html__('Anouncement Text','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Lorem ipsum dolor sit amet ipsum dolor sit amet.', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_contact_us_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_contact_us_text',array(
		'label'	=> esc_html__('Button Text','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Contact Us', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_contact_us_link',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('florist_flower_shop_contact_us_link',array(
		'label'	=> esc_html__('Button Link','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'https://www.example.com/contact-us', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_top_header',
		'type'=> 'url'
	));

	//Menus Settings
	$wp_customize->add_section( 'florist_flower_shop_menu_section' , array(
    	'title' => __( 'Menus Settings', 'florist-flower-shop' ),
		'panel' => 'florist_flower_shop_panel_id'
	) );

	$wp_customize->add_setting('florist_flower_shop_navigation_menu_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_navigation_menu_font_size',array(
		'label'	=> __('Menus Font Size','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_menu_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_navigation_menu_font_weight',array(
        'default' => 600,
        'transport' => 'refresh',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_navigation_menu_font_weight',array(
        'type' => 'select',
        'label' => __('Menus Font Weight','florist-flower-shop'),
        'section' => 'florist_flower_shop_menu_section',
        'choices' => array(
        	'100' => __('100','florist-flower-shop'),
            '200' => __('200','florist-flower-shop'),
            '300' => __('300','florist-flower-shop'),
            '400' => __('400','florist-flower-shop'),
            '500' => __('500','florist-flower-shop'),
            '600' => __('600','florist-flower-shop'),
            '700' => __('700','florist-flower-shop'),
            '800' => __('800','florist-flower-shop'),
            '900' => __('900','florist-flower-shop'),
        ),
	) );

	// text trasform
	$wp_customize->add_setting('florist_flower_shop_menu_text_transform',array(
		'default'=> 'Capitalize',
		'sanitize_callback'	=> 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_menu_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Menus Text Transform','florist-flower-shop'),
		'choices' => array(
            'Uppercase' => __('Uppercase','florist-flower-shop'),
            'Capitalize' => __('Capitalize','florist-flower-shop'),
            'Lowercase' => __('Lowercase','florist-flower-shop'),
        ),
		'section'=> 'florist_flower_shop_menu_section',
	));

	$wp_customize->add_setting('florist_flower_shop_menus_item_style',array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_menus_item_style',array(
        'type' => 'select',
        'section' => 'florist_flower_shop_menu_section',
		'label' => __('Menu Item Hover Style','florist-flower-shop'),
		'choices' => array(
            'None' => __('None','florist-flower-shop'),
            'Zoom In' => __('Zoom In','florist-flower-shop'),
        ),
	) );

	$wp_customize->add_setting('florist_flower_shop_header_menus_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'florist_flower_shop_header_menus_color', array(
		'label'    => __('Menus Color', 'florist-flower-shop'),
		'section'  => 'florist_flower_shop_menu_section',
	)));

	$wp_customize->add_setting('florist_flower_shop_header_menus_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'florist_flower_shop_header_menus_hover_color', array(
		'label'    => __('Menus Hover Color', 'florist-flower-shop'),
		'section'  => 'florist_flower_shop_menu_section',
	)));

	$wp_customize->add_setting('florist_flower_shop_header_submenus_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'florist_flower_shop_header_submenus_color', array(
		'label'    => __('Sub Menus Color', 'florist-flower-shop'),
		'section'  => 'florist_flower_shop_menu_section',
	)));

	$wp_customize->add_setting('florist_flower_shop_header_submenus_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'florist_flower_shop_header_submenus_hover_color', array(
		'label'    => __('Sub Menus Hover Color', 'florist-flower-shop'),
		'section'  => 'florist_flower_shop_menu_section',
	)));

	//Social links
	$wp_customize->add_section(
	'florist_flower_social_links', array(
		'title'		=>	__('Social Links', 'florist-flower-shop'),
		'priority'	=>	null,
		'panel'		=>	'florist_flower_shop_panel_id'
	));

	$wp_customize->add_setting('florist_flower_social_icons',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_social_icons',array(
		'label' =>  __('Steps to setup social icons','florist-flower-shop'),
		'description' => __('<p>1. Go to Dashboard >> Appearance >> Widgets</p>
			<p>2. Add Vw Social Icon Widget in Social Media.</p>
			<p>3. Add social icons url and save.</p>','florist-flower-shop'),
		'section'=> 'florist_flower_social_links',
		'type'=> 'hidden'
	));
	$wp_customize->add_setting('florist_flower_social_icon_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_social_icon_btn',array(
		'description' => "<a target='_blank' href='". admin_url('widgets.php') ." '>Setup Social Icons</a>",
		'section'=> 'florist_flower_social_links',
		'type'=> 'hidden'
	));

	//Slider
	$wp_customize->add_section( 'florist_flower_shop_slidersettings' , array(
    	'title' => esc_html__( 'Slider Settings', 'florist-flower-shop' ),
    	'description' => __('Free theme has 3 slides options, For unlimited slides and more options </br> <a class="go-pro-btn" target="blank" href="https://www.vwthemes.com/products/flower-shop-wordpress-theme">GET PRO</a>','florist-flower-shop'),
		'panel' => 'florist_flower_shop_panel_id'
	) );

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial('florist_flower_shop_slider_arrows',array(
		'selector'        => '#slider .carousel-caption h1',
		'render_callback' => 'florist_flower_shop_customize_partial_florist_flower_shop_slider_arrows',
	));

	$wp_customize->add_setting( 'florist_flower_shop_slider_arrows',array(
    	'default' => 0,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ));
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_slider_arrows',array(
      	'label' => esc_html__( 'Show / Hide Slider','florist-flower-shop' ),
      	'section' => 'florist_flower_shop_slidersettings'
    )));

    $wp_customize->add_setting('florist_flower_shop_slider_type',array(
        'default' => 'Default slider',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	) );
	$wp_customize->add_control('florist_flower_shop_slider_type', array(
        'type' => 'select',
        'label' => __('Slider Type','florist-flower-shop'),
        'section' => 'florist_flower_shop_slidersettings',
        'choices' => array(
            'Default slider' => __('Default slider','florist-flower-shop'),
            'Advance slider' => __('Advance slider','florist-flower-shop'),
        ),
	));

	$wp_customize->add_setting('florist_flower_shop_advance_slider_shortcode',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_advance_slider_shortcode',array(
		'label'	=> __('Add Slider Shortcode','florist-flower-shop'),
		'section'=> 'florist_flower_shop_slidersettings',
		'type'=> 'text',
		'active_callback' => 'florist_flower_shop_advance_slider'
	));

	for ( $count = 1; $count <= 3; $count++ ) {
		$wp_customize->add_setting( 'florist_flower_shop_slider_page' . $count, array(
			'default'  => '',
			'sanitize_callback' => 'florist_flower_shop_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'florist_flower_shop_slider_page' . $count, array(
			'label'    => esc_html__( 'Select Slider Page', 'florist-flower-shop' ),
			'description' => esc_html__('Slider image size (1600 x 700)','florist-flower-shop'),
			'section'  => 'florist_flower_shop_slidersettings',
			'type'     => 'dropdown-pages',
			'active_callback' => 'florist_flower_shop_default_slider'
		) );
	}

	 $wp_customize->add_setting('florist_flower_shop_slider_button_text',array(
		'default'=> 'SHOP NOW',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_slider_button_text',array(
		'label'	=> __('Add Slider Button Text','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( 'SHOP NOW', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_slidersettings',
		'type'=> 'text',
		'active_callback' => 'florist_flower_shop_default_slider'
	));

	$wp_customize->add_setting('florist_flower_shop_slider_button_link',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('florist_flower_shop_slider_button_link',array(
		'label'	=> esc_html__('Add Button Link','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'www.example-info.com', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_slidersettings',
		'type'=> 'url'
	));

	$wp_customize->add_setting( 'florist_flower_shop_slider_title_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ));
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_slider_title_hide_show',array(
		'label' => esc_html__( 'Show / Hide Slider Title','florist-flower-shop' ),
		'section' => 'florist_flower_shop_slidersettings',
		'active_callback' => 'florist_flower_shop_default_slider'
    )));

	$wp_customize->add_setting( 'florist_flower_shop_slider_content_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ));
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_slider_content_hide_show',array(
		'label' => esc_html__( 'Show / Hide Slider Content','florist-flower-shop' ),
		'section' => 'florist_flower_shop_slidersettings',
		'active_callback' => 'florist_flower_shop_default_slider'
    )));

	//content layout
	$wp_customize->add_setting('florist_flower_shop_slider_content_option',array(
        'default' => 'Left',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Image_Radio_Control($wp_customize, 'florist_flower_shop_slider_content_option', array(
        'type' => 'select',
        'label' => esc_html__('Slider Content Layouts','florist-flower-shop'),
        'section' => 'florist_flower_shop_slidersettings',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/slider-content1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/slider-content2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/slider-content3.png',
    ),'active_callback' => 'florist_flower_shop_default_slider'
    )));

    //Slider content padding
    $wp_customize->add_setting('florist_flower_shop_slider_content_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_slider_content_padding_top_bottom',array(
		'label'	=> __('Slider Content Padding Top Bottom','florist-flower-shop'),
		'description'	=> __('Enter a value in %. Example:20%','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '50%', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_slidersettings',
		'type'=> 'text',
		'active_callback' => 'florist_flower_shop_default_slider'
	));

	$wp_customize->add_setting('florist_flower_shop_slider_content_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_slider_content_padding_left_right',array(
		'label'	=> __('Slider Content Padding Left Right','florist-flower-shop'),
		'description'	=> __('Enter a value in %. Example:20%','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '50%', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_slidersettings',
		'type'=> 'text',
		'active_callback' => 'florist_flower_shop_default_slider'
	));

    //Slider excerpt
	$wp_customize->add_setting( 'florist_flower_shop_slider_excerpt_number', array(
		'default'              => 25,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'florist_flower_shop_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'florist_flower_shop_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt length','florist-flower-shop' ),
		'section'     => 'florist_flower_shop_slidersettings',
		'type'        => 'range',
		'settings'    => 'florist_flower_shop_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),'active_callback' => 'florist_flower_shop_default_slider'
	) );

	//Slider height
	$wp_customize->add_setting('florist_flower_shop_slider_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_slider_height',array(
		'label'	=> __('Slider Height','florist-flower-shop'),
		'description'	=> __('Specify the slider height (px).','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '500px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_slidersettings',
		'type'=> 'text',
		'active_callback' => 'florist_flower_shop_default_slider'
	));

	//Feature Section
	$wp_customize->add_section('florist_flower_shop_feature', array(
		'title'       => __('Feature Section', 'florist-flower-shop'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','florist-flower-shop'),
		'priority'    => null,
		'panel'       => 'florist_flower_shop_panel_id',
	));

	$wp_customize->add_setting('florist_flower_shop_feature_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_feature_text',array(
		'description' => __('<p>1. More options for feature section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for feature section.</p>','florist-flower-shop'),
		'section'=> 'florist_flower_shop_feature',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('florist_flower_shop_feature_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_feature_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(FLORIST_FLOWER_SHOP_BUY_NOW).">More Info</a>",
		'section'=> 'florist_flower_shop_feature',
		'type'=> 'hidden'
	));

	//Services Section
	$wp_customize->add_section('florist_flower_shop_services', array(
		'title'       => __('Services Section', 'florist-flower-shop'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','florist-flower-shop'),
		'priority'    => null,
		'panel'       => 'florist_flower_shop_panel_id',
	));

	$wp_customize->add_setting('florist_flower_shop_services_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_services_text',array(
		'description' => __('<p>1. More options for services section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for services section.</p>','florist-flower-shop'),
		'section'=> 'florist_flower_shop_services',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('florist_flower_shop_services_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_services_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(FLORIST_FLOWER_SHOP_BUY_NOW).">More Info</a>",
		'section'=> 'florist_flower_shop_services',
		'type'=> 'hidden'
	));

	//About Section
	$wp_customize->add_section('florist_flower_shop_about', array(
		'title'       => __('About Section', 'florist-flower-shop'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','florist-flower-shop'),
		'priority'    => null,
		'panel'       => 'florist_flower_shop_panel_id',
	));

	$wp_customize->add_setting('florist_flower_shop_about_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_about_text',array(
		'description' => __('<p>1. More options for about section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for about section.</p>','florist-flower-shop'),
		'section'=> 'florist_flower_shop_about',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('florist_flower_shop_about_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_about_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(FLORIST_FLOWER_SHOP_BUY_NOW).">More Info</a>",
		'section'=> 'florist_flower_shop_about',
		'type'=> 'hidden'
	));

	//Product Slide
	$wp_customize->add_section('florist_flower_shop_product_slide_section',array(
		'title'	=> esc_html__('Popular Product Section','florist-flower-shop'),
		'description' => __('For more options of product section </br> <a class="go-pro-btn" target="blank" href="https://www.vwthemes.com/products/flower-shop-wordpress-theme">GET PRO</a>','florist-flower-shop'),
		'panel' => 'florist_flower_shop_panel_id',
	));

	$wp_customize->add_setting( 'florist_flower_shop_product_slider',array(
    	'default' => 0,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ));
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_product_slider',array(
      	'label' => esc_html__( 'Show / Hide Product Section','florist-flower-shop' ),
      	'section' => 'florist_flower_shop_product_slide_section'
    )));

	$args = array(
       'type'                     => 'product',
        'child_of'                 => 0,
        'parent'                   => '',
        'orderby'                  => 'term_group',
        'order'                    => 'ASC',
        'hide_empty'               => false,
        'hierarchical'             => 1,
        'number'                   => '',
        'taxonomy'                 => 'product_cat',
        'pad_counts'               => false
    );
    $categories = get_categories( $args );
    $cats = array();
    $i = 0;
    foreach($categories as $category){
        if($i==0){
            $default = $category->slug;
            $i++;
        }
        $cats[$category->slug] = $category->name;
    }
    $wp_customize->add_setting('florist_flower_shop_product_slide',array(
        'sanitize_callback' => 'florist_flower_shop_sanitize_select',
    ));
    $wp_customize->add_control('florist_flower_shop_product_slide',array(
        'type'    => 'select',
        'choices' => $cats,
        'label' => __('Select Product Category','florist-flower-shop'),
        'section' => 'florist_flower_shop_product_slide_section',
    ));

	//Product Section
	$wp_customize->add_section('florist_flower_shop_product_section',array(
		'title'	=> esc_html__('BestSelling Product Section','florist-flower-shop'),
		'description' => __('For more options of bestselling product section </br> <a class="go-pro-btn" target="blank" href="https://www.vwthemes.com/products/flower-shop-wordpress-theme">GET PRO</a>','florist-flower-shop'),
		'panel' => 'florist_flower_shop_panel_id',
	));

	$wp_customize->add_setting( 'florist_flower_shop_product_settings' , array(
		'default' => '',
		'sanitize_callback' => 'florist_flower_shop_sanitize_dropdown_pages'
	) );
	$wp_customize->add_control( 'florist_flower_shop_product_settings' , array(
		'label'    => esc_html__( 'Select Produt Page', 'florist-flower-shop' ),
		'section'  => 'florist_flower_shop_product_section',
		'type'     => 'dropdown-pages'
	) );

	//Connect Withus Section
	$wp_customize->add_section('florist_flower_shop_connect_withus', array(
		'title'       => __('Connect With us Section', 'florist-flower-shop'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','florist-flower-shop'),
		'priority'    => null,
		'panel'       => 'florist_flower_shop_panel_id',
	));

	$wp_customize->add_setting('florist_flower_shop_connect_withus_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_connect_withus_text',array(
		'description' => __('<p>1. More options for connect with us section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for connect with us section.</p>','florist-flower-shop'),
		'section'=> 'florist_flower_shop_connect_withus',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('florist_flower_shop_connect_withus_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_connect_withus_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(FLORIST_FLOWER_SHOP_BUY_NOW).">More Info</a>",
		'section'=> 'florist_flower_shop_connect_withus',
		'type'=> 'hidden'
	));

	//Category Products Section
	$wp_customize->add_section('florist_flower_shop_category_products', array(
		'title'       => __('Category Products Section', 'florist-flower-shop'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','florist-flower-shop'),
		'priority'    => null,
		'panel'       => 'florist_flower_shop_panel_id',
	));

	$wp_customize->add_setting('florist_flower_shop_category_products_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_category_products_text',array(
		'description' => __('<p>1. More options for category products section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for category products section.</p>','florist-flower-shop'),
		'section'=> 'florist_flower_shop_category_products',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('florist_flower_shop_category_products_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_category_products_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(FLORIST_FLOWER_SHOP_BUY_NOW).">More Info</a>",
		'section'=> 'florist_flower_shop_category_products',
		'type'=> 'hidden'
	));

	//Partners Section
	$wp_customize->add_section('florist_flower_shop_partners', array(
		'title'       => __('Partners Section', 'florist-flower-shop'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','florist-flower-shop'),
		'priority'    => null,
		'panel'       => 'florist_flower_shop_panel_id',
	));

	$wp_customize->add_setting('florist_flower_shop_partners_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_partners_text',array(
		'description' => __('<p>1. More options for partners section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for partners section.</p>','florist-flower-shop'),
		'section'=> 'florist_flower_shop_partners',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('florist_flower_shop_partners_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_partners_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(FLORIST_FLOWER_SHOP_BUY_NOW).">More Info</a>",
		'section'=> 'florist_flower_shop_partners',
		'type'=> 'hidden'
	));

	//Newsletter Section
	$wp_customize->add_section('florist_flower_shop_newsletter', array(
		'title'       => __('Newsletter Section', 'florist-flower-shop'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','florist-flower-shop'),
		'priority'    => null,
		'panel'       => 'florist_flower_shop_panel_id',
	));

	$wp_customize->add_setting('florist_flower_shop_newsletter_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_newsletter_text',array(
		'description' => __('<p>1. More options for newsletter section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for newsletter section.</p>','florist-flower-shop'),
		'section'=> 'florist_flower_shop_newsletter',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('florist_flower_shop_newsletter_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_newsletter_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(FLORIST_FLOWER_SHOP_BUY_NOW).">More Info</a>",
		'section'=> 'florist_flower_shop_newsletter',
		'type'=> 'hidden'
	));

	//Pricing Plan Section
	$wp_customize->add_section('florist_flower_shop_pricing_plan', array(
		'title'       => __('Pricing Plan Section', 'florist-flower-shop'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','florist-flower-shop'),
		'priority'    => null,
		'panel'       => 'florist_flower_shop_panel_id',
	));

	$wp_customize->add_setting('florist_flower_shop_pricing_plan_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_pricing_plan_text',array(
		'description' => __('<p>1. More options for pricing plan section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for pricing plan section.</p>','florist-flower-shop'),
		'section'=> 'florist_flower_shop_pricing_plan',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('florist_flower_shop_pricing_plan_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_pricing_plan_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(FLORIST_FLOWER_SHOP_BUY_NOW).">More Info</a>",
		'section'=> 'florist_flower_shop_pricing_plan',
		'type'=> 'hidden'
	));

	//Testimonials Section
	$wp_customize->add_section('florist_flower_shop_testimonials', array(
		'title'       => __('Testimonials Section', 'florist-flower-shop'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','florist-flower-shop'),
		'priority'    => null,
		'panel'       => 'florist_flower_shop_panel_id',
	));

	$wp_customize->add_setting('florist_flower_shop_testimonials_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_testimonials_text',array(
		'description' => __('<p>1. More options for testimonials section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for testimonials section.</p>','florist-flower-shop'),
		'section'=> 'florist_flower_shop_testimonials',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('florist_flower_shop_testimonials_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_testimonials_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(FLORIST_FLOWER_SHOP_BUY_NOW).">More Info</a>",
		'section'=> 'florist_flower_shop_testimonials',
		'type'=> 'hidden'
	));

	//Instagram Section
	$wp_customize->add_section('florist_flower_shop_instagram', array(
		'title'       => __('Instagram Section', 'florist-flower-shop'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','florist-flower-shop'),
		'priority'    => null,
		'panel'       => 'florist_flower_shop_panel_id',
	));

	$wp_customize->add_setting('florist_flower_shop_instagram_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_instagram_text',array(
		'description' => __('<p>1. More options for instagram section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for instagram section.</p>','florist-flower-shop'),
		'section'=> 'florist_flower_shop_instagram',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('florist_flower_shop_instagram_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_instagram_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(FLORIST_FLOWER_SHOP_BUY_NOW).">More Info</a>",
		'section'=> 'florist_flower_shop_instagram',
		'type'=> 'hidden'
	));

	//Get In Touch Section
	$wp_customize->add_section('florist_flower_shop_get_in_touch', array(
		'title'       => __('Get In Touch Section', 'florist-flower-shop'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','florist-flower-shop'),
		'priority'    => null,
		'panel'       => 'florist_flower_shop_panel_id',
	));

	$wp_customize->add_setting('florist_flower_shop_get_in_touch_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_get_in_touch_text',array(
		'description' => __('<p>1. More options for get in touch section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for get in touch section.</p>','florist-flower-shop'),
		'section'=> 'florist_flower_shop_get_in_touch',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('florist_flower_shop_get_in_touch_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_get_in_touch_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(FLORIST_FLOWER_SHOP_BUY_NOW).">More Info</a>",
		'section'=> 'florist_flower_shop_get_in_touch',
		'type'=> 'hidden'
	));

	//Footer Text
	$wp_customize->add_section('florist_flower_shop_footer',array(
		'title'	=> esc_html__('Footer Settings','florist-flower-shop'),
		'description' => __('For more options of footer section </br> <a class="go-pro-btn" target="blank" href="https://www.vwthemes.com/products/flower-shop-wordpress-theme">GET PRO</a>','florist-flower-shop'),
		'panel' => 'florist_flower_shop_panel_id',
	));

	$wp_customize->add_setting( 'florist_flower_shop_footer_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ));
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_footer_hide_show',array(
      'label' => esc_html__( 'Show / Hide Footer','florist-flower-shop' ),
      'section' => 'florist_flower_shop_footer'
    )));

   	// font size
	$wp_customize->add_setting('florist_flower_shop_button_footer_font_size',array(
		'default'=> 30,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_button_footer_font_size',array(
		'label'	=> __('Footer Heading Font Size','florist-flower-shop'),
  		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'florist_flower_shop_footer',
	));

	$wp_customize->add_setting('florist_flower_shop_button_footer_heading_letter_spacing',array(
		'default'=> 1,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_button_footer_heading_letter_spacing',array(
		'label'	=> __('Heading Letter Spacing','florist-flower-shop'),
  		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
	),
		'section'=> 'florist_flower_shop_footer',
	));

	// text trasform
	$wp_customize->add_setting('florist_flower_shop_button_footer_text_transform',array(
		'default'=> 'Capitalize',
		'sanitize_callback'	=> 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_button_footer_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Heading Text Transform','florist-flower-shop'),
		'choices' => array(
      'Uppercase' => __('Uppercase','florist-flower-shop'),
      'Capitalize' => __('Capitalize','florist-flower-shop'),
      'Lowercase' => __('Lowercase','florist-flower-shop'),
    ),
		'section'=> 'florist_flower_shop_footer',
	));

	$wp_customize->add_setting('florist_flower_shop_footer_heading_weight',array(
        'default' => 600,
        'transport' => 'refresh',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_footer_heading_weight',array(
        'type' => 'select',
        'label' => __('Heading Font Weight','florist-flower-shop'),
        'section' => 'florist_flower_shop_footer',
        'choices' => array(
        	'100' => __('100','florist-flower-shop'),
            '200' => __('200','florist-flower-shop'),
            '300' => __('300','florist-flower-shop'),
            '400' => __('400','florist-flower-shop'),
            '500' => __('500','florist-flower-shop'),
            '600' => __('600','florist-flower-shop'),
            '700' => __('700','florist-flower-shop'),
            '800' => __('800','florist-flower-shop'),
            '900' => __('900','florist-flower-shop'),
        ),
	) );

	$wp_customize->add_setting('florist_flower_shop_footer_template',array(
	  'default'	=> esc_html('florist_flower_shop-footer-one'),
	  'sanitize_callback'	=> 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_footer_template',array(
	      'label'	=> esc_html__('Footer style','florist-flower-shop'),
	      'section'	=> 'florist_flower_shop_footer',
	      'setting'	=> 'florist_flower_shop_footer_template',
	      'type' => 'select',
	      'choices' => array(
	          'florist_flower_shop-footer-one' => esc_html__('Style 1', 'florist-flower-shop'),
	          'florist_flower_shop-footer-two' => esc_html__('Style 2', 'florist-flower-shop'),
	          'florist_flower_shop-footer-three' => esc_html__('Style 3', 'florist-flower-shop'),
	          'florist_flower_shop-footer-four' => esc_html__('Style 4', 'florist-flower-shop'),
	          'florist_flower_shop-footer-five' => esc_html__('Style 5', 'florist-flower-shop'),
	          )
	));

	$wp_customize->add_setting('florist_flower_shop_footer_background_color', array(
		'default'           => '#384da6',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'florist_flower_shop_footer_background_color', array(
		'label'    => __('Footer Background Color', 'florist-flower-shop'),
		'section'  => 'florist_flower_shop_footer',
	)));

	$wp_customize->add_setting('florist_flower_shop_footer_background_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'florist_flower_shop_footer_background_image',array(
        'label' => __('Footer Background Image','florist-flower-shop'),
        'section' => 'florist_flower_shop_footer'
	)));

	$wp_customize->add_setting('florist_flower_shop_footer_img_position',array(
	  'default' => 'center center',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_footer_img_position',array(
		'type' => 'select',
		'label' => __('Footer Image Position','florist-flower-shop'),
		'section' => 'florist_flower_shop_footer',
		'choices' 	=> array(
			'left top' 		=> esc_html__( 'Top Left', 'florist-flower-shop' ),
			'center top'   => esc_html__( 'Top', 'florist-flower-shop' ),
			'right top'   => esc_html__( 'Top Right', 'florist-flower-shop' ),
			'left center'   => esc_html__( 'Left', 'florist-flower-shop' ),
			'center center'   => esc_html__( 'Center', 'florist-flower-shop' ),
			'right center'   => esc_html__( 'Right', 'florist-flower-shop' ),
			'left bottom'   => esc_html__( 'Bottom Left', 'florist-flower-shop' ),
			'center bottom'   => esc_html__( 'Bottom', 'florist-flower-shop' ),
			'right bottom'   => esc_html__( 'Bottom Right', 'florist-flower-shop' ),
		),
	));

	// Footer
	$wp_customize->add_setting('florist_flower_shop_img_footer',array(
		'default'=> 'scroll',
		'sanitize_callback'	=> 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_img_footer',array(
		'type' => 'select',
		'label'	=> __('Footer Background Attatchment','florist-flower-shop'),
		'choices' => array(
            'fixed' => __('fixed','florist-flower-shop'),
            'scroll' => __('scroll','florist-flower-shop'),
        ),
		'section'=> 'florist_flower_shop_footer',
	));

	$wp_customize->add_setting('florist_flower_shop_footer_widgets_heading',array(
        'default' => 'Left',
        'transport' => 'refresh',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_footer_widgets_heading',array(
        'type' => 'select',
        'label' => __('Footer Widget Heading','florist-flower-shop'),
        'section' => 'florist_flower_shop_footer',
        'choices' => array(
        	'Left' => __('Left','florist-flower-shop'),
            'Center' => __('Center','florist-flower-shop'),
            'Right' => __('Right','florist-flower-shop')
        ),
	) );

	$wp_customize->add_setting('florist_flower_shop_footer_widgets_content',array(
        'default' => 'Left',
        'transport' => 'refresh',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_footer_widgets_content',array(
        'type' => 'select',
        'label' => __('Footer Widget Content','florist-flower-shop'),
        'section' => 'florist_flower_shop_footer',
        'choices' => array(
        	'Left' => __('Left','florist-flower-shop'),
            'Center' => __('Center','florist-flower-shop'),
            'Right' => __('Right','florist-flower-shop')
        ),
	) );

	// footer padding
	$wp_customize->add_setting('florist_flower_shop_footer_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_footer_padding',array(
		'label'	=> __('Footer Top Bottom Padding','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
      'placeholder' => __( '10px', 'florist-flower-shop' ),
    ),
		'section'=> 'florist_flower_shop_footer',
		'type'=> 'text'
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('florist_flower_shop_footer_text', array(
		'selector' => '.copyright p',
		'render_callback' => 'florist_flower_shop_customize_partial_florist_flower_shop_footer_text',
	));

	$wp_customize->add_setting( 'florist_flower_shop_copyright_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ));
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_copyright_hide_show',array(
      'label' => esc_html__( 'Show / Hide Copyright','florist-flower-shop' ),
      'section' => 'florist_flower_shop_footer'
    )));

	$wp_customize->add_setting('florist_flower_shop_copyright_background_color', array(
		'default'           => '#9a45ad',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'florist_flower_shop_copyright_background_color', array(
		'label'    => __('Copyright Background Color', 'florist-flower-shop'),
		'section'  => 'florist_flower_shop_footer',
	)));

	$wp_customize->add_setting('florist_flower_shop_footer_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_footer_text',array(
		'label'	=> esc_html__('Copyright Text','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Copyright 2020, .....', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_copyright_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_copyright_font_size',array(
		'label'	=> __('Copyright Font Size','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_copyright_alingment',array(
        'default' => 'center',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Image_Radio_Control($wp_customize, 'florist_flower_shop_copyright_alingment', array(
        'type' => 'select',
        'label' => esc_html__('Copyright Alignment','florist-flower-shop'),
        'section' => 'florist_flower_shop_footer',
        'settings' => 'florist_flower_shop_copyright_alingment',
        'choices' => array(
            'left' => esc_url(get_template_directory_uri()).'/assets/images/copyright1.png',
            'center' => esc_url(get_template_directory_uri()).'/assets/images/copyright2.png',
            'right' => esc_url(get_template_directory_uri()).'/assets/images/copyright3.png'
    ))));

	$wp_customize->add_setting( 'florist_flower_shop_footer_scroll',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ));
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_footer_scroll',array(
      	'label' => esc_html__( 'Show / Hide Scroll to Top','florist-flower-shop' ),
      	'section' => 'florist_flower_shop_footer'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial('florist_flower_shop_scroll_to_top_icon', array(
		'selector' => '.scrollup i',
		'render_callback' => 'florist_flower_shop_customize_partial_florist_flower_shop_scroll_to_top_icon',
	));

    $wp_customize->add_setting('florist_flower_shop_scroll_to_top_icon',array(
		'default'	=> 'fas fa-long-arrow-alt-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
        $wp_customize,'florist_flower_shop_scroll_to_top_icon',array(
		'label'	=> __('Add Scroll to Top Icon','florist-flower-shop'),
		'transport' => 'refresh',
		'section'	=> 'florist_flower_shop_footer',
		'setting'	=> 'florist_flower_shop_scroll_to_top_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('florist_flower_shop_scroll_to_top_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_scroll_to_top_font_size',array(
		'label'	=> __('Icon Font Size','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_scroll_to_top_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_scroll_to_top_padding',array(
		'label'	=> __('Icon Top Bottom Padding','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_scroll_to_top_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_scroll_to_top_width',array(
		'label'	=> __('Icon Width','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_scroll_to_top_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_scroll_to_top_height',array(
		'label'	=> __('Icon Height','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'florist_flower_shop_scroll_to_top_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'florist_flower_shop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'florist_flower_shop_scroll_to_top_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','florist-flower-shop' ),
		'section'     => 'florist_flower_shop_footer',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

    $wp_customize->add_setting('florist_flower_shop_scroll_top_alignment',array(
        'default' => 'Right',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Image_Radio_Control($wp_customize, 'florist_flower_shop_scroll_top_alignment', array(
        'type' => 'select',
        'label' => esc_html__('Scroll To Top','florist-flower-shop'),
        'section' => 'florist_flower_shop_footer',
        'settings' => 'florist_flower_shop_scroll_top_alignment',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/layout2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/layout3.png'
    ))));

	//Blog Post
	$wp_customize->add_panel( $florist_flower_shop_parent_panel );

	$BlogPostParentPanel = new Florist_Flower_Shop_WP_Customize_Panel( $wp_customize, 'florist_flower_shop_blog_post_parent_panel', array(
		'title' => esc_html__( 'Blog Post Settings', 'florist-flower-shop' ),
		'panel' => 'florist_flower_shop_panel_id',
		'priority' => 20,
	));

	$wp_customize->add_panel( $BlogPostParentPanel );

	// Add example section and controls to the middle (second) panel
	$wp_customize->add_section( 'florist_flower_shop_post_settings', array(
		'title' => esc_html__( 'Post Settings', 'florist-flower-shop' ),
		'panel' => 'florist_flower_shop_blog_post_parent_panel',
	));

	//Blog Post Layout
    $wp_customize->add_setting('florist_flower_shop_blog_layout_option',array(
        'default' => 'Default',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
    ));
    $wp_customize->add_control(new Florist_Flower_Shop_Image_Radio_Control($wp_customize, 'florist_flower_shop_blog_layout_option', array(
        'type' => 'select',
        'label' => esc_html__('Blog Post Layouts','florist-flower-shop'),
        'section' => 'florist_flower_shop_post_settings',
        'choices' => array(
            'Default' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout2.png',
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout3.png',
    ))));

	$wp_customize->add_setting('florist_flower_shop_theme_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_theme_options',array(
        'type' => 'select',
        'label' => esc_html__('Post Sidebar Layout','florist-flower-shop'),
        'description' => esc_html__('Here you can change the sidebar layout for posts. ','florist-flower-shop'),
        'section' => 'florist_flower_shop_post_settings',
        'choices' => array(
            'Left Sidebar' => esc_html__('Left Sidebar','florist-flower-shop'),
            'Right Sidebar' => esc_html__('Right Sidebar','florist-flower-shop'),
            'One Column' => esc_html__('One Column','florist-flower-shop'),
            'Three Columns' => esc_html__('Three Columns','florist-flower-shop'),
            'Four Columns' => esc_html__('Four Columns','florist-flower-shop'),
            'Grid Layout' => esc_html__('Grid Layout','florist-flower-shop')
        ),
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('florist_flower_shop_toggle_postdate', array(
		'selector' => '.post-main-box h2 a',
		'render_callback' => 'florist_flower_shop_customize_partial_florist_flower_shop_toggle_postdate',
	));

  	$wp_customize->add_setting('florist_flower_shop_toggle_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
        $wp_customize,'florist_flower_shop_toggle_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','florist-flower-shop'),
		'transport' => 'refresh',
		'section'	=> 'florist_flower_shop_post_settings',
		'setting'	=> 'florist_flower_shop_toggle_postdate_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'florist_flower_shop_toggle_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_toggle_postdate',array(
        'label' => esc_html__( 'Show / Hide Post Date','florist-flower-shop' ),
        'section' => 'florist_flower_shop_post_settings'
    )));

	$wp_customize->add_setting('florist_flower_shop_toggle_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
        $wp_customize,'florist_flower_shop_toggle_author_icon',array(
		'label'	=> __('Add Author Icon','florist-flower-shop'),
		'transport' => 'refresh',
		'section'	=> 'florist_flower_shop_post_settings',
		'setting'	=> 'florist_flower_shop_toggle_author_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'florist_flower_shop_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_toggle_author',array(
		'label' => esc_html__( 'Show / Hide Author','florist-flower-shop' ),
		'section' => 'florist_flower_shop_post_settings'
    )));

    $wp_customize->add_setting('florist_flower_shop_toggle_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
        $wp_customize,'florist_flower_shop_toggle_comments_icon',array(
		'label'	=> __('Add Comments Icon','florist-flower-shop'),
		'transport' => 'refresh',
		'section'	=> 'florist_flower_shop_post_settings',
		'setting'	=> 'florist_flower_shop_toggle_comments_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'florist_flower_shop_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_toggle_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','florist-flower-shop' ),
		'section' => 'florist_flower_shop_post_settings'
    )));

    $wp_customize->add_setting('florist_flower_shop_toggle_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
        $wp_customize,'florist_flower_shop_toggle_time_icon',array(
		'label'	=> __('Add Time Icon','florist-flower-shop'),
		'transport' => 'refresh',
		'section'	=> 'florist_flower_shop_post_settings',
		'setting'	=> 'florist_flower_shop_toggle_time_icon',
		'type'		=> 'icon'
	)));

     $wp_customize->add_setting( 'florist_flower_shop_toggle_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_toggle_time',array(
		'label' => esc_html__( 'Show / Hide Time','florist-flower-shop' ),
		'section' => 'florist_flower_shop_post_settings'
    )));

    $wp_customize->add_setting( 'florist_flower_shop_featured_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
	));
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_featured_image_hide_show', array(
		'label' => esc_html__( 'Show / Hide Featured Image','florist-flower-shop' ),
		'section' => 'florist_flower_shop_post_settings'
    )));

    $wp_customize->add_setting( 'florist_flower_shop_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'florist_flower_shop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'florist_flower_shop_featured_image_border_radius', array(
		'label'       => esc_html__( 'Featured Image Border Radius','florist-flower-shop' ),
		'section'     => 'florist_flower_shop_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'florist_flower_shop_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'florist_flower_shop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'florist_flower_shop_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Featured Image Box Shadow','florist-flower-shop' ),
		'section'     => 'florist_flower_shop_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Featured Image
	$wp_customize->add_setting('florist_flower_shop_blog_post_featured_image_dimension',array(
       'default' => 'default',
       'sanitize_callback'	=> 'florist_flower_shop_sanitize_choices'
	));
  	$wp_customize->add_control('florist_flower_shop_blog_post_featured_image_dimension',array(
		'type' => 'select',
		'label'	=> __('Blog Post Featured Image Dimension','florist-flower-shop'),
		'section'	=> 'florist_flower_shop_post_settings',
		'choices' => array(
		'default' => __('Default','florist-flower-shop'),
		'custom' => __('Custom Image Size','florist-flower-shop'),
      ),
  	));

	$wp_customize->add_setting('florist_flower_shop_blog_post_featured_image_custom_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
		));
	$wp_customize->add_control('florist_flower_shop_blog_post_featured_image_custom_width',array(
		'label'	=> __('Featured Image Custom Width','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
    	'placeholder' => __( '10px', 'florist-flower-shop' ),),
		'section'=> 'florist_flower_shop_post_settings',
		'type'=> 'text',
		'active_callback' => 'florist_flower_shop_blog_post_featured_image_dimension'
		));

	$wp_customize->add_setting('florist_flower_shop_blog_post_featured_image_custom_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_blog_post_featured_image_custom_height',array(
		'label'	=> __('Featured Image Custom Height','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
    	'placeholder' => __( '10px', 'florist-flower-shop' ),),
		'section'=> 'florist_flower_shop_post_settings',
		'type'=> 'text',
		'active_callback' => 'florist_flower_shop_blog_post_featured_image_dimension'
	));

    $wp_customize->add_setting( 'florist_flower_shop_excerpt_number', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'florist_flower_shop_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'florist_flower_shop_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','florist-flower-shop' ),
		'section'     => 'florist_flower_shop_post_settings',
		'type'        => 'range',
		'settings'    => 'florist_flower_shop_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('florist_flower_shop_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','florist-flower-shop'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','florist-flower-shop'),
		'section'=> 'florist_flower_shop_post_settings',
		'type'=> 'text'
	));

    $wp_customize->add_setting('florist_flower_shop_excerpt_settings',array(
        'default' => 'Excerpt',
        'transport' => 'refresh',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_excerpt_settings',array(
        'type' => 'select',
        'label' => esc_html__('Post Content','florist-flower-shop'),
        'section' => 'florist_flower_shop_post_settings',
        'choices' => array(
        	'Content' => esc_html__('Content','florist-flower-shop'),
            'Excerpt' => esc_html__('Excerpt','florist-flower-shop'),
            'No Content' => esc_html__('No Content','florist-flower-shop')
        ),
	) );

    $wp_customize->add_setting('florist_flower_shop_blog_page_posts_settings',array(
        'default' => 'Into Blocks',
        'transport' => 'refresh',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_blog_page_posts_settings',array(
        'type' => 'select',
        'label' => __('Display Blog Posts','florist-flower-shop'),
        'section' => 'florist_flower_shop_post_settings',
        'choices' => array(
        	'Into Blocks' => __('Into Blocks','florist-flower-shop'),
            'Without Blocks' => __('Without Blocks','florist-flower-shop')
        ),
	) );

	$wp_customize->add_setting('florist_flower_shop_blog_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_blog_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '[...]', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_post_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'florist_flower_shop_blog_pagination_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ));
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_blog_pagination_hide_show',array(
		'label' => esc_html__( 'Show / Hide Blog Pagination','florist-flower-shop' ),
		'section' => 'florist_flower_shop_post_settings'
    )));

	$wp_customize->add_setting( 'florist_flower_shop_blog_pagination_type', array(
        'default'			=> 'blog-page-numbers',
        'sanitize_callback'	=> 'florist_flower_shop_sanitize_choices'
    ));
    $wp_customize->add_control( 'florist_flower_shop_blog_pagination_type', array(
        'section' => 'florist_flower_shop_post_settings',
        'type' => 'select',
        'label' => __( 'Blog Pagination', 'florist-flower-shop' ),
        'choices'		=> array(
            'blog-page-numbers'  => __( 'Numeric', 'florist-flower-shop' ),
            'next-prev' => __( 'Older Posts/Newer Posts', 'florist-flower-shop' ),
    )));

    // Button Settings
	$wp_customize->add_section( 'florist_flower_shop_button_settings', array(
		'title' => esc_html__( 'Button Settings', 'florist-flower-shop' ),
		'panel' => 'florist_flower_shop_blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('florist_flower_shop_button_text', array(
		'selector' => '.post-main-box .more-btn a',
		'render_callback' => 'florist_flower_shop_customize_partial_florist_flower_shop_button_text',
	));

    $wp_customize->add_setting('florist_flower_shop_button_text',array(
		'default'=> esc_html__('Read More','florist-flower-shop'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_button_text',array(
		'label'	=> esc_html__('Add Button Text','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Read More', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_button_settings',
		'type'=> 'text'
	));

	// font size button
	$wp_customize->add_setting('florist_flower_shop_button_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_button_font_size',array(
		'label'	=> __('Button Font Size','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
      	'placeholder' => __( '10px', 'florist-flower-shop' ),
    ),
    	'type'        => 'text',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'florist_flower_shop_button_settings',
	));

	$wp_customize->add_setting( 'florist_flower_shop_button_border_radius', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'florist_flower_shop_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'florist_flower_shop_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','florist-flower-shop' ),
		'section'     => 'florist_flower_shop_button_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('florist_flower_shop_button_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_button_padding_top_bottom',array(
		'label'	=> esc_html__('Padding Top Bottom','florist-flower-shop'),
		'description' => esc_html__('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'florist-flower-shop' ),
        ),
		'section' => 'florist_flower_shop_button_settings',
		'type' => 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_button_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_button_padding_left_right',array(
		'label'	=> esc_html__('Padding Left Right','florist-flower-shop'),
		'description' => esc_html__('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'florist-flower-shop' ),
        ),
		'section' => 'florist_flower_shop_button_settings',
		'type' => 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_button_letter_spacing',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_button_letter_spacing',array(
		'label'	=> __('Button Letter Spacing','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
      	'placeholder' => __( '10px', 'florist-flower-shop' ),
    ),
    	'type'        => 'text',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'florist_flower_shop_button_settings',
	));

	// text trasform
	$wp_customize->add_setting('florist_flower_shop_button_text_transform',array(
		'default'=> 'Uppercase',
		'sanitize_callback'	=> 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_button_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Button Text Transform','florist-flower-shop'),
		'choices' => array(
            'Uppercase' => __('Uppercase','florist-flower-shop'),
            'Capitalize' => __('Capitalize','florist-flower-shop'),
            'Lowercase' => __('Lowercase','florist-flower-shop'),
        ),
		'section'=> 'florist_flower_shop_button_settings',
	));

	// Related Post Settings
	$wp_customize->add_section( 'florist_flower_shop_related_posts_settings', array(
		'title' => esc_html__( 'Related Posts Settings', 'florist-flower-shop' ),
		'panel' => 'florist_flower_shop_blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('florist_flower_shop_related_post_title', array(
		'selector' => '.related-post h3',
		'render_callback' => 'florist_flower_shop_customize_partial_florist_flower_shop_related_post_title',
	));

    $wp_customize->add_setting( 'florist_flower_shop_related_post',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_related_post',array(
		'label' => esc_html__( 'Show / Hide Related Post','florist-flower-shop' ),
		'section' => 'florist_flower_shop_related_posts_settings'
    )));

    $wp_customize->add_setting('florist_flower_shop_related_post_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_related_post_title',array(
		'label'	=> esc_html__('Add Related Post Title','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Related Post', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_related_posts_settings',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('florist_flower_shop_related_posts_count',array(
		'default'=> 3,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_related_posts_count',array(
		'label'	=> esc_html__('Add Related Post Count','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '3', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_related_posts_settings',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'florist_flower_shop_related_posts_excerpt_number', array(
		'default'              => 20,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'florist_flower_shop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'florist_flower_shop_related_posts_excerpt_number', array(
		'label'       => esc_html__( 'Related Posts Excerpt length','florist-flower-shop' ),
		'section'     => 'florist_flower_shop_related_posts_settings',
		'type'        => 'range',
		'settings'    => 'florist_flower_shop_related_posts_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'florist_flower_shop_related_posts_excerpt_number', array(
		'default'              => 20,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'florist_flower_shop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'florist_flower_shop_related_posts_excerpt_number', array(
		'label'       => esc_html__( 'Related Posts Excerpt length','florist-flower-shop' ),
		'section'     => 'florist_flower_shop_related_posts_settings',
		'type'        => 'range',
		'settings'    => 'florist_flower_shop_related_posts_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'florist_flower_shop_related_toggle_postdate',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
  	));
  	$wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_related_toggle_postdate',array(
	    'label' => esc_html__( 'Show / Hide Post Date','florist-flower-shop' ),
	    'section' => 'florist_flower_shop_related_posts_settings'
  	)));

  	$wp_customize->add_setting('florist_flower_shop_related_postdate_icon',array(
	    'default' => 'fas fa-calendar-alt',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
 	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
  	$wp_customize,'florist_flower_shop_related_postdate_icon',array(
	    'label' => __('Add Post Date Icon','florist-flower-shop'),
	    'transport' => 'refresh',
	    'section' => 'florist_flower_shop_related_posts_settings',
	    'setting' => 'florist_flower_shop_related_postdate_icon',
	    'type'    => 'icon'
  	)));

	$wp_customize->add_setting( 'florist_flower_shop_related_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
  	));
  	$wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_related_toggle_author',array(
		'label' => esc_html__( 'Show / Hide Author','florist-flower-shop' ),
		'section' => 'florist_flower_shop_related_posts_settings'
  	)));

  	$wp_customize->add_setting('florist_flower_shop_related_author_icon',array(
	    'default' => 'fas fa-user',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
  	$wp_customize,'florist_flower_shop_related_author_icon',array(
	    'label' => __('Add Author Icon','florist-flower-shop'),
	    'transport' => 'refresh',
	    'section' => 'florist_flower_shop_related_posts_settings',
	    'setting' => 'florist_flower_shop_related_author_icon',
	    'type'    => 'icon'
  	)));

	$wp_customize->add_setting( 'florist_flower_shop_related_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
  	) );
  	$wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_related_toggle_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','florist-flower-shop' ),
		'section' => 'florist_flower_shop_related_posts_settings'
  	)));

  	$wp_customize->add_setting('florist_flower_shop_related_comments_icon',array(
	    'default' => 'fa fa-comments',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
  	$wp_customize,'florist_flower_shop_related_comments_icon',array(
	    'label' => __('Add Comments Icon','florist-flower-shop'),
	    'transport' => 'refresh',
	    'section' => 'florist_flower_shop_related_posts_settings',
	    'setting' => 'florist_flower_shop_related_comments_icon',
	    'type'    => 'icon'
  	)));

	$wp_customize->add_setting( 'florist_flower_shop_related_toggle_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
  	) );
  	$wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_related_toggle_time',array(
		'label' => esc_html__( 'Show / Hide Time','florist-flower-shop' ),
		'section' => 'florist_flower_shop_related_posts_settings'
  	)));

  	$wp_customize->add_setting('florist_flower_shop_related_time_icon',array(
	    'default' => 'fas fa-clock',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
  	$wp_customize,'florist_flower_shop_related_time_icon',array(
	    'label' => __('Add Time Icon','florist-flower-shop'),
	    'transport' => 'refresh',
	    'section' => 'florist_flower_shop_related_posts_settings',
	    'setting' => 'florist_flower_shop_related_time_icon',
	    'type'    => 'icon'
  	)));

  	$wp_customize->add_setting('florist_flower_shop_related_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_related_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','florist-flower-shop'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','florist-flower-shop'),
		'section'=> 'florist_flower_shop_related_posts_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'florist_flower_shop_related_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
	));
  	$wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_related_image_hide_show', array(
		'label' => esc_html__( 'Show / Hide Featured Image','florist-flower-shop' ),
		'section' => 'florist_flower_shop_related_posts_settings'
  	)));

  	$wp_customize->add_setting( 'florist_flower_shop_related_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'florist_flower_shop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'florist_flower_shop_related_image_box_shadow', array(
		'label'       => esc_html__( 'Related post Image Box Shadow','florist-flower-shop' ),
		'section'     => 'florist_flower_shop_related_posts_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

  	$wp_customize->add_setting('florist_flower_shop_related_button_text',array(
		'default'=> esc_html__('Read More','florist-flower-shop'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('florist_flower_shop_related_button_text',array(
		'label'	=> esc_html__('Add Button Text','florist-flower-shop'),
		'input_attrs' => array(
      'placeholder' => esc_html__( 'Read More', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_related_posts_settings',
		'type'=> 'text'
	));


	// Single Posts Settings
	$wp_customize->add_section( 'florist_flower_shop_single_blog_settings', array(
		'title' => __( 'Single Post Settings', 'florist-flower-shop' ),
		'panel' => 'florist_flower_shop_blog_post_parent_panel',
	));

  	$wp_customize->add_setting('florist_flower_shop_single_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
        $wp_customize,'florist_flower_shop_single_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','florist-flower-shop'),
		'transport' => 'refresh',
		'section'	=> 'florist_flower_shop_single_blog_settings',
		'setting'	=> 'florist_flower_shop_single_postdate_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'florist_flower_shop_single_postdate',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
	) );
	$wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_single_postdate',array(
	    'label' => esc_html__( 'Show / Hide Date','florist-flower-shop' ),
	   'section' => 'florist_flower_shop_single_blog_settings'
	)));

	$wp_customize->add_setting('florist_flower_shop_single_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
        $wp_customize,'florist_flower_shop_single_author_icon',array(
		'label'	=> __('Add Author Icon','florist-flower-shop'),
		'transport' => 'refresh',
		'section'	=> 'florist_flower_shop_single_blog_settings',
		'setting'	=> 'florist_flower_shop_single_author_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'florist_flower_shop_single_author',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
	) );
	$wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_single_author',array(
	    'label' => esc_html__( 'Show / Hide Author','florist-flower-shop' ),
	    'section' => 'florist_flower_shop_single_blog_settings'
	)));

   	$wp_customize->add_setting('florist_flower_shop_single_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
        $wp_customize,'florist_flower_shop_single_comments_icon',array(
		'label'	=> __('Add Comments Icon','florist-flower-shop'),
		'transport' => 'refresh',
		'section'	=> 'florist_flower_shop_single_blog_settings',
		'setting'	=> 'florist_flower_shop_single_comments_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'florist_flower_shop_single_comments',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
	) );
	$wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_single_comments',array(
	    'label' => esc_html__( 'Show / Hide Comments','florist-flower-shop' ),
	    'section' => 'florist_flower_shop_single_blog_settings'
	)));

  	$wp_customize->add_setting('florist_flower_shop_single_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
        $wp_customize,'florist_flower_shop_single_time_icon',array(
		'label'	=> __('Add Time Icon','florist-flower-shop'),
		'transport' => 'refresh',
		'section'	=> 'florist_flower_shop_single_blog_settings',
		'setting'	=> 'florist_flower_shop_single_time_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'florist_flower_shop_single_time',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
	) );
	$wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_single_time',array(
	    'label' => esc_html__( 'Show / Hide Time','florist-flower-shop' ),
	    'section' => 'florist_flower_shop_single_blog_settings'
	)));

	$wp_customize->add_setting( 'florist_flower_shop_single_post_breadcrumb',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_single_post_breadcrumb',array(
		'label' => esc_html__( 'Show / Hide Breadcrumb','florist-flower-shop' ),
		'section' => 'florist_flower_shop_single_blog_settings'
    )));

     // Single Posts Category
  	$wp_customize->add_setting( 'florist_flower_shop_single_post_category',array(
		'default' => true,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
  	$wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_single_post_category',array(
		'label' => esc_html__( 'Show / Hide Category','florist-flower-shop' ),
		'section' => 'florist_flower_shop_single_blog_settings'
    )));

	$wp_customize->add_setting( 'florist_flower_shop_toggle_tags',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
	));
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_toggle_tags', array(
		'label' => esc_html__( 'Show / Hide Tags','florist-flower-shop' ),
		'section' => 'florist_flower_shop_single_blog_settings'
    )));

	$wp_customize->add_setting( 'florist_flower_shop_single_blog_post_navigation_show_hide',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
	));
	$wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_single_blog_post_navigation_show_hide', array(
		  'label' => esc_html__( 'Show / Hide Post Navigation','florist-flower-shop' ),
		  'section' => 'florist_flower_shop_single_blog_settings'
	)));

	//navigation text
	$wp_customize->add_setting('florist_flower_shop_single_blog_prev_navigation_text',array(
		'default'=> 'PREVIOUS',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_single_blog_prev_navigation_text',array(
		'label'	=> __('Post Navigation Text','florist-flower-shop'),
		'input_attrs' => array(
    'placeholder' => __( 'PREVIOUS', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_single_blog_next_navigation_text',array(
		'default'=> 'NEXT',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_single_blog_next_navigation_text',array(
		'label'	=> __('Post Navigation Text','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( 'NEXT', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'florist_flower_shop_singlepost_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'florist_flower_shop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'florist_flower_shop_singlepost_image_box_shadow', array(
		'label'       => esc_html__( 'Single post Image Box Shadow','florist-flower-shop' ),
		'section'     => 'florist_flower_shop_single_blog_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('florist_flower_shop_single_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_single_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','florist-flower-shop'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','florist-flower-shop'),
		'section'=> 'florist_flower_shop_single_blog_settings',
		'type'=> 'text'
	));

    $wp_customize->add_setting('florist_flower_shop_single_blog_comment_title',array(
		'default'=> 'Leave a Reply',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('florist_flower_shop_single_blog_comment_title',array(
		'label'	=> __('Add Comment Title','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( 'Leave a Reply', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_single_blog_comment_button_text',array(
		'default'=> 'Post Comment',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('florist_flower_shop_single_blog_comment_button_text',array(
		'label'	=> __('Add Comment Button Text','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( 'Post Comment', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_single_blog_comment_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_single_blog_comment_width',array(
		'label'	=> __('Comment Form Width','florist-flower-shop'),
		'description'	=> __('Enter a value in %. Example:50%','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '100%', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_single_blog_settings',
		'type'=> 'text'
	));

	// Grid layout setting
	$wp_customize->add_section( 'florist_flower_shop_grid_layout_settings', array(
		'title' => __( 'Grid Layout Settings', 'florist-flower-shop' ),
		'panel' => 'florist_flower_shop_blog_post_parent_panel',
	));

  	$wp_customize->add_setting('florist_flower_shop_grid_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
        $wp_customize,'florist_flower_shop_grid_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','florist-flower-shop'),
		'transport' => 'refresh',
		'section'	=> 'florist_flower_shop_grid_layout_settings',
		'setting'	=> 'florist_flower_shop_grid_postdate_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'florist_flower_shop_grid_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_grid_postdate',array(
        'label' => esc_html__( 'Show / Hide Post Date','florist-flower-shop' ),
        'section' => 'florist_flower_shop_grid_layout_settings'
    )));

	$wp_customize->add_setting('florist_flower_shop_grid_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
        $wp_customize,'florist_flower_shop_grid_author_icon',array(
		'label'	=> __('Add Author Icon','florist-flower-shop'),
		'transport' => 'refresh',
		'section'	=> 'florist_flower_shop_grid_layout_settings',
		'setting'	=> 'florist_flower_shop_grid_author_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'florist_flower_shop_grid_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_grid_author',array(
		'label' => esc_html__( 'Show / Hide Author','florist-flower-shop' ),
		'section' => 'florist_flower_shop_grid_layout_settings'
    )));

   	$wp_customize->add_setting('florist_flower_shop_grid_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
        $wp_customize,'florist_flower_shop_grid_comments_icon',array(
		'label'	=> __('Add Comments Icon','florist-flower-shop'),
		'transport' => 'refresh',
		'section'	=> 'florist_flower_shop_grid_layout_settings',
		'setting'	=> 'florist_flower_shop_grid_comments_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'florist_flower_shop_grid_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_grid_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','florist-flower-shop' ),
		'section' => 'florist_flower_shop_grid_layout_settings'
    )));

    $wp_customize->add_setting( 'florist_flower_shop_grid_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
	));
  	$wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_grid_image_hide_show', array(
		'label' => esc_html__( 'Show / Hide Featured Image','florist-flower-shop' ),
		'section' => 'florist_flower_shop_grid_layout_settings'
  	)));

	$wp_customize->add_setting('florist_flower_shop_grid_button_text',array(
		'default'=> esc_html__('Read More','florist-flower-shop'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_grid_button_text',array(
		'label'	=> esc_html__('Add Button Text','florist-flower-shop'),
		'input_attrs' => array(
        'placeholder' => esc_html__( 'Read More', 'florist-flower-shop' ),
      ),
		'section'=> 'florist_flower_shop_grid_layout_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_grid_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_grid_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '[...]', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_grid_layout_settings',
		'type'=> 'text'
	));

    $wp_customize->add_setting('florist_flower_shop_grid_excerpt_settings',array(
        'default' => 'Excerpt',
        'transport' => 'refresh',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_grid_excerpt_settings',array(
        'type' => 'select',
        'label' => esc_html__('Grid Post Content','florist-flower-shop'),
        'section' => 'florist_flower_shop_grid_layout_settings',
        'choices' => array(
        	'Content' => esc_html__('Content','florist-flower-shop'),
            'Excerpt' => esc_html__('Excerpt','florist-flower-shop'),
            'No Content' => esc_html__('No Content','florist-flower-shop')
        ),
	) );

 	$wp_customize->add_setting('florist_flower_shop_grid_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_grid_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','florist-flower-shop'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','florist-flower-shop'),
		'section'=> 'florist_flower_shop_grid_layout_settings',
		'type'=> 'text'
	));

  	$wp_customize->add_setting('florist_flower_shop_display_grid_posts_settings',array(
	    'default' => 'Into Blocks',
	    'transport' => 'refresh',
	    'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_display_grid_posts_settings',array(
	    'type' => 'select',
	    'label' => __('Display Grid Posts','florist-flower-shop'),
	    'section' => 'florist_flower_shop_grid_layout_settings',
	    'choices' => array(
    		'Into Blocks' => __('Into Blocks','florist-flower-shop'),
	      	'Without Blocks' => __('Without Blocks','florist-flower-shop')
      	),
	) );

	$wp_customize->add_setting( 'florist_flower_shop_grid_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'florist_flower_shop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'florist_flower_shop_grid_featured_image_border_radius', array(
		'label'       => esc_html__( 'Grid Featured Image Border Radius','florist-flower-shop' ),
		'section'     => 'florist_flower_shop_grid_layout_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'florist_flower_shop_grid_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'florist_flower_shop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'florist_flower_shop_grid_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Grid Featured Image Box Shadow','florist-flower-shop' ),
		'section'     => 'florist_flower_shop_grid_layout_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Other Settings
	$wp_customize->add_panel( $florist_flower_shop_parent_panel );

	$OtherParentPanel = new Florist_Flower_Shop_WP_Customize_Panel( $wp_customize, 'florist_flower_shop_other_parent_panel', array(
		'title' => esc_html__( 'Other Settings', 'florist-flower-shop' ),
		'panel' => 'florist_flower_shop_panel_id',
		'priority' => 20,
	));

	$wp_customize->add_panel( $OtherParentPanel );

	// Layout
	$wp_customize->add_section( 'florist_flower_shop_left_right', array(
    	'title' => esc_html__( 'General Settings', 'florist-flower-shop' ),
		'panel' => 'florist_flower_shop_other_parent_panel'
	) );

	$wp_customize->add_setting('florist_flower_shop_width_option',array(
        'default' => 'Full Width',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Image_Radio_Control($wp_customize, 'florist_flower_shop_width_option', array(
        'type' => 'select',
        'label' => esc_html__('Width Layouts','florist-flower-shop'),
        'description' => esc_html__('Here you can change the width layout of Website.','florist-flower-shop'),
        'section' => 'florist_flower_shop_left_right',
        'choices' => array(
            'Full Width' => esc_url(get_template_directory_uri()).'/assets/images/full-width.png',
            'Wide Width' => esc_url(get_template_directory_uri()).'/assets/images/wide-width.png',
            'Boxed' => esc_url(get_template_directory_uri()).'/assets/images/boxed-width.png',
    ))));

	$wp_customize->add_setting('florist_flower_shop_page_layout',array(
        'default' => 'One Column',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_page_layout',array(
        'type' => 'select',
        'label' => esc_html__('Page Sidebar Layout','florist-flower-shop'),
        'description' => esc_html__('Here you can change the sidebar layout for pages. ','florist-flower-shop'),
        'section' => 'florist_flower_shop_left_right',
        'choices' => array(
            'Left Sidebar' => esc_html__('Left Sidebar','florist-flower-shop'),
            'Right Sidebar' => esc_html__('Right Sidebar','florist-flower-shop'),
            'One Column' => esc_html__('One Column','florist-flower-shop')
        ),
	) );

    $wp_customize->add_setting( 'florist_flower_shop_single_page_breadcrumb',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_single_page_breadcrumb',array(
		'label' => esc_html__( 'Show / Hide Page Breadcrumb','florist-flower-shop' ),
		'section' => 'florist_flower_shop_left_right'
    )));

    //Wow Animation
	$wp_customize->add_setting( 'florist_flower_shop_animation',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ));
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_animation',array(
        'label' => esc_html__( 'Show / Hide Animations','florist-flower-shop' ),
        'description' => __('Here you can disable overall site animation effect','florist-flower-shop'),
        'section' => 'florist_flower_shop_left_right'
    )));


    //Pre-Loader
	$wp_customize->add_setting( 'florist_flower_shop_loader_enable',array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_loader_enable',array(
        'label' => esc_html__( 'Show / Hide Pre-Loader','florist-flower-shop' ),
        'section' => 'florist_flower_shop_left_right'
    )));

	$wp_customize->add_setting('florist_flower_shop_preloader_bg_color', array(
		'default'           => '#9a45ad',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'florist_flower_shop_preloader_bg_color', array(
		'label'    => __('Pre-Loader Background Color', 'florist-flower-shop'),
		'section'  => 'florist_flower_shop_left_right',
	)));

	$wp_customize->add_setting('florist_flower_shop_preloader_border_color', array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'florist_flower_shop_preloader_border_color', array(
		'label'    => __('Pre-Loader Border Color', 'florist-flower-shop'),
		'section'  => 'florist_flower_shop_left_right',
	)));

	$wp_customize->add_setting('florist_flower_shop_preloader_bg_img',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'florist_flower_shop_preloader_bg_img',array(
        'label' => __('Preloader Background Image','florist-flower-shop'),
        'section' => 'florist_flower_shop_left_right'
	)));

	$wp_customize->add_setting('florist_flower_shop_bradcrumbs_alignment',array(
        'default' => 'Left',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_bradcrumbs_alignment',array(
        'type' => 'select',
        'label' => __('Bradcrumbs Alignment','florist-flower-shop'),
        'section' => 'florist_flower_shop_left_right',
        'choices' => array(
            'Left' => __('Left','florist-flower-shop'),
            'Right' => __('Right','florist-flower-shop'),
            'Center' => __('Center','florist-flower-shop'),
        ),
	) );

    //404 Page Setting
	$wp_customize->add_section('florist_flower_shop_404_page',array(
		'title'	=> __('404 Page Settings','florist-flower-shop'),
		'panel' => 'florist_flower_shop_other_parent_panel',
	));

	$wp_customize->add_setting('florist_flower_shop_404_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('florist_flower_shop_404_page_title',array(
		'label'	=> __('Add Title','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '404 Not Found', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_404_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('florist_flower_shop_404_page_content',array(
		'label'	=> __('Add Text','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( 'Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_404_page_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_404_page_button_text',array(
		'label'	=> __('Add Button Text','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( 'GO BACK', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_404_page',
		'type'=> 'text'
	));

	//No Result Page Setting
	$wp_customize->add_section('florist_flower_shop_no_results_page',array(
		'title'	=> __('No Results Page Settings','florist-flower-shop'),
		'panel' => 'florist_flower_shop_other_parent_panel',
	));

	$wp_customize->add_setting('florist_flower_shop_no_results_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('florist_flower_shop_no_results_page_title',array(
		'label'	=> __('Add Title','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( 'Nothing Found', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_no_results_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_no_results_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('florist_flower_shop_no_results_page_content',array(
		'label'	=> __('Add Text','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_no_results_page',
		'type'=> 'text'
	));

	//Social Icon Setting
	$wp_customize->add_section('florist_flower_shop_social_icon_settings',array(
		'title'	=> __('Social Icons Settings','florist-flower-shop'),
		'panel' => 'florist_flower_shop_other_parent_panel',
	));

	$wp_customize->add_setting('florist_flower_shop_social_icon_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_social_icon_font_size',array(
		'label'	=> __('Icon Font Size','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_social_icon_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_social_icon_padding',array(
		'label'	=> __('Icon Padding','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_social_icon_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_social_icon_width',array(
		'label'	=> __('Icon Width','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
    'placeholder' => __( '10px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_social_icon_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_social_icon_height',array(
		'label'	=> __('Icon Height','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_social_icon_settings',
		'type'=> 'text'
	));

	//Responsive Media Settings
	$wp_customize->add_section('florist_flower_shop_responsive_media',array(
		'title'	=> esc_html__('Responsive Media','florist-flower-shop'),
		'panel' => 'florist_flower_shop_other_parent_panel',
	));

	$wp_customize->add_setting( 'florist_flower_shop_resp_topbar_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
  	));  
  	$wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_resp_topbar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Topbar','florist-flower-shop' ),
      'section' => 'florist_flower_shop_responsive_media'
  	)));

    $wp_customize->add_setting( 'florist_flower_shop_resp_slider_hide_show',array(
      	'default' => 1,
     	'transport' => 'refresh',
      	'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ));
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_resp_slider_hide_show',array(
      	'label' => esc_html__( 'Show / Hide Slider','florist-flower-shop' ),
      	'section' => 'florist_flower_shop_responsive_media'
    )));

    $wp_customize->add_setting( 'florist_flower_shop_sidebar_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ));
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_sidebar_hide_show',array(
      	'label' => esc_html__( 'Show / Hide Sidebar','florist-flower-shop' ),
      	'section' => 'florist_flower_shop_responsive_media'
    )));

	$wp_customize->add_setting( 'florist_flower_shop_responsive_preloader_hide',array(
        'default' => false,
        'transport' => 'refresh',
        'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_responsive_preloader_hide',array(
        'label' => esc_html__( 'Show / Hide Preloader','florist-flower-shop' ),
        'section' => 'florist_flower_shop_responsive_media'
    )));

    $wp_customize->add_setting( 'florist_flower_shop_resp_scroll_top_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ));
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_resp_scroll_top_hide_show',array(
      	'label' => esc_html__( 'Show / Hide Scroll To Top','florist-flower-shop' ),
      	'section' => 'florist_flower_shop_responsive_media'
    )));

    $wp_customize->add_setting('florist_flower_shop_res_open_menu_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
        $wp_customize,'florist_flower_shop_res_open_menu_icon',array(
		'label'	=> __('Add Open Menu Icon','florist-flower-shop'),
		'transport' => 'refresh',
		'section'	=> 'florist_flower_shop_responsive_media',
		'setting'	=> 'florist_flower_shop_res_open_menu_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('florist_flower_shop_res_close_menu_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Florist_Flower_Shop_Fontawesome_Icon_Chooser(
        $wp_customize,'florist_flower_shop_res_close_menu_icon',array(
		'label'	=> __('Add Close Menu Icon','florist-flower-shop'),
		'transport' => 'refresh',
		'section'	=> 'florist_flower_shop_responsive_media',
		'setting'	=> 'florist_flower_shop_res_close_menu_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('florist_flower_shop_resp_menu_toggle_btn_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'florist_flower_shop_resp_menu_toggle_btn_bg_color', array(
		'label'    => __('Toggle Button Bg Color', 'florist-flower-shop'),
		'section'  => 'florist_flower_shop_responsive_media',
	)));

    //Woocommerce settings
	$wp_customize->add_section('florist_flower_shop_woocommerce_section', array(
		'title'    => __('WooCommerce Layout', 'florist-flower-shop'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

    //Shop Page Featured Image
	$wp_customize->add_setting( 'florist_flower_shop_shop_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'florist_flower_shop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'florist_flower_shop_shop_featured_image_border_radius', array(
		'label'       => esc_html__( 'Shop Page Featured Image Border Radius','florist-flower-shop' ),
		'section'     => 'florist_flower_shop_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'florist_flower_shop_shop_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'florist_flower_shop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'florist_flower_shop_shop_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Shop Page Featured Image Box Shadow','florist-flower-shop' ),
		'section'     => 'florist_flower_shop_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'florist_flower_shop_woocommerce_shop_page_sidebar', array( 'selector' => '.post-type-archive-product #sidebar',
		'render_callback' => 'florist_flower_shope_customize_partial_florist_flower_shop_woocommerce_shop_page_sidebar', ) );

    //Woocommerce Shop Page Sidebar
	$wp_customize->add_setting( 'florist_flower_shop_woocommerce_shop_page_sidebar',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_woocommerce_shop_page_sidebar',array(
		'label' => esc_html__( 'Show / Hide  Shop Page Sidebar','florist-flower-shop' ),
		'section' => 'florist_flower_shop_woocommerce_section'
    )));

    $wp_customize->add_setting('florist_flower_shop_shop_page_layout',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_shop_page_layout',array(
        'type' => 'select',
        'label' => __('Shop Page Sidebar Layout','florist-flower-shop'),
        'section' => 'florist_flower_shop_woocommerce_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','florist-flower-shop'),
            'Right Sidebar' => __('Right Sidebar','florist-flower-shop'),
        ),
	) );

     //Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'florist_flower_shop_woocommerce_single_product_page_sidebar', array( 'selector' => '.single-product #sidebar',
		'render_callback' => 'florist_flower_shop_customize_partial_florist_flower_shop_woocommerce_single_product_page_sidebar', ) );

    //Woocommerce Single Product page Sidebar
	$wp_customize->add_setting( 'florist_flower_shop_woocommerce_single_product_page_sidebar',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_woocommerce_single_product_page_sidebar',array(
		'label' => esc_html__( 'Show / Hide  Single Product Sidebar','florist-flower-shop' ),
		'section' => 'florist_flower_shop_woocommerce_section'
    )));

    $wp_customize->add_setting('florist_flower_shop_single_product_layout',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_single_product_layout',array(
        'type' => 'select',
        'label' => __('Single Product Sidebar Layout','florist-flower-shop'),
        'section' => 'florist_flower_shop_woocommerce_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','florist-flower-shop'),
            'Right Sidebar' => __('Right Sidebar','florist-flower-shop'),
        ),
	) );

	$wp_customize->add_setting('florist_flower_shop_products_btn_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_products_btn_padding_top_bottom',array(
		'label'	=> __('Products Button Padding Top Bottom','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_products_btn_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_products_btn_padding_left_right',array(
		'label'	=> __('Products Button Padding Left Right','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_woocommerce_section',
		'type'=> 'text'
	));

    //Products Sale Badge
	$wp_customize->add_setting('florist_flower_shop_woocommerce_sale_position',array(
        'default' => 'left',
        'sanitize_callback' => 'florist_flower_shop_sanitize_choices'
	));
	$wp_customize->add_control('florist_flower_shop_woocommerce_sale_position',array(
        'type' => 'select',
        'label' => __('Sale Badge Position','florist-flower-shop'),
        'section' => 'florist_flower_shop_woocommerce_section',
        'choices' => array(
            'left' => __('Left','florist-flower-shop'),
            'right' => __('Right','florist-flower-shop'),
        ),
	) );

	$wp_customize->add_setting('florist_flower_shop_woocommerce_sale_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_woocommerce_sale_padding_top_bottom',array(
		'label'	=> __('Sale Padding Top Bottom','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('florist_flower_shop_woocommerce_sale_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('florist_flower_shop_woocommerce_sale_padding_left_right',array(
		'label'	=> __('Sale Padding Left Right','florist-flower-shop'),
		'description'	=> __('Enter a value in pixels. Example:20px','florist-flower-shop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'florist-flower-shop' ),
        ),
		'section'=> 'florist_flower_shop_woocommerce_section',
		'type'=> 'text'
	));

  	// Related Product
    $wp_customize->add_setting( 'florist_flower_shop_related_product_show_hide',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'florist_flower_shop_switch_sanitization'
    ) );
    $wp_customize->add_control( new Florist_Flower_Shop_Toggle_Switch_Custom_Control( $wp_customize, 'florist_flower_shop_related_product_show_hide',array(
        'label' => esc_html__( 'Show / Hide  Related product','florist-flower-shop' ),
        'section' => 'florist_flower_shop_woocommerce_section'
    )));

    // Has to be at the top
	$wp_customize->register_panel_type( 'Florist_Flower_Shop_WP_Customize_Panel' );
	$wp_customize->register_section_type( 'Florist_Flower_Shop_WP_Customize_Section' );
}

add_action( 'customize_register', 'florist_flower_shop_customize_register' );

load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

if ( class_exists( 'WP_Customize_Panel' ) ) {
  	class Florist_Flower_Shop_WP_Customize_Panel extends WP_Customize_Panel {
	    public $panel;
	    public $type = 'florist_flower_shop_panel';
	    public function json() {
			$array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
			$array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
			$array['content'] = $this->get_content();
			$array['active'] = $this->active();
			$array['instanceNumber'] = $this->instance_number;
			return $array;
    	}
  	}
}

if ( class_exists( 'WP_Customize_Section' ) ) {
  	class Florist_Flower_Shop_WP_Customize_Section extends WP_Customize_Section {
	    public $section;
	    public $type = 'florist_flower_shop_section';
	    public function json() {
			$array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section', ) );
			$array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
			$array['content'] = $this->get_content();
			$array['active'] = $this->active();
			$array['instanceNumber'] = $this->instance_number;

			if ( $this->panel ) {
			$array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
			} else {
			$array['customizeAction'] = 'Customizing';
			}
			return $array;
    	}
  	}
}

// Enqueue our scripts and styles
function florist_flower_shop_customize_controls_scripts() {
	wp_enqueue_script( 'florist-flower-shop-customizer-controls', get_theme_file_uri( '/assets/js/customizer-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'florist_flower_shop_customize_controls_scripts' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Florist_Flower_Shop_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	*/
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'florist_flower_shop_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section( new Florist_Flower_Shop_Customize_Section_Pro( $manager,'florist_flower_shop_go_pro', array(
			'priority'   => 1,
			'title'    => esc_html__( 'Florist Flower Shop Pro', 'florist-flower-shop' ),
			'pro_text' => esc_html__( 'UPGRADE PRO', 'florist-flower-shop' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/products/flower-shop-wordpress-theme'),
		) )	);

		// Register sections.
		$manager->add_section(new Florist_Flower_Shop_Customize_Section_Pro($manager,'florist_flower_shop_get_started_link',array(
			'priority'   => 1,
			'title'    => esc_html__( 'DOCUMENTATION', 'florist-flower-shop' ),
			'pro_text' => esc_html__( 'DOCS', 'florist-flower-shop' ),
			'pro_url'  => esc_url('https://preview.vwthemesdemo.com/docs/free-florist-flower-shop/'),
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'florist-flower-shop-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'florist-flower-shop-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Florist_Flower_Shop_Customize::get_instance();

<?php
/**
 * Advance Portfolio Theme Customizer
 *
 * @package advance-portfolio
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function advance_portfolio_customize_register($wp_customize) {

	//add home page setting pannel
	$wp_customize->add_panel('advance_portfolio_panel_id', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Theme Settings', 'advance-portfolio'),
		'description'    => __('Description of what this panel does.', 'advance-portfolio'),
	));

	// Add the Theme Color Option section.
	$wp_customize->add_section( 'advance_portfolio_theme_color_option', 
		array( 'panel' => 'advance_portfolio_panel_id', 'title' => esc_html__( 'Theme Color Option', 'advance-portfolio' ) )
	);

  	$wp_customize->add_setting( 'advance_portfolio_theme_color_first', array(
	    'default' => '#f54ea2',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'advance_portfolio_theme_color_first', array(
  		'label' => 'First Color Option',
  		'description' => __('One can change complete theme color on just one click.', 'advance-portfolio'),
	    'section' => 'advance_portfolio_theme_color_option',
	    'settings' => 'advance_portfolio_theme_color_first',
  	)));

  	$wp_customize->add_setting( 'advance_portfolio_theme_color_second', array(
	    'default' => '#ffdd65',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'advance_portfolio_theme_color_second', array(
  		'label' => 'Second Color Option',
  		'description' => __('One can change complete theme color on just one click.', 'advance-portfolio'),
	    'section' => 'advance_portfolio_theme_color_option',
	    'settings' => 'advance_portfolio_theme_color_second',
  	)));

  	$wp_customize->add_setting('advance_portfolio_background_skin_mode',array(
        'default' => __('Transparent Background','advance-portfolio'),
        'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control('advance_portfolio_background_skin_mode',array(
        'type' => 'select',
        'label' => __('Background Type','advance-portfolio'),
        'section' => 'background_image',
        'choices' => array(
            'With Background' => __('With Background','advance-portfolio'),
            'Transparent Background' => __('Transparent Background','advance-portfolio'),
        ),
	) );

	$font_array = array(
        '' => 'No Fonts',
        'Abril Fatface' => 'Abril Fatface', 
        'Acme' => 'Acme', 
        'Anton' => 'Anton',
        'Architects Daughter' =>'Architects Daughter', 
        'Arimo' => 'Arimo', 
        'Arsenal' => 'Arsenal', 
        'Arvo' => 'Arvo', 
        'Alegreya' => 'Alegreya',
        'Alfa Slab One' =>  'Alfa Slab One', 
        'Averia Serif Libre' =>  'Averia Serif Libre',
        'Bangers' => 'Bangers', 
        'Boogaloo' => 'Boogaloo',
        'Bad Script' => 'Bad Script', 
        'Bitter' =>  'Bitter', 
        'Bree Serif' => 'Bree Serif', 
        'BenchNine' => 'BenchNine',
        'Cabin' => 'Cabin', 
        'Cardo' => 'Cardo', 
        'Courgette' => 'Courgette', 
        'Cherry Swash' => 'Cherry Swash', 
        'Cormorant Garamond' => 'Cormorant Garamond', 
        'Crimson Text' => 'Crimson Text',
        'Cuprum' => 'Cuprum', 
        'Cookie' => 'Cookie', 
        'Chewy' => 'Chewy', 
        'Days One' => 'Days One',
        'Dosis' => 'Dosis', 
        'Droid Sans' => 'Droid Sans',
        'Economica' =>  'Economica',
        'Fredoka One' => 'Fredoka One', 
        'Fjalla One' => 'Fjalla One', 
        'Francois One' => 'Francois One', 
        'Frank Ruhl Libre' => 'Frank Ruhl Libre', 
        'Gloria Hallelujah' => 'Gloria Hallelujah',
        'Great Vibes' =>  'Great Vibes', 
        'Handlee' => 'Handlee',
        'Hammersmith One' =>'Hammersmith One', 
        'Inconsolata' => 'Inconsolata', 
        'Indie Flower' => 'Indie Flower', 
        'IM Fell English SC' => 'IM Fell English SC',
        'Julius Sans One' => 'Julius Sans One', 
        'Josefin Slab' => 'Josefin Slab', 
        'Josefin Sans' => 'Josefin Sans',
        'Kanit' => 'Kanit', 
        'Lobster' =>  'Lobster', 
        'Lato' => 'Lato', 
        'Lora' =>'Lora',
        'Libre Baskerville' =>  'Libre Baskerville', 
        'Lobster Two' => 'Lobster Two',
        'Merriweather' => 'Merriweather', 
        'Monda' => 'Monda', 
        'Montserrat' => 'Montserrat', 
        'Muli' => 'Muli', 
        'Marck Script' => 'Marck Script', 
        'Noto Serif' => 'Noto Serif', 
        'Open Sans' => 'Open Sans', 
        'Overpass' => 'Overpass', 
        'Overpass Mono' =>  'Overpass Mono', 
        'Oxygen' => 'Oxygen', 
        'Orbitron' => 'Orbitron',
        'Patua One' => 'Patua One', 
        'Pacifico' =>  'Pacifico',
        'Padauk' => 'Padauk',
        'Playball' =>  'Playball', 
        'Playfair Display' => 'Playfair Display',
        'PT Sans' => 'PT Sans', 
        'Philosopher' => 'Philosopher', 
        'Permanent Marker' => 'Permanent Marker', 
        'Poiret One' => 'Poiret One', 
        'Quicksand' => 'Quicksand', 
        'Quattrocento Sans' =>'Quattrocento Sans',
        'Raleway' => 'Raleway', 
        'Rubik' => 'Rubik', 
        'Rokkitt' => 'Rokkitt', 
        'Russo One' => 'Russo One', 
        'Righteous' => 'Righteous', 
        'Slabo' => 'Slabo', 
        'Source Sans Pro' => 'Source Sans Pro',
        'Shadows Into Light Two' => 'Shadows Into Light Two',
        'Shadows Into Light' => 'Shadows Into Light',
        'Sacramento' => 'Sacramento', 
        'Shrikhand' => 'Shrikhand',
        'Tangerine' => 'Tangerine', 
        'Ubuntu' => 'Ubuntu', 
        'VT323' => 'VT323', 
        'Varela Round' => 'Varela Round',
        'Vampiro One' => 'Vampiro One', 
        'Vollkorn' => 'Vollkorn', 
        'Volkhov' => 'Volkhov', 
        'Yanone Kaffeesatz' =>'Yanone Kaffeesatz', 
    );

	//Typography
	$wp_customize->add_section( 'advance_portfolio_typography', array(
    	'title'      => __( 'Typography', 'advance-portfolio' ),
		'priority'   => 30,
		'panel' => 'advance_portfolio_panel_id'
	) );
	
	// This is Paragraph Color picker setting
	$wp_customize->add_setting( 'advance_portfolio_paragraph_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'advance_portfolio_paragraph_color', array(
		'label' => __('Paragraph Color', 'advance-portfolio'),
		'section' => 'advance_portfolio_typography',
		'settings' => 'advance_portfolio_paragraph_color',
	)));

	//This is Paragraph FontFamily picker setting
	$wp_customize->add_setting('advance_portfolio_paragraph_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control(
	    'advance_portfolio_paragraph_font_family', array(
	    'section'  => 'advance_portfolio_typography',
	    'label'    => __( 'Paragraph Fonts','advance-portfolio'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	$wp_customize->add_setting('advance_portfolio_paragraph_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('advance_portfolio_paragraph_font_size',array(
		'label'	=> __('Paragraph Font Size','advance-portfolio'),
		'section'	=> 'advance_portfolio_typography',
		'setting'	=> 'advance_portfolio_paragraph_font_size',
		'type'	=> 'text'
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'advance_portfolio_atag_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'advance_portfolio_atag_color', array(
		'label' => __('"a" Tag Color', 'advance-portfolio'),
		'section' => 'advance_portfolio_typography',
		'settings' => 'advance_portfolio_atag_color',
	)));

	//This is "a" Tag FontFamily picker setting
	$wp_customize->add_setting('advance_portfolio_atag_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control(
	    'advance_portfolio_atag_font_family', array(
	    'section'  => 'advance_portfolio_typography',
	    'label'    => __( '"a" Tag Fonts','advance-portfolio'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'advance_portfolio_li_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'advance_portfolio_li_color', array(
		'label' => __('"li" Tag Color', 'advance-portfolio'),
		'section' => 'advance_portfolio_typography',
		'settings' => 'advance_portfolio_li_color',
	)));

	//This is "li" Tag FontFamily picker setting
	$wp_customize->add_setting('advance_portfolio_li_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control(
	    'advance_portfolio_li_font_family', array(
	    'section'  => 'advance_portfolio_typography',
	    'label'    => __( '"li" Tag Fonts','advance-portfolio'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	// This is H1 Color picker setting
	$wp_customize->add_setting( 'advance_portfolio_h1_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'advance_portfolio_h1_color', array(
		'label' => __('H1 Color', 'advance-portfolio'),
		'section' => 'advance_portfolio_typography',
		'settings' => 'advance_portfolio_h1_color',
	)));

	//This is H1 FontFamily picker setting
	$wp_customize->add_setting('advance_portfolio_h1_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control(
	    'advance_portfolio_h1_font_family', array(
	    'section'  => 'advance_portfolio_typography',
	    'label'    => __( 'H1 Fonts','advance-portfolio'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H1 FontSize setting
	$wp_customize->add_setting('advance_portfolio_h1_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('advance_portfolio_h1_font_size',array(
		'label'	=> __('H1 Font Size','advance-portfolio'),
		'section'	=> 'advance_portfolio_typography',
		'setting'	=> 'advance_portfolio_h1_font_size',
		'type'	=> 'text'
	));

	// This is H2 Color picker setting
	$wp_customize->add_setting( 'advance_portfolio_h2_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'advance_portfolio_h2_color', array(
		'label' => __('h2 Color', 'advance-portfolio'),
		'section' => 'advance_portfolio_typography',
		'settings' => 'advance_portfolio_h2_color',
	)));

	//This is H2 FontFamily picker setting
	$wp_customize->add_setting('advance_portfolio_h2_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control(
	    'advance_portfolio_h2_font_family', array(
	    'section'  => 'advance_portfolio_typography',
	    'label'    => __( 'h2 Fonts','advance-portfolio'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H2 FontSize setting
	$wp_customize->add_setting('advance_portfolio_h2_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('advance_portfolio_h2_font_size',array(
		'label'	=> __('h2 Font Size','advance-portfolio'),
		'section'	=> 'advance_portfolio_typography',
		'setting'	=> 'advance_portfolio_h2_font_size',
		'type'	=> 'text'
	));

	// This is H3 Color picker setting
	$wp_customize->add_setting( 'advance_portfolio_h3_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'advance_portfolio_h3_color', array(
		'label' => __('h3 Color', 'advance-portfolio'),
		'section' => 'advance_portfolio_typography',
		'settings' => 'advance_portfolio_h3_color',
	)));

	//This is H3 FontFamily picker setting
	$wp_customize->add_setting('advance_portfolio_h3_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control(
	    'advance_portfolio_h3_font_family', array(
	    'section'  => 'advance_portfolio_typography',
	    'label'    => __( 'h3 Fonts','advance-portfolio'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H3 FontSize setting
	$wp_customize->add_setting('advance_portfolio_h3_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('advance_portfolio_h3_font_size',array(
		'label'	=> __('h3 Font Size','advance-portfolio'),
		'section'	=> 'advance_portfolio_typography',
		'setting'	=> 'advance_portfolio_h3_font_size',
		'type'	=> 'text'
	));

	// This is H4 Color picker setting
	$wp_customize->add_setting( 'advance_portfolio_h4_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'advance_portfolio_h4_color', array(
		'label' => __('h4 Color', 'advance-portfolio'),
		'section' => 'advance_portfolio_typography',
		'settings' => 'advance_portfolio_h4_color',
	)));

	//This is H4 FontFamily picker setting
	$wp_customize->add_setting('advance_portfolio_h4_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control(
	    'advance_portfolio_h4_font_family', array(
	    'section'  => 'advance_portfolio_typography',
	    'label'    => __( 'h4 Fonts','advance-portfolio'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H4 FontSize setting
	$wp_customize->add_setting('advance_portfolio_h4_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('advance_portfolio_h4_font_size',array(
		'label'	=> __('h4 Font Size','advance-portfolio'),
		'section'	=> 'advance_portfolio_typography',
		'setting'	=> 'advance_portfolio_h4_font_size',
		'type'	=> 'text'
	));

	// This is H5 Color picker setting
	$wp_customize->add_setting( 'advance_portfolio_h5_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'advance_portfolio_h5_color', array(
		'label' => __('h5 Color', 'advance-portfolio'),
		'section' => 'advance_portfolio_typography',
		'settings' => 'advance_portfolio_h5_color',
	)));

	//This is H5 FontFamily picker setting
	$wp_customize->add_setting('advance_portfolio_h5_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control(
	    'advance_portfolio_h5_font_family', array(
	    'section'  => 'advance_portfolio_typography',
	    'label'    => __( 'h5 Fonts','advance-portfolio'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H5 FontSize setting
	$wp_customize->add_setting('advance_portfolio_h5_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('advance_portfolio_h5_font_size',array(
		'label'	=> __('h5 Font Size','advance-portfolio'),
		'section'	=> 'advance_portfolio_typography',
		'setting'	=> 'advance_portfolio_h5_font_size',
		'type'	=> 'text'
	));

	// This is H6 Color picker setting
	$wp_customize->add_setting( 'advance_portfolio_h6_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'advance_portfolio_h6_color', array(
		'label' => __('h6 Color', 'advance-portfolio'),
		'section' => 'advance_portfolio_typography',
		'settings' => 'advance_portfolio_h6_color',
	)));

	//This is H6 FontFamily picker setting
	$wp_customize->add_setting('advance_portfolio_h6_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control(
	    'advance_portfolio_h6_font_family', array(
	    'section'  => 'advance_portfolio_typography',
	    'label'    => __( 'h6 Fonts','advance-portfolio'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H6 FontSize setting
	$wp_customize->add_setting('advance_portfolio_h6_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('advance_portfolio_h6_font_size',array(
		'label'	=> __('h6 Font Size','advance-portfolio'),
		'section'	=> 'advance_portfolio_typography',
		'setting'	=> 'advance_portfolio_h6_font_size',
		'type'	=> 'text'
	));

	// woocommerce section
	$wp_customize->add_setting('advance_portfolio_show_related_products',array(
       'default' => true,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('advance_portfolio_show_related_products',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Related Product','advance-portfolio'),
       'section' => 'woocommerce_product_catalog',
    ));

	$wp_customize->add_setting('advance_portfolio_show_wooproducts_border',array(
       'default' => true,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('advance_portfolio_show_wooproducts_border',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Product Border','advance-portfolio'),
       'section' => 'woocommerce_product_catalog',
    ));

    $wp_customize->add_setting( 'advance_portfolio_wooproducts_per_columns' , array(
		'default'           => 3,
		'transport'         => 'refresh',
		'sanitize_callback' => 'advance_portfolio_sanitize_choices',
	) );
	$wp_customize->add_control( 'advance_portfolio_wooproducts_per_columns', array(
		'label'    => __( 'Display Product Per Columns', 'advance-portfolio' ),
		'section'  => 'woocommerce_product_catalog',
		'type'     => 'select',
		'choices'  => array(
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
		),
	)  );

	$wp_customize->add_setting('advance_portfolio_wooproducts_per_page',array(
		'default'	=> 9,
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('advance_portfolio_wooproducts_per_page',array(
		'label'	=> __('Display Product Per Page','advance-portfolio'),
		'section'	=> 'woocommerce_product_catalog',
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'advance_portfolio_top_bottom_wooproducts_padding',array(
		'default' => 10,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	));
	$wp_customize->add_control( 'advance_portfolio_top_bottom_wooproducts_padding',	array(
		'label' => esc_html__( 'Top Bottom Product Padding','advance-portfolio' ),
		'section' => 'woocommerce_product_catalog',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'advance_portfolio_left_right_wooproducts_padding',array(
		'default' => 10,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	));
	$wp_customize->add_control( 'advance_portfolio_left_right_wooproducts_padding',	array(
		'label' => esc_html__( 'Right Left Product Padding','advance-portfolio' ),
		'section' => 'woocommerce_product_catalog',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'advance_portfolio_wooproducts_border_radius',array(
		'default' => 0,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	));
	$wp_customize->add_control('advance_portfolio_wooproducts_border_radius',array(
		'label' => esc_html__( 'Product Border Radius','advance-portfolio' ),
		'section' => 'woocommerce_product_catalog',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'range'
	));

	$wp_customize->add_setting( 'advance_portfolio_wooproducts_box_shadow',array(
		'default' => 0,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	));
	$wp_customize->add_control('advance_portfolio_wooproducts_box_shadow',array(
		'label' => esc_html__( 'Product Box Shadow','advance-portfolio' ),
		'section' => 'woocommerce_product_catalog',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'range'
	));

	$wp_customize->add_section('advance_portfolio_product_button_section', array(
		'title'    => __('Product Button Settings', 'advance-portfolio'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

	$wp_customize->add_setting( 'advance_portfolio_top_bottom_product_button_padding',array(
		'default' => 10,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	));
	$wp_customize->add_control('advance_portfolio_top_bottom_product_button_padding',	array(
		'label' => esc_html__( 'Product Button Top Bottom Padding','advance-portfolio' ),
		'section' => 'advance_portfolio_product_button_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number',
	));

	$wp_customize->add_setting( 'advance_portfolio_left_right_product_button_padding',array(
		'default' => 16,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	));
	$wp_customize->add_control('advance_portfolio_left_right_product_button_padding',array(
		'label' => esc_html__( 'Product Button Right Left Padding','advance-portfolio' ),
		'section' => 'advance_portfolio_product_button_section',
		'type'		=> 'number',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting( 'advance_portfolio_product_button_border_radius',array(
		'default' => 0,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	));
	$wp_customize->add_control('advance_portfolio_product_button_border_radius',array(
		'label' => esc_html__( 'Product Button Border Radius','advance-portfolio' ),
		'section' => 'advance_portfolio_product_button_section',
		'type'		=> 'range',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	//Layouts
	$wp_customize->add_section('advance_portfolio_left_right', array(
		'title'    => __('Layout Settings', 'advance-portfolio'),
		'priority' => 30,
		'panel'    => 'advance_portfolio_panel_id',
	));

	$wp_customize->add_setting('advance_portfolio_preloader_option',array(
       'default' => true,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('advance_portfolio_preloader_option',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Preloader','advance-portfolio'),
       'section' => 'advance_portfolio_left_right'
    ));

	$wp_customize->add_setting( 'advance_portfolio_sticky_header',array(
      	'sanitize_callback'	=> 'sanitize_text_field'
    ) );
    $wp_customize->add_control('advance_portfolio_sticky_header',array(
    	'type' => 'checkbox',
        'label' => __( 'Sticky Header','advance-portfolio' ),
        'section' => 'advance_portfolio_left_right'
    ));

    $wp_customize->add_setting( 'advance_portfolio_shop_page_sidebar',array(
		'default' => true,
		'sanitize_callback'	=> 'sanitize_text_field'
    ) );
    $wp_customize->add_control('advance_portfolio_shop_page_sidebar',array(
    	'type' => 'checkbox',
       	'label' => __('Show / Hide Woocommerce Page Sidebar','advance-portfolio'),
		'section' => 'advance_portfolio_left_right'
    ));

	$wp_customize->add_setting( 'advance_portfolio_wocommerce_single_page_sidebar',array(
		'default' => true,
		'sanitize_callback'	=> 'sanitize_text_field'
    ) );
    $wp_customize->add_control('advance_portfolio_wocommerce_single_page_sidebar',array(
    	'type' => 'checkbox',
       	'label' => __('Show / Hide Single Product Page Sidebar','advance-portfolio'),
		'section' => 'advance_portfolio_left_right'
    ));

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('advance_portfolio_layout_options', array(
			'default'           => __('Right Sidebar', 'advance-portfolio'),
			'sanitize_callback' => 'advance_portfolio_sanitize_choices',
	)	);
	$wp_customize->add_control('advance_portfolio_layout_options', array(
		'type'           => 'radio',
		'label'          => __('Sidebar Layouts', 'advance-portfolio'),
		'section'        => 'advance_portfolio_left_right',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'advance-portfolio'),
			'Right Sidebar' => __('Right Sidebar', 'advance-portfolio'),
			'One Column'    => __('One Column', 'advance-portfolio'),
			'Three Columns' => __('Three Columns', 'advance-portfolio'),
			'Four Columns'  => __('Four Columns', 'advance-portfolio'),
			'Grid Layout'   => __('Grid Layout', 'advance-portfolio')
		),
	));

	$wp_customize->add_setting('advance_portfolio_single_page_sidebar_layout', array(
		'default'           => __('One Column', 'advance-portfolio'),
		'sanitize_callback' => 'advance_portfolio_sanitize_choices',
	));
	$wp_customize->add_control('advance_portfolio_single_page_sidebar_layout',array(
		'type'           => 'radio',
		'label'          => __('Single Page Layouts', 'advance-portfolio'),
		'section'        => 'advance_portfolio_left_right',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'advance-portfolio'),
			'Right Sidebar' => __('Right Sidebar', 'advance-portfolio'),
			'One Column'    => __('One Column', 'advance-portfolio'),
		),
	));

	$wp_customize->add_setting('advance_portfolio_single_post_sidebar_layout', array(
		'default'           => __('Right Sidebar', 'advance-portfolio'),
		'sanitize_callback' => 'advance_portfolio_sanitize_choices',
	));
	$wp_customize->add_control('advance_portfolio_single_post_sidebar_layout',array(
		'type'           => 'radio',
		'label'          => __('Single Post Layouts', 'advance-portfolio'),
		'section'        => 'advance_portfolio_left_right',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'advance-portfolio'),
			'Right Sidebar' => __('Right Sidebar', 'advance-portfolio'),
			'One Column'    => __('One Column', 'advance-portfolio'),
		),
	));

	$wp_customize->add_setting('advance_portfolio_theme_options',array(
        'default' => __('Default','advance-portfolio'),
        'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control('advance_portfolio_theme_options',array(
        'type' => 'radio',
        'label' => __('Container Box','advance-portfolio'),
        'description' => __('Here you can change the Width layout. ','advance-portfolio'),
        'section' => 'advance_portfolio_left_right',
        'choices' => array(
            'Default' => __('Default','advance-portfolio'),
            'Container' => __('Container','advance-portfolio'),
            'Box Container' => __('Box Container','advance-portfolio'),
        ),
	) );

	// Button
	$wp_customize->add_section( 'advance_portfolio_theme_button', array(
		'title' => __('Button Option','advance-portfolio'),
		'panel' => 'advance_portfolio_panel_id',
	));

	$wp_customize->add_setting('advance_portfolio_button_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('advance_portfolio_button_padding_top_bottom',array(
		'label'	=> __('Top and Bottom Padding','advance-portfolio'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'advance_portfolio_theme_button',
		'type'=> 'number'
	));

	$wp_customize->add_setting('advance_portfolio_button_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('advance_portfolio_button_padding_left_right',array(
		'label'	=> __('Left and Right Padding','advance-portfolio'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'advance_portfolio_theme_button',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'advance_portfolio_button_border_radius', array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'advance_portfolio_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','advance-portfolio' ),
		'section'     => 'advance_portfolio_theme_button',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//social icons
	$wp_customize->add_section('advance_portfolio_topbar_header', array(
		'title'       => __('Social Icon link', 'advance-portfolio'),
		'description' => __('Add Top Bar Content here', 'advance-portfolio'),
		'priority'    => null,
		'panel'       => 'advance_portfolio_panel_id',
	));

	$wp_customize->add_setting('advance_portfolio_facebook_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('advance_portfolio_facebook_url', array(
		'label'   => __('Add Facebook link', 'advance-portfolio'),
		'section' => 'advance_portfolio_topbar_header',
		'setting' => 'advance_portfolio_facebook_url',
		'type'    => 'url',
	));

	$wp_customize->add_setting('advance_portfolio_twitter_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('advance_portfolio_twitter_url', array(
		'label'   => __('Add Twitter link', 'advance-portfolio'),
		'section' => 'advance_portfolio_topbar_header',
		'setting' => 'advance_portfolio_twitter_url',
		'type'    => 'url',
	));

	$wp_customize->add_setting('advance_portfolio_linkedin_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('advance_portfolio_linkedin_url', array(
		'label'   => __('Add Linkedin link', 'advance-portfolio'),
		'section' => 'advance_portfolio_topbar_header',
		'setting' => 'advance_portfolio_linkedin_url',
		'type'    => 'url',
	));

	$wp_customize->add_setting('advance_portfolio_insta_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('advance_portfolio_insta_url', array(
		'label'   => __('Add Instagram link', 'advance-portfolio'),
		'section' => 'advance_portfolio_topbar_header',
		'setting' => 'advance_portfolio_insta_url',
		'type'    => 'url',
	));

	$wp_customize->add_setting('advance_portfolio_youtube_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('advance_portfolio_youtube_url', array(
		'label'   => __('Add Youtube link', 'advance-portfolio'),
		'section' => 'advance_portfolio_topbar_header',
		'setting' => 'advance_portfolio_youtube_url',
		'type'    => 'url',
	));

	$wp_customize->add_setting('advance_portfolio_behance_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('advance_portfolio_behance_url', array(
		'label'   => __('Add Behance link', 'advance-portfolio'),
		'section' => 'advance_portfolio_topbar_header',
		'setting' => 'advance_portfolio_behance_url',
		'type'    => 'url',
	));

	//Banner
	$wp_customize->add_section('advance_portfolio_banner', array(
		'title'       => __('Banner', 'advance-portfolio'),
		'description' => __('This section will appear below the social icons section', 'advance-portfolio'),
		'panel'       => 'advance_portfolio_panel_id',
	));

	$wp_customize->add_setting('advance_portfolio_page_settings', array(
		'default'           => '',
		'sanitize_callback' => 'advance_portfolio_sanitize_dropdown_pages',
	));
	$wp_customize->add_control('advance_portfolio_page_settings', array(
		'label'       => __('Select Banner Page', 'advance-portfolio'),
		'description' => __('Size of image should be 1600x800', 'advance-portfolio'),
		'section'     => 'advance_portfolio_banner',
		'type'        => 'dropdown-pages',
	));

	//content layout
    $wp_customize->add_setting('advance_portfolio_banner_content_alignment',array(
    'default' => __('Left','advance-portfolio'),
        'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control('advance_portfolio_banner_content_alignment',array(
        'type' => 'radio',
        'label' => __('Banner Content Alignment','advance-portfolio'),
        'section' => 'advance_portfolio_banner',
        'choices' => array(
            'Center' => __('Center','advance-portfolio'),
            'Left' => __('Left','advance-portfolio'),
            'Right' => __('Right','advance-portfolio'),
        ),
	) );

    //Slider excerpt
	$wp_customize->add_setting( 'advance_portfolio_banner_excerpt_length', array(
		'default'              => 20,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'advance_portfolio_banner_excerpt_length', array(
		'label'       => esc_html__( 'Banner Excerpt length','advance-portfolio' ),
		'section'     => 'advance_portfolio_banner',
		'type'        => 'number',
		'settings'    => 'advance_portfolio_banner_excerpt_length',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Opacity
	$wp_customize->add_setting('advance_portfolio_banner_image_opacity',array(
      'default'              => 0.6,
      'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control( 'advance_portfolio_banner_image_opacity', array(
	'label'       => esc_html__( 'Banner Image Opacity','advance-portfolio' ),
	'section'     => 'advance_portfolio_banner',
	'type'        => 'select',
	'settings'    => 'advance_portfolio_banner_image_opacity',
	'choices' => array(
		'0' =>  esc_attr('0','advance-portfolio'),
		'0.1' =>  esc_attr('0.1','advance-portfolio'),
		'0.2' =>  esc_attr('0.2','advance-portfolio'),
		'0.3' =>  esc_attr('0.3','advance-portfolio'),
		'0.4' =>  esc_attr('0.4','advance-portfolio'),
		'0.5' =>  esc_attr('0.5','advance-portfolio'),
		'0.6' =>  esc_attr('0.6','advance-portfolio'),
		'0.7' =>  esc_attr('0.7','advance-portfolio'),
		'0.8' =>  esc_attr('0.8','advance-portfolio'),
		'0.9' =>  esc_attr('0.9','advance-portfolio')
	),
	));

	//AWESOME PORTFOLIO
	$wp_customize->add_section('advance_portfolio_page_awesome', array(
		'title'       => __('Awesome Portfolio', 'advance-portfolio'),
		'description' => __('This section will appear below the banner.', 'advance-portfolio'),
		'panel'       => 'advance_portfolio_panel_id',
	));

	$wp_customize->add_setting('advance_portfolio_title', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('advance_portfolio_title', array(
		'label'   => __('Section Title', 'advance-portfolio'),
		'section' => 'advance_portfolio_page_awesome',
		'setting' => 'advance_portfolio_title',
		'type'    => 'text',
	));

	$args = array('numberposts' => -1);
	$post_list = get_posts($args);
	$i = 0;
	$pst[]='Select';  
	foreach($post_list as $post){
		$pst[$post->post_title] = $post->post_title;
	}

	$wp_customize->add_setting('advance_portfolio_awesome_setting', array(
		'sanitize_callback' => 'advance_portfolio_sanitize_choices',
	));
	$wp_customize->add_control('advance_portfolio_awesome_setting', array(
		'type'        => 'select',
		'choices'     => $pst,
		'label'       => __('Select post', 'advance-portfolio'),
		'description' => __('Size of image should be 270x270', 'advance-portfolio'),
		'section'     => 'advance_portfolio_page_awesome',
	));

	$args = array('numberposts' => -1);
	$post_list = get_posts($args);
	$i = 0;
	$pst1[]='Select';  
	foreach($post_list as $post){
		$pst1[$post->post_title] = $post->post_title;
	}

	$wp_customize->add_setting('advance_portfolio_awesome_setting1', array(
		'sanitize_callback' => 'advance_portfolio_sanitize_choices',
	));
	$wp_customize->add_control('advance_portfolio_awesome_setting1', array(
		'type'        => 'select',
		'choices'     => $pst1,
		'label'       => __('Select post', 'advance-portfolio'),
		'description' => __('Size of image should be 270x270', 'advance-portfolio'),
		'section'     => 'advance_portfolio_page_awesome',
	));

	$args = array('numberposts' => -1);
	$post_list = get_posts($args);
	$i = 0;
	$pst2[]='Select';  
	foreach($post_list as $post){
		$pst2[$post->post_title] = $post->post_title;
	}

	$wp_customize->add_setting('advance_portfolio_awesome_setting2', array(
		'sanitize_callback' => 'advance_portfolio_sanitize_choices',
	));
	$wp_customize->add_control('advance_portfolio_awesome_setting2', array(
		'type'        => 'select',
		'choices'     => $pst2,
		'label'       => __('Select post', 'advance-portfolio'),
		'description' => __('Size of image should be 570x270', 'advance-portfolio'),
		'section'     => 'advance_portfolio_page_awesome',
	));

	$args = array('numberposts' => -1);
	$post_list = get_posts($args);
	$i = 0;
	$pst3[]='Select';  
	foreach($post_list as $post){
		$pst3[$post->post_title] = $post->post_title;
	}

	$wp_customize->add_setting('advance_portfolio_awesome_setting3', array(
		'sanitize_callback' => 'advance_portfolio_sanitize_choices',
	));
	$wp_customize->add_control('advance_portfolio_awesome_setting3', array(
		'type'        => 'select',
		'choices'     => $pst3,
		'label'       => __('Select post', 'advance-portfolio'),
		'description' => __('Size of image should be 570x570', 'advance-portfolio'),
		'section'     => 'advance_portfolio_page_awesome',
	));

	//404 Page Setting
	$wp_customize->add_section('advance_portfolio_404_page_setting',array(
		'title'	=> __('404 Page','advance-portfolio'),
		'panel' => 'advance_portfolio_panel_id',
	));	

	$wp_customize->add_setting('advance_portfolio_title_404_page',array(
		'default'=> __('404 Not Found','advance-portfolio'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('advance_portfolio_title_404_page',array(
		'label'	=> __('404 Page Title','advance-portfolio'),
		'section'=> 'advance_portfolio_404_page_setting',
		'type'=> 'text'
	));

	$wp_customize->add_setting('advance_portfolio_content_404_page',array(
		'default'=> __('Looks like you have taken a wrong turn&hellip. Dont worry&hellip it happens to the best of us.','advance-portfolio'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('advance_portfolio_content_404_page',array(
		'label'	=> __('404 Page Content','advance-portfolio'),
		'section'=> 'advance_portfolio_404_page_setting',
		'type'=> 'text'
	));

	$wp_customize->add_setting('advance_portfolio_button_404_page',array(
		'default'=> __('Back to Home Page','advance-portfolio'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('advance_portfolio_button_404_page',array(
		'label'	=> __('404 Page Button','advance-portfolio'),
		'section'=> 'advance_portfolio_404_page_setting',
		'type'=> 'text'
	));

	//Responsive Media Settings
	$wp_customize->add_section('advance_portfolio_responsive_setting',array(
		'title'	=> __('Responsive Settings','advance-portfolio'),
		'panel' => 'advance_portfolio_panel_id',
	));

    $wp_customize->add_setting('advance_portfolio_responsive_sticky_header',array(
       'default' => true,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('advance_portfolio_responsive_sticky_header',array(
       'type' => 'checkbox',
       'label' => __('Sticky Header','advance-portfolio'),
       'section' => 'advance_portfolio_responsive_setting'
    ));

    $wp_customize->add_setting('advance_portfolio_responsive_slider',array(
       'default' => true,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('advance_portfolio_responsive_slider',array(
       'type' => 'checkbox',
       'label' => __('Slider','advance-portfolio'),
       'section' => 'advance_portfolio_responsive_setting'
    ));

    $wp_customize->add_setting('advance_portfolio_responsive_metabox',array(
       'default' => true,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('advance_portfolio_responsive_metabox',array(
       'type' => 'checkbox',
       'label' => __('Metabox','advance-portfolio'),
       'section' => 'advance_portfolio_responsive_setting'
    ));

    $wp_customize->add_setting('advance_portfolio_responsive_sidebar',array(
       'default' => true,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('advance_portfolio_responsive_sidebar',array(
       'type' => 'checkbox',
       'label' => __('Sidebar','advance-portfolio'),
       'section' => 'advance_portfolio_responsive_setting'
    ));

	//Blog Post
	$wp_customize->add_section('advance_portfolio_blog_post',array(
		'title'	=> __('Blog Page Settings','advance-portfolio'),
		'panel' => 'advance_portfolio_panel_id',
	));	

	$wp_customize->add_setting('advance_portfolio_date_hide',array(
       'default' => false,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('advance_portfolio_date_hide',array(
       'type' => 'checkbox',
       'label' => __('Post Date','advance-portfolio'),
       'section' => 'advance_portfolio_blog_post'
    ));

    $wp_customize->add_setting('advance_portfolio_comment_hide',array(
       'default' => false,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('advance_portfolio_comment_hide',array(
       'type' => 'checkbox',
       'label' => __('Comments','advance-portfolio'),
       'section' => 'advance_portfolio_blog_post'
    ));

    $wp_customize->add_setting('advance_portfolio_author_hide',array(
       'default' => false,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('advance_portfolio_author_hide',array(
       'type' => 'checkbox',
       'label' => __('Author','advance-portfolio'),
       'section' => 'advance_portfolio_blog_post'
    ));

    $wp_customize->add_setting('advance_portfolio_tags_hide',array(
       'default' => false,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('advance_portfolio_tags_hide',array(
       'type' => 'checkbox',
       'label' => __('Single Post Tags','advance-portfolio'),
       'section' => 'advance_portfolio_blog_post'
    ));

    $wp_customize->add_setting('advance_portfolio_blog_post_description_option',array(
    	'default'   => __('Excerpt Content','advance-portfolio'), 
        'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control('advance_portfolio_blog_post_description_option',array(
        'type' => 'radio',
        'label' => __('Post Description Length','advance-portfolio'),
        'section' => 'advance_portfolio_blog_post',
        'choices' => array(
            'No Content' => __('No Content','advance-portfolio'),
            'Excerpt Content' => __('Excerpt Content','advance-portfolio'),
            'Full Content' => __('Full Content','advance-portfolio'),
        ),
	) );

    $wp_customize->add_setting( 'advance_portfolio_excerpt_number', array(
		'default'              => 20,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'advance_portfolio_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','advance-portfolio' ),
		'section'     => 'advance_portfolio_blog_post',
		'type'        => 'number',
		'settings'    => 'advance_portfolio_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'advance_portfolio_post_suffix_option', array(
		'default'   => __('...','advance-portfolio'), 
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'advance_portfolio_post_suffix_option', array(
		'label'       => esc_html__( 'Post Excerpt Indicator Option','advance-portfolio' ),
		'section'     => 'advance_portfolio_blog_post',
		'type'        => 'text',
		'settings'    => 'advance_portfolio_post_suffix_option',
	) );

	$wp_customize->add_setting('advance_portfolio_button_text',array(
		'default'=> __('Read More','advance-portfolio'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('advance_portfolio_button_text',array(
		'label'	=> __('Add Button Text','advance-portfolio'),
		'section'=> 'advance_portfolio_blog_post',
		'type'=> 'text'
	));

	//footer
	$wp_customize->add_section('advance_portfolio_footer_section', array(
		'title'       => __('Footer Text', 'advance-portfolio'),
		'priority'    => null,
		'panel'       => 'advance_portfolio_panel_id',
	));

	$wp_customize->add_setting('advance_portfolio_footer_widget_areas',array(
        'default'           => 4,
        'sanitize_callback' => 'advance_portfolio_sanitize_choices',
    ));
    $wp_customize->add_control('advance_portfolio_footer_widget_areas',array(
        'type'        => 'select',
        'label'       => __('Footer widget area', 'advance-portfolio'),
        'section'     => 'advance_portfolio_footer_section',
        'description' => __('Select the number of widget areas you want in the footer. After that, go to Appearance > Widgets and add your widgets.', 'advance-portfolio'),
        'choices' => array(
            '1'     => __('One', 'advance-portfolio'),
            '2'     => __('Two', 'advance-portfolio'),
            '3'     => __('Three', 'advance-portfolio'),
            '4'     => __('Four', 'advance-portfolio')
        ),
    ));

	$wp_customize->add_setting('advance_portfolio_footer_copy', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('advance_portfolio_footer_copy', array(
		'label'   => __('Copyright Text', 'advance-portfolio'),
		'section' => 'advance_portfolio_footer_section',
		'type'    => 'text',
	));

	$wp_customize->add_setting('advance_portfolio_enable_disable_scroll',array(
        'default' => true,
        'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('advance_portfolio_enable_disable_scroll',array(
     	'type' => 'checkbox',
      	'label' => __('Show / Hide Scroll Top Button','advance-portfolio'),
      	'section' => 'advance_portfolio_footer_section',
	));

	$wp_customize->add_setting('advance_portfolio_scroll_setting',array(
        'default' => __('Right','advance-portfolio'),
        'sanitize_callback' => 'advance_portfolio_sanitize_choices'
	));
	$wp_customize->add_control('advance_portfolio_scroll_setting',array(
        'type' => 'select',
        'label' => __('Scroll Back to Top Position','advance-portfolio'),
        'section' => 'advance_portfolio_footer_section',
        'choices' => array(
            'Left' => __('Left','advance-portfolio'),
            'Right' => __('Right','advance-portfolio'),
            'Center' => __('Center','advance-portfolio'),
        ),
	) );
}
add_action('customize_register', 'advance_portfolio_customize_register');

// logo resize
load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Advance_Portfolio_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if (is_null($instance)) {
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
		add_action('customize_register', array($this, 'sections'));

		// Register scripts and styles for the controls.
		add_action('customize_controls_enqueue_scripts', array($this, 'enqueue_control_scripts'), 0);
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections($manager) {

		// Load custom sections.
		load_template(trailingslashit(get_template_directory()).'/inc/section-pro.php');

		// Register custom section types.
		$manager->register_section_type('Advance_Portfolio_Customize_Section_Pro');

		// Register sections.
		$manager->add_section(
			new Advance_Portfolio_Customize_Section_Pro(
				$manager,
				'example_1',
				array(
					'priority' => 9,
					'title'    => esc_html__('Portfolio Pro', 'advance-portfolio'),
					'pro_text' => esc_html__('Go Pro', 'advance-portfolio'),
					'pro_url'  => esc_url('https://www.themeshopy.com/themes/wordpress-portfolio-theme/'),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script('advance-portfolio-customize-controls', trailingslashit(get_template_directory_uri()).'/js/customize-controls.js', array('customize-controls'));

		wp_enqueue_style('advance-portfolio-customize-controls', trailingslashit(get_template_directory_uri()).'/css/customize-controls.css');
	}
}

// Doing this customizer thang!
Advance_Portfolio_Customize::get_instance();
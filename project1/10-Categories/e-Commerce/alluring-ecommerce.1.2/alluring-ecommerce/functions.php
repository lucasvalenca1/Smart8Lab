<?php 
add_action( 'wp_enqueue_scripts', 'alluring_ecommerce_enqueue_styles' );
function alluring_ecommerce_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
} 



function alluring_ecommerce_load_google_fonts() {
	wp_enqueue_style( 'gutenshop-google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,900' ); 
}
add_action( 'wp_enqueue_scripts', 'alluring_ecommerce_load_google_fonts' );

function alluring_ecommerce_customize_register( $wp_customize ) {
	$wp_customize->add_setting( 'hide_bordertop_landingpage', array(
		'default' => 0,
		'sanitize_callback' => 'sanitize_text_field',
		) );
	$wp_customize->add_control( 'hide_bordertop_landingpage', array(
		'label'    => __( 'Hide H2 top border on landing page', 'gutenshop' ),
		'description'    => __( 'When using the Landing Page template and creating h2 there is a border top, check the box to remove it', 'gutenshop' ),
		'section'  => 'background_image',
		'priority' => 0,
		'settings' => 'hide_bordertop_landingpage',
		'type'     => 'checkbox',
		) );

	$wp_customize->add_setting( 'hide_topimg_border', array(
		'default' => 0,
		'sanitize_callback' => 'sanitize_text_field',
		) );
	$wp_customize->add_control( 'hide_topimg_border', array(
		'label'    => __( 'Hide top on border headlines', 'gutenshop' ),
		'section'  => 'slideshow_settings_general',
		'priority' => 0,
		'settings' => 'hide_topimg_border',
		'type'     => 'checkbox',
		) );



	$wp_customize->add_setting( 'footer_copyright_link', array(
		'default'           => '#cca352',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_setting( 'global_byline', array(
		'default'           => '#cca352',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_setting( 'global_link', array(
		'default'           => '#cca352',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_setting( 'global_sale_bg', array(
		'default'           => '#cca352',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_setting( 'blog_post_byline', array(
		'default'           => '#cca352',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_setting( 'global_button_background', array(
		'default'           => '#cca352',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_setting( 'blog_post_navigation_link', array(
		'default'           => '#cca352',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_setting( 'slide_one_button_background_color', array(
		'default'           => '#cca352',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_setting( 'slide_three_button_background_color', array(
		'default'           => '#cca352',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );	
	$wp_customize->add_setting( 'slide_five_button_background_color', array(
		'default'           => '#cca352',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_setting( 'slide_seven_button_background_color', array(
		'default'           => '#cca352',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_setting( 'slide_nine_button_background_color', array(
		'default'           => '#cca352',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_setting( 'slideshow_current_dots_color', array(
		'default'           => '#cca352',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_setting( 'navigation_background_color', array(
		'default'           => '#202020',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_setting( 'navigation_link_color', array(
		'default'           => '#b9b9b9',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	/* Footer Settings */
	$wp_customize->add_section( 'footer_settings', array(
		'title'      => __('Footer Settings','gutenshop'),
		'priority'   => 20,
		'capability' => 'edit_theme_options',
		) );
	$wp_customize->add_setting( 'footer_background', array(
		'default'           => '#181818',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_background', array(
		'label'       => __( 'Background Color', 'gutenshop' ),
		'section'     => 'footer_settings',
		'priority'   => 1,
		'settings'    => 'footer_background',
		) ) );

	$wp_customize->add_setting( 'footer_widget_headline', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_widget_headline', array(
		'label'       => __( 'Widget Headline Color', 'gutenshop' ),
		'section'     => 'footer_settings',
		'priority'   => 1,
		'settings'    => 'footer_widget_headline',
		) ) );
	$wp_customize->add_setting( 'footer_widget_border', array(
		'default'           => '#333',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_widget_border', array(
		'label'       => __( 'Widget Border Color', 'gutenshop' ),
		'section'     => 'footer_settings',
		'priority'   => 1,
		'settings'    => 'footer_widget_border',
		) ) );
	$wp_customize->add_setting( 'footer_widget_text', array(
		'default'           => '#a3a3a3',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_widget_text', array(
		'label'       => __( 'Widget Text Color', 'gutenshop' ),
		'section'     => 'footer_settings',
		'priority'   => 1,
		'settings'    => 'footer_widget_text',
		) ) );
	$wp_customize->add_setting( 'footer_widget_link', array(
		'default'           => '#c5c5c5',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_widget_link', array(
		'label'       => __( 'Widget Link Color', 'gutenshop' ),
		'section'     => 'footer_settings',
		'priority'   => 1,
		'settings'    => 'footer_widget_link',
		) ) );

	$wp_customize->add_setting( 'footer_copyright_link', array(
		'default'           => '#fab526',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_copyright_link', array(
		'label'       => __( 'Copyright Link Color', 'gutenshop' ),
		'section'     => 'footer_settings',
		'priority'   => 1,
		'settings'    => 'footer_copyright_link',
		) ) );

	$wp_customize->add_setting( 'footer_copyright_text', array(
		'default'           => '#dedede',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_copyright_text', array(
		'label'       => __( 'Copyright Text Color', 'gutenshop' ),
		'section'     => 'footer_settings',
		'priority'   => 1,
		'settings'    => 'footer_copyright_text',
		) ) );

}
add_action( 'customize_register', 'alluring_ecommerce_customize_register', 99 );



if(! function_exists('alluring_ecommerce_customize_register_output' ) ):
	function alluring_ecommerce_customize_register_output(){
		?>
		<style type="text/css">
		<?php if ( get_theme_mod( 'hide_bordertop_landingpage' ) == '1' ) : ?>
		.headline-border-top {display:none;}
		<?php endif; ?>
		<?php if ( get_theme_mod( 'hide_topimg_border' ) == '1' ) : ?>
		.owl-item h3:before {display:none;}
		<?php endif; ?>
		.footer-container, .footer-widgets-container { background: <?php echo esc_attr(get_theme_mod( 'footer_background')); ?>; }
		.footer-widgets-container h4, .footer-widgets-container h1, .footer-widgets-container h2, .footer-widgets-container h3, .footer-widgets-container h5, .footer-widgets-container h4 a, .footer-widgets-container th, .footer-widgets-container caption { color: <?php echo esc_attr(get_theme_mod( 'footer_widget_headline')); ?>; }
		.footer-widgets-container h4, .footer-widgets-container { border-color: <?php echo esc_attr(get_theme_mod( 'footer_widget_border')); ?>; }
		.footer-column *, .footer-column p, .footer-column li { color: <?php echo esc_attr(get_theme_mod( 'footer_widget_text')); ?>; }
		.footer-column a, .footer-menu li a { color: <?php echo esc_attr(get_theme_mod( 'footer_widget_link')); ?>; }
		.site-info a { color: <?php echo esc_attr(get_theme_mod( 'footer_copyright_link')); ?>; }
		.site-info { color: <?php echo esc_attr(get_theme_mod( 'footer_copyright_text')); ?>; }

		<?php if ( get_theme_mod( 'slideshow_alignment' ) == 'left' ) : ?>
		.slider-content {
			text-align: left;
		}
		.owl-item h3:before {
			margin:0 auto 10px 0;
		}
		<?php endif; ?>
		<?php if ( get_theme_mod( 'slideshow_alignment' ) == 'center' ) : ?>
		.slider-content {
			text-align: center;
		}
		.owl-item h3:before {
			margin:0 auto 10px auto;
		}
		<?php endif; ?>
		<?php if ( get_theme_mod( 'slideshow_alignment' ) == 'right' ) : ?>
		.slider-content {
			text-align: right;
		}
		.owl-item h3:before {
			margin-bottom:10px;
			margin-left:auto;
			margin-right:0;
		}
		<?php endif; ?>


		</style>
		<?php }
		add_action( 'wp_head', 'alluring_ecommerce_customize_register_output', 99 );
		endif;

		function alluring_ecommerce_before_h2($content){ 
			$content = preg_replace("|<\s*h[2](?:.*)>(.*)</\s*h|Ui", "<div class='headline-border-top'></div> $0", $content);
			return $content;
		}
		add_filter('the_content', 'alluring_ecommerce_before_h2');


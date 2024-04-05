<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

add_action( 'after_setup_theme', 'lalita_background_setup' );
/**
 * Overwrite parent theme background defaults and registers support for WordPress features.
 *
 */
function lalita_background_setup() {
	add_theme_support( "custom-background",
		array(
			'default-color' 		 => 'f5dbdf',
			'default-image'          => '',
			'default-repeat'         => 'repeat',
			'default-position-x'     => 'left',
			'default-position-y'     => 'top',
			'default-size'           => 'auto',
			'default-attachment'     => '',
			'wp-head-callback'       => '_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => ''
		)
	);
}

/**
 * Overwrite theme URL
 *
 */
function lalita_theme_uri_link() {
	return 'https://wpkoi.com/pushan-wpkoi-wordpress-theme/';
}

/**
 * Overwrite parent theme's blog header function
 *
 */
add_action( 'lalita_after_header', 'lalita_blog_header_image', 11 );
function lalita_blog_header_image() {

	if ( ( is_front_page() && is_home() ) || ( is_home() ) ) { 
		$blog_header_image 			=  lalita_get_setting( 'blog_header_image' ); 
		$blog_header_title 			=  lalita_get_setting( 'blog_header_title' ); 
		$blog_header_text 			=  lalita_get_setting( 'blog_header_text' ); 
		$blog_header_button_text 	=  lalita_get_setting( 'blog_header_button_text' ); 
		$blog_header_button_url 	=  lalita_get_setting( 'blog_header_button_url' ); 
		if ( $blog_header_image != '' ) { ?>
		<div class="page-header-image grid-parent page-header-blog">
			<div class="page-header-blog-inner">
				<div class="page-header-blog-content-h grid-container">
                    <div class="page-header-blog-image">
                    	<img src="<?php echo esc_url($blog_header_image); ?>" />
                    </div>
					<div class="page-header-blog-content">
					<?php if ( ( $blog_header_title != '' ) || ( $blog_header_text != '' ) ) { ?>
						<div class="page-header-blog-text">
							<?php if ( $blog_header_title != '' ) { ?>
                            <h2><?php echo wp_kses_post( $blog_header_title ); ?></h2>
                            <div class="clearfix"></div>
                            <?php } ?>
                            <?php if ( $blog_header_title != '' ) { ?>
                            <p><?php echo wp_kses_post( $blog_header_text ); ?></p>
                            <div class="clearfix"></div>
                            <?php } ?>
                        </div>
                        <div class="page-header-blog-button">
							<?php if ( $blog_header_button_text != '' ) { ?>
                            <a class="read-more button" href="<?php echo esc_url( $blog_header_button_url ); ?>"><?php echo esc_html( $blog_header_button_text ); ?></a>
                            <?php } ?>
                        </div>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
	}
}

if ( ! function_exists( 'pushan_remove_parent_dynamic_css' ) ) {
	add_action( 'init', 'pushan_remove_parent_dynamic_css' );
	/**
	 * The dynamic styles of the parent theme added inline to the parent stylesheet.
	 * For the customizer functions it is better to enqueue after the child theme stylesheet.
	 */
	function pushan_remove_parent_dynamic_css() {
		remove_action( 'wp_enqueue_scripts', 'lalita_enqueue_dynamic_css', 50 );
	}
}

if ( ! function_exists( 'pushan_enqueue_parent_dynamic_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'pushan_enqueue_parent_dynamic_css', 50 );
	/**
	 * Enqueue this CSS after the child stylesheet, not after the parent stylesheet.
	 *
	 */
	function pushan_enqueue_parent_dynamic_css() {
		$css = lalita_base_css() . lalita_font_css() . lalita_advanced_css() . lalita_spacing_css() . lalita_no_cache_dynamic_css();

		// escaped secure before in parent theme
		wp_add_inline_style( 'lalita-child', $css );
	}
}

// Extra cutomizer functions
if ( ! function_exists( 'pushan_customize_register' ) ) {
	add_action( 'customize_register', 'pushan_customize_register' );
	function pushan_customize_register( $wp_customize ) {
		
		// Dotted divider function
		$wp_customize->add_setting(
			'pushan_settings[dotted_div]',
			array(
				'default' => true,
				'type' => 'option',
				'sanitize_callback' => 'pushan_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			'pushan_settings[dotted_div]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Dashed dividers', 'pushan' ),
				'section' => 'lalita_blog_section',
				'priority' => 29
			)
		);
		
		// Colorized blog image function
		$wp_customize->add_setting(
			'pushan_settings[colorized_img]',
			array(
				'default' => true,
				'type' => 'option',
				'sanitize_callback' => 'pushan_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			'pushan_settings[colorized_img]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Hover effect on blog images', 'pushan' ),
				'section' => 'lalita_blog_section',
				'priority' => 30
			)
		);
		
	}
}

if ( ! function_exists( 'pushan_sanitize_checkbox' ) ) {
	/**
	 * Sanitize checkbox values.
	 *
	 */
	function pushan_sanitize_checkbox( $checked ) {
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
}

if ( ! function_exists( 'pushan_body_classes' ) ) {
	add_filter( 'body_class', 'pushan_body_classes' );
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 */
	function pushan_body_classes( $classes ) {
		// Get Customizer settings
		$pushan_settings = get_option( 'pushan_settings' );
		
		// Return if dotted divider function is not exist
		if ( ( ! isset( $pushan_settings['dotted_div'] ) ) && ( ! isset( $pushan_settings['colorized_img'] ) ) ) {
			return $classes;
		}
		
		// Dotted divider function
		if ( $pushan_settings['dotted_div'] == true ) {
			$classes[] = 'pushan-dotted-div';
		}
		
		// Colorized blog images function
		if ( $pushan_settings['colorized_img'] == true ) {
			$classes[] = 'pushan-colorized-img';
		}
		
		return $classes;
	}
}
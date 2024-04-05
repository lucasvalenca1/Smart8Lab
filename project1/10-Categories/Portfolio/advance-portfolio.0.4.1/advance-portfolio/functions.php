<?php
/**
 * Advance Portfolio functions and definitions
 *
 * @package advance-portfolio
 */
/**
 * Set the content width based on the theme's design and stylesheet.
 */

/* Theme Setup */
if (!function_exists('advance_portfolio_setup')):

function advance_portfolio_setup() {

	$GLOBALS['content_width'] = apply_filters('advance_portfolio_content_width', 640);

	load_theme_textdomain('advance-portfolio', get_template_directory().'/languages');
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
	add_theme_support('woocommerce');
	add_theme_support('title-tag');
	add_theme_support('custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		));

	add_image_size('advance-portfolio-homepage-thumb', 250, 145, true);
	register_nav_menus(array(
			'primary' => __('Primary Menu', 'advance-portfolio'),
		));

	add_theme_support('custom-background', array(
			'default-color' => 'f1f1f1',
		));

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
   */
	add_theme_support(
		'post-formats', array(
			'image',
			'video',
			'gallery',
			'audio',
		)
	);

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style(array('css/editor-style.css', advance_portfolio_font_url()));
}

	// Theme Activation Notice
	global $pagenow;
	
	if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
		add_action( 'admin_notices', 'advance_portfolio_activation_notice' );
	}

endif;
add_action('after_setup_theme', 'advance_portfolio_setup');

// Notice after Theme Activation
function advance_portfolio_activation_notice() {
	echo '<div class="notice notice-success is-dismissible get-started">';
		echo '<p>'. esc_html__( 'Thank you for choosing ThemeShopy. We are sincerely obliged to offer our best services to you. Please proceed towards welcome page and give us the privilege to serve you.', 'advance-portfolio' ) .'</p>';
		echo '<p><a href="'. esc_url( admin_url( 'themes.php?page=advance_portfolio_guide' ) ) .'" class="button button-primary">'. esc_html__( 'Click here...', 'advance-portfolio' ) .'</a></p>';
	echo '</div>';
}

/* Theme Widgets Setup */
function advance_portfolio_widgets_init() {
	register_sidebar(array(
		'name'          => __('Blog Sidebar', 'advance-portfolio'),
		'description'   => __('Appears on blog page sidebar', 'advance-portfolio'),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	register_sidebar(array(
		'name'          => __('Page Sidebar', 'advance-portfolio'),
		'description'   => __('Appears on page sidebar', 'advance-portfolio'),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	register_sidebar(array(
		'name'          => __('Third Column Sidebar', 'advance-portfolio'),
		'description'   => __('Appears on page sidebar', 'advance-portfolio'),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	//Footer widget areas
	$widget_areas = get_theme_mod('advance_portfolio_footer_widget_areas', '4');
	for ($i=1; $i<=$widget_areas; $i++) {
		register_sidebar( array(
			'name'          => __( 'Footer Nav ', 'advance-portfolio' ) . $i,
			'id'            => 'footer-' . $i,
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

	register_sidebar( array(
		'name'          => __( 'Shop Page Sidebar', 'advance-portfolio' ),
		'description'   => __( 'Appears on shop page', 'advance-portfolio' ),
		'id'            => 'woocommerce_sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Single Product Page Sidebar', 'advance-portfolio' ),
		'description'   => __( 'Appears on shop page', 'advance-portfolio' ),
		'id'            => 'woocommerce-single-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action('widgets_init', 'advance_portfolio_widgets_init');

/* Theme Font URL */
function advance_portfolio_font_url() {
	$font_url      = '';
	$font_family   = array();
	$font_family[] = 'Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';

	$query_args = array(
		'family' => rawurlencode(implode('|', $font_family)),
	);
	$font_url = add_query_arg($query_args, '//fonts.googleapis.com/css');
	return $font_url;
}

/* Theme enqueue scripts */

function advance_portfolio_scripts() {
	wp_enqueue_style('advance-portfolio-font', advance_portfolio_font_url(), array());
	wp_enqueue_style('bootstrap', get_template_directory_uri().'/css/bootstrap.css');
	wp_enqueue_style('advance-portfolio-basic-style', get_stylesheet_uri());
	wp_enqueue_style('advance-portfolio-customcss', get_template_directory_uri().'/css/custom.css');
	wp_enqueue_style('font-awesome', get_template_directory_uri().'/css/fontawesome-all.css');

	// Paragraph
	    $advance_portfolio_paragraph_color = get_theme_mod('advance_portfolio_paragraph_color', '');
	    $advance_portfolio_paragraph_font_family = get_theme_mod('advance_portfolio_paragraph_font_family', '');
	    $advance_portfolio_paragraph_font_size = get_theme_mod('advance_portfolio_paragraph_font_size', '');
	// "a" tag
		$advance_portfolio_atag_color = get_theme_mod('advance_portfolio_atag_color', '');
	    $advance_portfolio_atag_font_family = get_theme_mod('advance_portfolio_atag_font_family', '');
	// "li" tag
		$advance_portfolio_li_color = get_theme_mod('advance_portfolio_li_color', '');
	    $advance_portfolio_li_font_family = get_theme_mod('advance_portfolio_li_font_family', '');
	// H1
		$advance_portfolio_h1_color = get_theme_mod('advance_portfolio_h1_color', '');
	    $advance_portfolio_h1_font_family = get_theme_mod('advance_portfolio_h1_font_family', '');
	    $advance_portfolio_h1_font_size = get_theme_mod('advance_portfolio_h1_font_size', '');
	// H2
		$advance_portfolio_h2_color = get_theme_mod('advance_portfolio_h2_color', '');
	    $advance_portfolio_h2_font_family = get_theme_mod('advance_portfolio_h2_font_family', '');
	    $advance_portfolio_h2_font_size = get_theme_mod('advance_portfolio_h2_font_size', '');
	// H3
		$advance_portfolio_h3_color = get_theme_mod('advance_portfolio_h3_color', '');
	    $advance_portfolio_h3_font_family = get_theme_mod('advance_portfolio_h3_font_family', '');
	    $advance_portfolio_h3_font_size = get_theme_mod('advance_portfolio_h3_font_size', '');
	// H4
		$advance_portfolio_h4_color = get_theme_mod('advance_portfolio_h4_color', '');
	    $advance_portfolio_h4_font_family = get_theme_mod('advance_portfolio_h4_font_family', '');
	    $advance_portfolio_h4_font_size = get_theme_mod('advance_portfolio_h4_font_size', '');
	// H5
		$advance_portfolio_h5_color = get_theme_mod('advance_portfolio_h5_color', '');
	    $advance_portfolio_h5_font_family = get_theme_mod('advance_portfolio_h5_font_family', '');
	    $advance_portfolio_h5_font_size = get_theme_mod('advance_portfolio_h5_font_size', '');
	// H6
		$advance_portfolio_h6_color = get_theme_mod('advance_portfolio_h6_color', '');
	    $advance_portfolio_h6_font_family = get_theme_mod('advance_portfolio_h6_font_family', '');
	    $advance_portfolio_h6_font_size = get_theme_mod('advance_portfolio_h6_font_size', '');

		$custom_css ='
			p,span{
			    color:'.esc_html($advance_portfolio_paragraph_color).'!important;
			    font-family: '.esc_html($advance_portfolio_paragraph_font_family).';
			    font-size: '.esc_html($advance_portfolio_paragraph_font_size).';
			}
			a{
			    color:'.esc_html($advance_portfolio_atag_color).'!important;
			    font-family: '.esc_html($advance_portfolio_atag_font_family).';
			}
			li{
			    color:'.esc_html($advance_portfolio_li_color).'!important;
			    font-family: '.esc_html($advance_portfolio_li_font_family).';
			}
			h1{
			    color:'.esc_html($advance_portfolio_h1_color).'!important;
			    font-family: '.esc_html($advance_portfolio_h1_font_family).'!important;
			    font-size: '.esc_html($advance_portfolio_h1_font_size).'!important;
			}
			h2{
			    color:'.esc_html($advance_portfolio_h2_color).'!important;
			    font-family: '.esc_html($advance_portfolio_h2_font_family).'!important;
			    font-size: '.esc_html($advance_portfolio_h2_font_size).'!important;
			}
			h3{
			    color:'.esc_html($advance_portfolio_h3_color).'!important;
			    font-family: '.esc_html($advance_portfolio_h3_font_family).'!important;
			    font-size: '.esc_html($advance_portfolio_h3_font_size).'!important;
			}
			h4{
			    color:'.esc_html($advance_portfolio_h4_color).'!important;
			    font-family: '.esc_html($advance_portfolio_h4_font_family).'!important;
			    font-size: '.esc_html($advance_portfolio_h4_font_size).'!important;
			}
			h5{
			    color:'.esc_html($advance_portfolio_h5_color).'!important;
			    font-family: '.esc_html($advance_portfolio_h5_font_family).'!important;
			    font-size: '.esc_html($advance_portfolio_h5_font_size).'!important;
			}
			h6{
			    color:'.esc_html($advance_portfolio_h6_color).'!important;
			    font-family: '.esc_html($advance_portfolio_h6_font_family).'!important;
			    font-size: '.esc_html($advance_portfolio_h6_font_size).'!important;
			}
			';
	wp_add_inline_style( 'advance-portfolio-basic-style',$custom_css );
	
	wp_enqueue_script('SmoothScroll', get_template_directory_uri().'/js/SmoothScroll.js', array('jquery'));
	wp_enqueue_script('advance-portfolio-customscripts-jquery', get_template_directory_uri().'/js/custom.js', array('jquery'));
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
	wp_enqueue_script('bootstrap', get_template_directory_uri().'/js/bootstrap.js', array('jquery'));
	wp_enqueue_script( 'jquery-superfish', get_template_directory_uri() . '/js/jquery.superfish.js', array('jquery') ,'',true);
	require get_parent_theme_file_path( '/inc/ts-color-pallete.php' );
	wp_add_inline_style( 'advance-portfolio-basic-style',$custom_css );

	wp_enqueue_style('advance-portfolio-ie', get_template_directory_uri().'/css/ie.css', array('advance-portfolio-basic-style'));
	wp_style_add_data('advance-portfolio-ie', 'conditional', 'IE');
}
add_action('wp_enqueue_scripts', 'advance_portfolio_scripts');

function advance_portfolio_sanitize_dropdown_pages($page_id, $setting) {
	// Ensure $input is an absolute integer.
	$page_id = absint($page_id);
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ('publish' == get_post_status($page_id)?$page_id:$setting->default);
}

// Excerpt Limit Begin
function advance_portfolio_string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}


/*radio button sanitization*/
function advance_portfolio_sanitize_choices($input, $setting) {
	global $wp_customize;
	$control = $wp_customize->get_control($setting->id);
	if (array_key_exists($input, $control->choices)) {
		return $input;
	} else {
		return $setting->default;
	}
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'advance_portfolio_loop_columns');
if (!function_exists('advance_portfolio_loop_columns')) {
	function advance_portfolio_loop_columns() {
		$columns = get_theme_mod( 'advance_portfolio_wooproducts_per_columns', 3 );
		return $columns; // 3 products per row
	}
}

//Change number of products that are displayed per page (shop page)
add_filter( 'loop_shop_per_page', 'advance_portfolio_shop_per_page', 20 );
function advance_portfolio_shop_per_page( $cols ) {
  	$cols = get_theme_mod( 'advance_portfolio_wooproducts_per_page', 9 );
	return $cols;
}

define('ADVANCE_PORTFOLIO_BUY_NOW',__('https://www.themeshopy.com/themes/wordpress-portfolio-theme/','advance-portfolio'));
define('ADVANCE_PORTFOLIO_LIVE_DEMO',__('https://themeshopy.com/advance-portfolio-pro/','advance-portfolio'));
define('ADVANCE_PORTFOLIO_PRO_DOC',__('https://themeshopy.com/demo/docs/advance-portfolio-pro/','advance-portfolio'));
define('ADVANCE_PORTFOLIO_FREE_DOC',__('https://www.themeshopy.com/demo/docs/free-advance-portfolio/','advance-portfolio'));
define('ADVANCE_PORTFOLIO_CONTACT',__('https://wordpress.org/support/theme/advance-portfolio','advance-portfolio'));
define('ADVANCE_PORTFOLIO_CREDIT',__('https://www.themeshopy.com/themes/free-wordpress-portfolio-theme/', 'advance-portfolio'));

if (!function_exists('advance_portfolio_credit')) {
	function advance_portfolio_credit() {
		echo "<a href=".esc_url(ADVANCE_PORTFOLIO_CREDIT).">".esc_html__('Portfolio WordPress Theme', 'advance-portfolio')."</a>";
	}
}

/* Custom header additions. */
require get_template_directory().'/inc/custom-header.php';

/* Custom template tags for this theme. */
require get_template_directory().'/inc/template-tags.php';

/* Customizer additions. */
require get_template_directory().'/inc/customizer.php';

/* admin file. */
require get_template_directory() . '/inc/admin/admin.php';
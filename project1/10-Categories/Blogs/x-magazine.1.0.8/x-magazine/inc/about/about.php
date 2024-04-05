<?php
/**
 * About setup
 *
 * @package xblog
 */

if ( ! function_exists( 'x_magazine_about_setup' ) ) :

	/**
	 * About setup.
	 *
	 * @since 1.0.0
	 */
	function x_magazine_about_setup() {
		$theme = wp_get_theme();
$xtheme_name = $theme->get( 'Name' );
$xtheme_domain = $theme->get( 'TextDomain' );
if( $xtheme_domain == 'x-magazine' ){
	$theme_slug = $xtheme_domain; 
}else{
	$theme_slug = 'x-magazine'; 
}



		$config = array(
		// Menu name under Appearance.
		'menu_name'               => sprintf( esc_html__( '%s Info', 'x-magazine' ),$xtheme_name),
		// Page title.
		'page_name'               => sprintf( esc_html__( '%s Info', 'x-magazine' ),$xtheme_name),
		/* translators: Main welcome title */
		'welcome_title'         => sprintf( esc_html__( 'Welcome to %s! - Version ', 'x-magazine' ), $theme['Name'] ),
		// Main welcome content
			// Welcome content.
			'welcome_content' => sprintf( esc_html__( '%1$s is now installed and ready to use. We want to make sure you have the best experience using the theme and that is why we gathered here all the necessary information for you. Thanks for using our theme!', 'x-magazine' ), $theme['Name'] ),

			// Tabs.
			'tabs' => array(
				'getting_started' => esc_html__( 'Getting Started', 'x-magazine' ),
				'recommended_actions' => esc_html__( 'Recommended Actions', 'x-magazine' ),
				'useful_plugins'  => esc_html__( 'Useful Plugins', 'x-magazine' ),
				'free_pro'  => esc_html__( 'Free Vs Pro', 'x-magazine' ),
				),

			// Quick links.
			'quick_links' => array(
                'update_url' => array(
                    'text'   => esc_html__( 'UPGRADE X MAGAZINE PRO', 'x-magazine' ),
                    'url'    => 'https://wpthemespace.com/product/x-magazine/',
                    'button' => 'danger',
                ),
                'xmagazine_url' => array(
                    'text'   => esc_html__( 'X MAGAZINE PRO Demo', 'x-magazine' ),
                    'url'    => 'http://wpthemium.com/xm/',
                    'button' => 'danger',
                ),
                
                
            ),

			// Getting started.
			'getting_started' => array(
				'one' =>array(
					'title'       => esc_html__( 'Demo Content', 'x-magazine' ),
					'icon'        => 'dashicons dashicons-layout',
					'description' => sprintf( esc_html__( 'Demo content is pro feature. To import sample demo content, %1$s plugin should be installed and activated. After plugin is activated, visit Import Demo Data menu under Appearance.', 'x-magazine' ), esc_html__( 'One Click Demo Import', 'x-magazine' ) ),
					'button_text' => esc_html__( 'UPGRADE For  Demo Content', 'x-magazine' ),
					'button_url'  => 'https://wpthemespace.com/product/'.$theme_slug,
					'button_type' => 'primary',
					'is_new_tab'  => true,
					),
				 
				'two' => array(
					'title'       => esc_html__( 'Theme Options', 'x-magazine' ),
					'icon'        => 'dashicons dashicons-admin-customizer',
					'description' => esc_html__( 'Theme uses Customizer API for theme options. Using the Customizer you can easily customize different aspects of the theme.', 'x-magazine' ),
					'button_text' => esc_html__( 'Customize', 'x-magazine' ),
					'button_url'  => wp_customize_url(),
					'button_type' => 'primary',
					),
				'three' => array(
					'title'       => esc_html__( 'Show Video', 'x-magazine' ),
					'icon'        => 'dashicons dashicons-layout',
					'description' => sprintf( esc_html__( 'You may show Xblog short video for better understanding', 'x-magazine' ), esc_html__( 'One Click Demo Import', 'x-magazine' ) ),
					'button_text' => esc_html__( 'Show video', 'x-magazine' ),
					'button_url'  => 'https://www.youtube.com/watch?v=Cu3eFFQskCs',
					'button_type' => 'primary',
					'is_new_tab'  => true,
					),
				'four' => array(
					'title'       => esc_html__( 'Theme Documentation', 'x-magazine' ),
					'icon'        => 'dashicons dashicons-format-aside',
					'description' => esc_html__( 'Please check our full documentation for detailed information on how to setup and customize the theme.', 'x-magazine' ),
					'button_text' => esc_html__( 'View Documentation', 'x-magazine' ),
					'button_url'  => 'http://wpthemespace.com/xblog/doc/',
					'button_type' => 'primary',
					'is_new_tab'  => true,
					),
				'five' => array(
				    'title'       => esc_html__( 'Set Widgets', 'x-magazine' ),
				    'icon'        => 'dashicons dashicons-tagcloud',
				    'description' => esc_html__( 'Set widgets in your sidebar, Offcanvas as well as footer.', 'x-magazine' ),
				    'button_text' => esc_html__( 'Add Widgets', 'x-magazine' ),
				    'button_url'  => admin_url().'/widgets.php',
				    'button_type' => 'link',
				    'is_new_tab'  => true,
				),
				'six' => array(
					'title'       => esc_html__( 'Theme Preview', 'x-magazine' ),
					'icon'        => 'dashicons dashicons-welcome-view-site',
					'description' => esc_html__( 'You can check out the theme demos for reference to find out what you can achieve using the theme and how it can be customized. Theme demo only work in pro theme', 'x-magazine' ),
					'button_text' => esc_html__( 'View Demo', 'x-magazine' ),
					'button_url'  => 'https://wpthemespace.com/xblog/demo1/',
					'button_type' => 'link',
					'is_new_tab'  => true,
					),
                'seven' => array(
                    'title'       => esc_html__( 'Contact Support', 'x-magazine' ),
                    'icon'        => 'dashicons dashicons-sos',
                    'description' => esc_html__( 'Got theme support question or found bug or got some feedbacks? Best place to ask your query is the dedicated Support forum for the theme.', 'x-magazine' ),
                    'button_text' => esc_html__( 'Contact Support', 'x-magazine' ),
                    'button_url'  => 'https://wpthemespace.com/support/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
				),

					'useful_plugins'        => array(
						'description' => esc_html__( 'Theme supports some helpful WordPress plugins to enhance your site. But, please enable only those plugins which you need in your site. For example, enable WooCommerce only if you are using e-commerce.', 'x-magazine' ),
						'already_activated_message' => esc_html__( 'Already activated', 'x-magazine' ),
						'version_label' => esc_html__( 'Version: ', 'x-magazine' ),
						'install_label' => esc_html__( 'Install and Activate', 'x-magazine' ),
						'activate_label' => esc_html__( 'Activate', 'x-magazine' ),
						'deactivate_label' => esc_html__( 'Deactivate', 'x-magazine' ),
						'content'                   => array(
							array(
								'slug' => 'gallery-box',
								'icon' => 'svg',
							),
							array(
								'slug' => 'x-instafeed'
							),
							array(
								'slug' => 'click-to-top'
							),
							array(
								'slug' => 'niso-carousel-slider'
							),
						),
					),
					// Required actions array.
					'recommended_actions'        => array(
						'install_label' => esc_html__( 'Install and Activate', 'x-magazine' ),
						'activate_label' => esc_html__( 'Activate', 'x-magazine' ),
						'deactivate_label' => esc_html__( 'Deactivate', 'x-magazine' ),
						'content'            => array(
							'click-to-top' => array(
								'title'       => __('Gallery Box', 'x-magazine' ),
								'description' => __( 'These recommended plugin need to install and active for create awesome image/photo gallery, portfolio gallery, video gallery and more.', 'x-magazine' ),
								'plugin_slug' => 'gallery-box',
								'id' => 'gallery-box'
							),
							'go-pro' => array(
								'title'       => '<a target="_blank" class="activate-now button button-danger" href="https://wpthemespace.com/product/x-magazine/?add-to-cart=792">'.__('UPGRADE X MAGAZINE PRO','x-magazine').'</a>',
								'description' => __( 'You will get more frequent updates and quicker support with the Pro version.', 'x-magazine' ),
								//'plugin_slug' => 'x-instafeed',
								'id' => 'go-pro'
							),
							
						),
					),
			// Free vs pro array.
			'free_pro'                => array(
				'free_theme_name'     => $xtheme_name,
				'pro_theme_name'      => $xtheme_name.__(' Pro','x-magazine'),
				'pro_theme_link'      => 'https://wpthemespace.com/product/'.$theme_slug,
				/* translators: View link */
				'get_pro_theme_label' => sprintf( __( 'Get %s', 'x-magazine' ), 'X Magazine Pro' ),
				'features'            => array(
					array(
						'title'       => esc_html__( 'Daring Design for Devoted Readers', 'x-magazine' ),
						'description' => esc_html__( 'X Magazine\'s design helps you stand out from the crowd and create an experience that your readers will love and talk about. With a flexible home page you have the chance to easily showcase appealing content with ease.', 'x-magazine' ),
						'is_in_lite'  => 'true',
						'is_in_pro'   => 'true',
					),
					array(
						'title'       => esc_html__( 'Mobile-Ready For All Devices', 'x-magazine' ),
						'description' => esc_html__( 'X Magazine makes room for your readers to enjoy your articles on the go, no matter the device their using. We shaped everything to look amazing to your audience.', 'x-magazine' ),
						'is_in_lite'  => 'true',
						'is_in_pro'   => 'true',
					),
					array(
						'title'       => esc_html__( 'Home slider', 'x-magazine' ),
						'description' => esc_html__( 'X Magazine gives you extra slider feature. You can create awesome home slider in this theme.', 'x-magazine' ),
						'is_in_lite'  => 'true',
						'is_in_pro'   => 'true',
					),
					array(
						'title'       => esc_html__( 'Ads banner', 'x-magazine' ),
						'description' => esc_html__( 'X Magazine gives you many ads banner area that you can add banner or google ads code.', 'x-magazine' ),
						'is_in_lite'  => 'false',
						'is_in_pro'   => 'true',
					),
					array(
						'title'       => esc_html__( 'Widgetized Sidebars To Keep Attention', 'x-magazine' ),
						'description' => esc_html__( 'X Magazine comes with a widget-based flexible system which allows you to add your favorite widgets over the Sidebar as well as on offcanvas too.', 'x-magazine' ),
						'is_in_lite'  => 'true',
						'is_in_pro'   => 'true',
					),
					array(
						'title'       => esc_html__( 'Multiple Header Layout', 'x-magazine' ),
						'description' => esc_html__( 'X Magazine gives you extra ways to showcase your header with miltiple layout option you can change it on the basis of your requirement', 'x-magazine' ),
						'is_in_lite'  => 'true',
						'is_in_pro'   => 'true',
					),
					array(
						'title'       => esc_html__( 'Banner Slider Options', 'x-magazine' ),
						'description' => esc_html__( 'X Magazine\'s PRO version comes with more Slider options to display and filter posts. For instance, you can have far more control on setting the source of the posts or how they are displayed, everything to push the content to the right people and promote it by the blink of an eye.', 'x-magazine' ),
						'is_in_lite'  => 'false',
						'is_in_pro'   => 'true',
					),
					array(
						'title'       => esc_html__( 'Flexible Home Page Design', 'x-magazine' ),
						'description' => esc_html__( 'X Magazine\'s PRO version has more controll available to enable you to place widgets on Footer or Below the Post at the end of your articles.', 'x-magazine' ),
						'is_in_lite'  => 'false',
						'is_in_pro'   => 'true',
					),
					array(
						'title'       => esc_html__( 'Read Time Calculator and total words counter', 'x-magazine' ),
						'description' => esc_html__( 'Minimal Lit\'s PRO verison has a feature to let your viewer know the read time of the standared article you have posted on the basis of words per minute which you can control on your customizer .', 'x-magazine' ),
						'is_in_lite'  => 'false',
						'is_in_pro'   => 'true',
					),
					array(
						'title'       => esc_html__( 'Advance Customizer Options', 'x-magazine' ),
						'description' => esc_html__( 'Advance control for each element gives you different way of customization and maintained you site as you like and makes you feel different.', 'x-magazine' ),
						'is_in_lite'  => 'false',
						'is_in_pro'   => 'true',
					),
					array(
						'title'       => esc_html__( 'Advance Pagination', 'x-magazine' ),
						'description' => esc_html__( 'Multiple Option of pagination via customizer can be obtained on your site like Infinite scroll, Ajax Button On Click, Number as well as classical option are available.','x-magazine' ),
						'is_in_lite'  => 'ture',
						'is_in_pro'   => 'true',
					),
					array(
						'title'       => esc_html__( 'One Click Demo install', 'x-magazine' ),
						'description' => esc_html__( 'You can import demo site only one click so you can setup your site like demo very easily.','x-magazine' ),
						'is_in_lite'  => 'ture',
						'is_in_pro'   => 'true',
					),
					array(
						'title'       => esc_html__( 'Premium Support and Assistance', 'x-magazine' ),
						'description' => esc_html__( 'We offer ongoing customer support to help you get things done in due time. This way, you save energy and time, and focus on what brings you happiness. We know our products inside-out and we can lend a hand to help you save resources of all kinds.','x-magazine' ),
						'is_in_lite'  => 'false',
						'is_in_pro'   => 'true',
					),
					array(
						'title'       => esc_html__( 'No Credit Footer Link', 'x-magazine' ),
						'description' => esc_html__( 'You can easily remove the Theme: X Magazine by xblog copyright from the footer area and make the theme yours from start to finish.', 'x-magazine' ),
						'is_in_lite'  => 'false',
						'is_in_pro'   => 'true',
					),
				),
			),

			);

		x_magazine_About::init( $config );
	}

endif;

add_action( 'after_setup_theme', 'x_magazine_about_setup' );

//Admin notice 
function x_magazine_admin_notice__error() {
	
    if(get_option('xmagazine5')){
        return;
    }
	$class = 'eye-notice notice notice-warning is-dismissible';
	$message = __( '<strong>Hi Buddy!!  You are using the free version. If you are happy with the free version then good but If you want a beautiful, orderly, SEO friendly, more secure and unlimited options website then need to upgrade pro. UPGRADE FOR LIFETIME WITH NOMINAL PRICE. <br><span> GOOD NEWS: X Magazine rpo theme now support woocommerce plugin so now you can sell anything with X Magazine pro theme !!!</span> ', 'x-magazine' );

    $url1 = esc_url('https://wpthemespace.com/product/x-magazine/');
    $url2 =esc_url('https://wpthemespace.com/product/x-blog/?add-to-cart=792');
    $url3 =esc_url('https://wpthemespace.com/product/x-blog/');

	printf( '<div class="%1$s" style="padding:10px 15px 20px;text-transform:uppercase"><p>%2$s</p><a target="_blank" class="button button-primary" href="%3$s" style="margin-right:10px">'.__('X Magazine Pro Details','x-magazine').'</a><a target="_blank" class="button button-primary" href="%4$s" style="margin-right:10px">'.__('Upgrade Pro','x-magazine').'</a><a target="_blank" class="button button-primary" href="%5$s" style="margin-right:10px">'.__('Most Popular XBLOG PRO Theme','x-magazine').'</a><button class="button button-info btnend" style="margin-left:10px">'.__('Dismiss the notice','x-magazine').'</button></div>', esc_attr( $class ), wp_kses_post( $message ),$url1,$url2,$url3 ); 
}
add_action( 'admin_notices', 'x_magazine_admin_notice__error' );

function x_magazine_admin_notice_option(){
    if(isset($_GET['xnotice']) && $_GET['xnotice'] == 1 ){
        update_option( 'xmagazine5', 1);
    }
}
add_action('init','x_magazine_admin_notice_option');
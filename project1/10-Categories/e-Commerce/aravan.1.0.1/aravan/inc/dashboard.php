<?php
/**
 * Builds our admin page.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'aravan_create_menu' ) ) {
	add_action( 'admin_menu', 'aravan_create_menu' );
	/**
	 * Adds our "Aravan" dashboard menu item
	 *
	 */
	function aravan_create_menu() {
		$aravan_page = add_theme_page( 'Aravan', 'Aravan', apply_filters( 'aravan_dashboard_page_capability', 'edit_theme_options' ), 'aravan-options', 'aravan_settings_page' );
		add_action( "admin_print_styles-$aravan_page", 'aravan_options_styles' );
	}
}

if ( ! function_exists( 'aravan_options_styles' ) ) {
	/**
	 * Adds any necessary scripts to the Aravan dashboard page
	 *
	 */
	function aravan_options_styles() {
		wp_enqueue_style( 'aravan-options', get_template_directory_uri() . '/css/admin/admin-style.css', array(), ARAVAN_VERSION );
	}
}

if ( ! function_exists( 'aravan_settings_page' ) ) {
	/**
	 * Builds the content of our Aravan dashboard page
	 *
	 */
	function aravan_settings_page() {
		?>
		<div class="wrap">
			<div class="metabox-holder">
				<div class="aravan-masthead clearfix">
					<div class="aravan-container">
						<div class="aravan-title">
							<a href="<?php echo esc_url(ARAVAN_THEME_URL); ?>" target="_blank"><?php esc_html_e( 'Aravan', 'aravan' ); ?></a> <span class="aravan-version"><?php echo esc_html( ARAVAN_VERSION ); ?></span>
						</div>
						<div class="aravan-masthead-links">
							<?php if ( ! defined( 'ARAVAN_PREMIUM_VERSION' ) ) : ?>
								<a class="aravan-masthead-links-bold" href="<?php echo esc_url(ARAVAN_THEME_URL); ?>" target="_blank"><?php esc_html_e( 'Premium', 'aravan' );?></a>
							<?php endif; ?>
							<a href="<?php echo esc_url(ARAVAN_WPKOI_AUTHOR_URL); ?>" target="_blank"><?php esc_html_e( 'WPKoi', 'aravan' ); ?></a>
                            <a href="<?php echo esc_url(ARAVAN_DOCUMENTATION); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'aravan' ); ?></a>
						</div>
					</div>
				</div>

				<?php
				/**
				 * aravan_dashboard_after_header hook.
				 *
				 */
				 do_action( 'aravan_dashboard_after_header' );
				 ?>

				<div class="aravan-container">
					<div class="postbox-container clearfix" style="float: none;">
						<div class="grid-container grid-parent">

							<?php
							/**
							 * aravan_dashboard_inside_container hook.
							 *
							 */
							 do_action( 'aravan_dashboard_inside_container' );
							 ?>

							<div class="form-metabox grid-70" style="padding-left: 0;">
								<h2 style="height:0;margin:0;"><!-- admin notices below this element --></h2>
								<form method="post" action="options.php">
									<?php settings_fields( 'aravan-settings-group' ); ?>
									<?php do_settings_sections( 'aravan-settings-group' ); ?>
									<div class="customize-button hide-on-desktop">
										<?php
										printf( '<a id="aravan_customize_button" class="button button-primary" href="%1$s">%2$s</a>',
											esc_url( admin_url( 'customize.php' ) ),
											esc_html__( 'Customize', 'aravan' )
										);
										?>
									</div>

									<?php
									/**
									 * aravan_inside_options_form hook.
									 *
									 */
									 do_action( 'aravan_inside_options_form' );
									 ?>
								</form>

								<?php
								$modules = array(
									'Backgrounds' => array(
											'url' => ARAVAN_THEME_URL,
									),
									'Blog' => array(
											'url' => ARAVAN_THEME_URL,
									),
									'Colors' => array(
											'url' => ARAVAN_THEME_URL,
									),
									'Copyright' => array(
											'url' => ARAVAN_THEME_URL,
									),
									'Disable Elements' => array(
											'url' => ARAVAN_THEME_URL,
									),
									'Demo Import' => array(
											'url' => ARAVAN_THEME_URL,
									),
									'Hooks' => array(
											'url' => ARAVAN_THEME_URL,
									),
									'Import / Export' => array(
											'url' => ARAVAN_THEME_URL,
									),
									'Menu Plus' => array(
											'url' => ARAVAN_THEME_URL,
									),
									'Page Header' => array(
											'url' => ARAVAN_THEME_URL,
									),
									'Secondary Nav' => array(
											'url' => ARAVAN_THEME_URL,
									),
									'Spacing' => array(
											'url' => ARAVAN_THEME_URL,
									),
									'Typography' => array(
											'url' => ARAVAN_THEME_URL,
									),
									'Elementor Addon' => array(
											'url' => ARAVAN_THEME_URL,
									)
								);

								if ( ! defined( 'ARAVAN_PREMIUM_VERSION' ) ) : ?>
									<div class="postbox aravan-metabox">
										<h3 class="hndle"><?php esc_html_e( 'Premium Modules', 'aravan' ); ?></h3>
										<div class="inside" style="margin:0;padding:0;">
											<div class="premium-addons">
												<?php foreach( $modules as $module => $info ) { ?>
												<div class="add-on activated aravan-clear addon-container grid-parent">
													<div class="addon-name column-addon-name" style="">
														<a href="<?php echo esc_url( $info[ 'url' ] ); ?>" target="_blank"><?php echo esc_html( $module ); ?></a>
													</div>
													<div class="addon-action addon-addon-action" style="text-align:right;">
														<a href="<?php echo esc_url( $info[ 'url' ] ); ?>" target="_blank"><?php esc_html_e( 'More info', 'aravan' ); ?></a>
													</div>
												</div>
												<div class="aravan-clear"></div>
												<?php } ?>
											</div>
										</div>
									</div>
								<?php
								endif;

								/**
								 * aravan_options_items hook.
								 *
								 */
								do_action( 'aravan_options_items' );
								?>
							</div>

							<div class="aravan-right-sidebar grid-30" style="padding-right: 0;">
								<div class="customize-button hide-on-mobile">
									<?php
									printf( '<a id="aravan_customize_button" class="button button-primary" href="%1$s">%2$s</a>',
										esc_url( admin_url( 'customize.php' ) ),
										esc_html__( 'Customize', 'aravan' )
									);
									?>
								</div>

								<?php
								/**
								 * aravan_admin_right_panel hook.
								 *
								 */
								 do_action( 'aravan_admin_right_panel' );

								  ?>
                                
                                <div class="wpkoi-doc">
                                	<h3><?php esc_html_e( 'Aravan documentation', 'aravan' ); ?></h3>
                                	<p><?php esc_html_e( 'If You`ve stuck, the documentation may help on WPKoi.com', 'aravan' ); ?></p>
                                    <a href="<?php echo esc_url(ARAVAN_DOCUMENTATION); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( 'Aravan documentation', 'aravan' ); ?></a>
                                </div>
                                
                                <div class="wpkoi-social">
                                	<h3><?php esc_html_e( 'WPKoi on Facebook', 'aravan' ); ?></h3>
                                	<p><?php esc_html_e( 'If You want to get useful info about WordPress and the theme, follow WPKoi on Facebook.', 'aravan' ); ?></p>
                                    <a href="<?php echo esc_url(ARAVAN_WPKOI_SOCIAL_URL); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( 'Go to Facebook', 'aravan' ); ?></a>
                                </div>
                                
                                <div class="wpkoi-review">
                                	<h3><?php esc_html_e( 'Help with You review', 'aravan' ); ?></h3>
                                	<p><?php esc_html_e( 'If You like Aravan theme, show it to the world with Your review. Your feedback helps a lot.', 'aravan' ); ?></p>
                                    <a href="<?php echo esc_url(ARAVAN_WORDPRESS_REVIEW); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( 'Add my review', 'aravan' ); ?></a>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'aravan_admin_errors' ) ) {
	add_action( 'admin_notices', 'aravan_admin_errors' );
	/**
	 * Add our admin notices
	 *
	 */
	function aravan_admin_errors() {
		$screen = get_current_screen();

		if ( 'appearance_page_aravan-options' !== $screen->base ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) && 'true' == $_GET['settings-updated'] ) {
			 add_settings_error( 'aravan-notices', 'true', esc_html__( 'Settings saved.', 'aravan' ), 'updated' );
		}

		if ( isset( $_GET['status'] ) && 'imported' == $_GET['status'] ) {
			 add_settings_error( 'aravan-notices', 'imported', esc_html__( 'Import successful.', 'aravan' ), 'updated' );
		}

		if ( isset( $_GET['status'] ) && 'reset' == $_GET['status'] ) {
			 add_settings_error( 'aravan-notices', 'reset', esc_html__( 'Settings removed.', 'aravan' ), 'updated' );
		}

		settings_errors( 'aravan-notices' );
	}
}

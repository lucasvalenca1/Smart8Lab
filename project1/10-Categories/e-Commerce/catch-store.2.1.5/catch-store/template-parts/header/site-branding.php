<?php
/**
 * Displays header site branding
 *
 * @package Catch_Store
 */
?>

<div id="header-content">
	<div class="wrapper">
		<div class="site-header-main">
			<?php	/*When header right menu is disabled*/
				get_template_part( 'template-parts/navigation/navigation-header-search', 'right' ); ?>
				<div class="site-branding">
					<?php catch_store_the_custom_logo(); ?>

					<div class="site-identity">
						<?php if ( is_front_page() && is_home() ) : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php endif;

						$description = get_bloginfo( 'description', 'display' );
						if ( $description || is_customize_preview() ) : ?>
							<p class="site-description"><?php echo $description; ?></p>
						<?php endif; ?>
					</div><!-- .site-identity -->
				</div><!-- .site-branding -->
			
					<div class="secondary-search-wrapper">
						<div id="search-social-container-right">
	        				<div class="search-container">
	            				<?php get_search_form(); ?>
	            			</div><!-- #search-container -->
						</div><!-- #search-social-container-right -->
					</div><!-- .secondary-search-wrapper -->
		</div><!-- .site-header-main -->
	</div><!-- .wrapper -->
</div><!-- #header-content -->

<?php
/**
 * The template for displaying Archive pages.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div id="primary" <?php aravan_content_class(); ?>>
		<main id="main" <?php aravan_main_class(); ?>>
			<?php
			/**
			 * aravan_before_main_content hook.
			 *
			 */
			do_action( 'aravan_before_main_content' );

			if ( have_posts() ) :

				/**
				 * aravan_archive_title hook.
				 *
				 *
				 * @hooked aravan_archive_title - 10
				 */
				do_action( 'aravan_archive_title' );

				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

				endwhile;

				aravan_content_nav( 'nav-below' );

			else :

				get_template_part( 'no-results', 'archive' );

			endif;

			/**
			 * aravan_after_main_content hook.
			 *
			 */
			do_action( 'aravan_after_main_content' );
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
	/**
	 * aravan_after_primary_content_area hook.
	 *
	 */
	 do_action( 'aravan_after_primary_content_area' );

	 aravan_construct_sidebars();

get_footer();

<?php
/**
 * The template for displaying 404 pages (Not Found).
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
			?>

			<div class="inside-article">

				<?php
				/**
				 * aravan_before_content hook.
				 *
				 *
				 * @hooked aravan_featured_page_header_inside_single - 10
				 */
				do_action( 'aravan_before_content' );
				?>

				<header class="entry-header">
					<h1 class="entry-title" itemprop="headline"><?php echo esc_html( apply_filters( 'aravan_404_title', __( 'Oops! That page can&rsquo;t be found.', 'aravan' ) ) ); // WPCS: XSS OK. ?></h1>
				</header><!-- .entry-header -->

				<?php
				/**
				 * aravan_after_entry_header hook.
				 *
				 *
				 * @hooked aravan_post_image - 10
				 */
				do_action( 'aravan_after_entry_header' );
				?>

				<div class="entry-content" itemprop="text">
					<?php
					echo '<p>' . esc_html( apply_filters( 'aravan_404_text', __( 'It looks like nothing was found at this location. Maybe try searching?', 'aravan' ) ) ) . '</p>'; // WPCS: XSS OK.

					get_search_form();
					?>
				</div><!-- .entry-content -->

				<?php
				/**
				 * aravan_after_content hook.
				 *
				 */
				do_action( 'aravan_after_content' );
				?>

			</div><!-- .inside-article -->

			<?php
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

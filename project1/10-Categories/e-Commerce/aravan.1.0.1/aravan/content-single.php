<?php
/**
 * The template for displaying single posts.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php aravan_article_schema( 'CreativeWork' ); ?>>
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
			<?php
			/**
			 * aravan_before_entry_title hook.
			 *
			 */
			do_action( 'aravan_before_entry_title' );

			if ( aravan_show_title() ) {
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
			}

			/**
			 * aravan_after_entry_title hook.
			 *
			 *
			 * @hooked aravan_post_meta - 10
			 */
			do_action( 'aravan_after_entry_title' );
			?>
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
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'aravan' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->

		<?php
		/**
		 * aravan_after_entry_content hook.
		 *
		 *
		 * @hooked aravan_footer_meta - 10
		 */
		do_action( 'aravan_after_entry_content' );

		/**
		 * aravan_after_content hook.
		 *
		 */
		do_action( 'aravan_after_content' );
		?>
	</div><!-- .inside-article -->
</article><!-- #post-## -->

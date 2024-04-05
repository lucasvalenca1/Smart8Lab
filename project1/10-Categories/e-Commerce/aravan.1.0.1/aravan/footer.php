<?php
/**
 * The template for displaying the footer.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

	</div><!-- #content -->
</div><!-- #page -->

<?php
/**
 * aravan_before_footer hook.
 *
 */
do_action( 'aravan_before_footer' );
?>

<div <?php aravan_footer_class(); ?>>
	<?php
	/**
	 * aravan_before_footer_content hook.
	 *
	 */
	do_action( 'aravan_before_footer_content' );

	/**
	 * aravan_footer hook.
	 *
	 *
	 * @hooked aravan_construct_footer_widgets - 5
	 * @hooked aravan_construct_footer - 10
	 */
	do_action( 'aravan_footer' );

	/**
	 * aravan_after_footer_content hook.
	 *
	 */
	do_action( 'aravan_after_footer_content' );
	?>
</div><!-- .site-footer -->

<?php
/**
 * aravan_after_footer hook.
 *
 */
do_action( 'aravan_after_footer' );

wp_footer();
?>

</body>
</html>

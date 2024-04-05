<?php
/**
 * The template for displaying the header.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php aravan_body_schema();?> <?php body_class(); ?>>
	<?php
	/**
	 * new WordPress action since version 5.2
	 */
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	
	/**
	 * aravan_before_header hook.
	 *
	 *
	 * @hooked aravan_do_skip_to_content_link - 2
	 * @hooked aravan_top_bar - 5
	 * @hooked aravan_add_navigation_before_header - 5
	 */
	do_action( 'aravan_before_header' );

	/**
	 * aravan_header hook.
	 *
	 *
	 * @hooked aravan_construct_header - 10
	 */
	do_action( 'aravan_header' );

	/**
	 * aravan_after_header hook.
	 *
	 *
	 * @hooked aravan_featured_page_header - 10
	 */
	do_action( 'aravan_after_header' );
	?>

	<div id="page" class="hfeed site grid-container container grid-parent">
		<div id="content" class="site-content">
			<?php
			/**
			 * aravan_inside_container hook.
			 *
			 */
			do_action( 'aravan_inside_container' );

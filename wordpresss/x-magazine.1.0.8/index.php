<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package x-blog
 */
<?php
// Include the WordPress environment
define('WP_USE_THEMES', true);
require('path/to/wp-load.php');
<?php
require_once get_template_directory() . '/functions.php';
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php
		if (have_posts()) :
			$xcount = 0;

			if (is_home() && !is_front_page()) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

		<?php
			endif;

			/* Start the Loop */
			while (have_posts()) : the_post();
				$xcount++;
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				if (is_single() || $xcount == 1) {
					get_template_part('template-parts/content', get_post_format());
				} else {
					get_template_part('template-parts/content', 'list');
				}

			endwhile;

			the_posts_navigation();

		else :

			get_template_part('template-parts/content', 'none');

		endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();

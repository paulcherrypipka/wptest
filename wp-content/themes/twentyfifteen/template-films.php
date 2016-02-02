<?php
/**
 * The template for displaying pages
 *
 * Template Name: Шаблон для фильмов
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
        $args = array(
            'post_type' => 'films',
            'publish' => true,
            'paged' => get_query_var('paged'),
        );
        query_posts($args);
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
            get_template_part( 'content-films', 'films' );


		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>

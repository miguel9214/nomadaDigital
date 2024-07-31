<?php
/**
 * Template Name: Slim
 */

get_header();
digifly_page_header();
?>

<div class="content-wrapper<?php echo digifly_wrapper_classes(); ?>">
	<div id="primary" class="content-area<?php echo digifly_primary_classes(); ?>">
		<main id="main" class="site-main" role="main">

		<?php
		do_action( 'digifly_main_start' );

		// Start the loop.
		while ( have_posts() ) :
			the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

		endwhile;

		do_action( 'digifly_main_end' );
		?>

		</main>
	</div>
</div>

<?php
get_footer();

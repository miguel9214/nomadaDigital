<?php
/**
 * The template for displaying all single downloads
 */

get_header();
digifly_page_header();
?>

<div class="content-wrapper<?php echo digifly_wrapper_classes(); ?>">

	<div id="primary" class="content-area<?php echo digifly_primary_classes(); ?>">

		<main id="main" class="site-main" role="main">

			<?php
			// Start the loop.
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the post format-specific template for the content. If you want to
				 * use this in a child theme, then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'download' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				// End the loop.
			endwhile;
			?>

		</main>

		<?php do_action( 'digifly_edd_single_download_primary_end' ); ?>

	</div>

	<?php digifly_get_sidebar( 'download' ); ?>
</div>


<?php get_footer(); ?>

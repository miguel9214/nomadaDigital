<?php
/**
 * Download tag custom taxonomy.
 */
get_header();

digifly_page_header(
	array(
		'title'    => single_term_title( '', false ),
		'subtitle' => term_description( '', 'download_category' ),
	)
);
?>

<div class="content-wrapper<?php echo digifly_wrapper_classes(); ?>">

	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<div class="<?php echo digifly_edd_downloads_list_wrapper_classes(); ?>">

			<?php
			while ( have_posts() ) :
				the_post();
				?>

				<?php get_template_part( 'template-parts/download-grid' ); ?>

			<?php endwhile; ?>

			<?php
			/**
			 * Pagination
			 */
			digifly_edd_download_nav();
			?>

			</div>

			<?php endif; ?>
	</main>

</div>

<?php
get_footer();

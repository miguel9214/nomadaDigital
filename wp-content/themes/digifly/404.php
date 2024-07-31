<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();
digifly_page_header( array( 'title' => __( 'Oops! That page can&rsquo;t be found.', 'digifly' ) ) );
?>

<div class="content-wrapper<?php echo digifly_wrapper_classes(); ?>">

	<div id="primary" class="content-area<?php echo digifly_primary_classes(); ?>">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'digifly' ); ?></p>

					<?php get_search_form(); ?>
				</div>
			</section>

		</main>
	</div>

	<?php digifly_get_sidebar(); ?>

</div>

<?php get_footer(); ?>

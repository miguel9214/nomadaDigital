<?php
/**
 * The template for displaying search results pages
 */

get_header();

if ( have_posts() ) {
	$digifly_page_title = __( 'Search Results', 'digifly' );
} else {
	$digifly_page_title = __( 'Nothing Found', 'digifly' );
}

digifly_page_header(
	array(
		'title'    => $digifly_page_title,
		'subtitle' => sprintf( __( 'You searched for "%s"', 'digifly' ), get_search_query() ),
	)
);

?>
<div class="content-wrapper<?php echo digifly_wrapper_classes(); ?>">

	<div id="primary" class="content-area<?php echo digifly_primary_classes(); ?>">
		<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<?php if ( digifly_is_edd_active() && digifly_Search::is_product_search_results() ) : ?>

				<div class="<?php echo digifly_edd_downloads_list_wrapper_classes(); ?>">

					<?php
					while ( have_posts() ) :
						the_post();
						?>

						<?php get_template_part( 'template-parts/download-grid' ); ?>

					<?php endwhile; ?>

					<?php
					/**
					 * Download pagination
					 */
					digifly_edd_download_nav();
					?>

				</div>

				<?php else : ?>

					<?php
					while ( have_posts() ) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );

						// End the loop.
					endwhile;
					?>

					<?php digifly_paging_nav(); ?>

				<?php endif; ?>

				<?php

				// If no content, include the "No posts found" template.
				else :
					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>

		</main>
	</div>

	<?php digifly_get_sidebar(); ?>

</div>

<?php get_footer(); ?>

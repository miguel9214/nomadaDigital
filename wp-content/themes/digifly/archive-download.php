<?php
/**
 * Downloads archive page.
 * This is used by default unless EDD_DISABLE_ARCHIVE is set to true.
 */

get_header();

$digifly_archive_title = digifly_edd_post_type_archive_title();

if ( $digifly_archive_title ) {
	digifly_page_header( array( 'title' => $digifly_archive_title ) );
}

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
			 * Download pagination
			 */
			digifly_edd_download_nav();
			?>

			</div>

			<?php endif; ?>
	</main>

</div>

<?php
get_footer();

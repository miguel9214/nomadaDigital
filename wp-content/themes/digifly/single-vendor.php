<?php
/**
 * The template for displaying the single vendor page in Frontend Submissions
 */

get_header();
digifly_page_header();

$digifly_fes_vendor_id = absint( fes_get_vendor()->ID );
?>

<div class="content-wrapper<?php echo digifly_wrapper_classes(); ?>">

	<div id="primary" class="content-area<?php echo digifly_primary_classes( array( 'is-vendor-page' ) ); ?>">
		<main id="main" class="site-main" role="main">

		<?php if ( fes_get_vendor() && digifly_is_edd_requests_active() ) : ?>
			<div class="single-vendor-contact text-center"><?php do_action( 'vendor_request_btn', array( 'vendor_id' => $digifly_fes_vendor_id ) ); ?></div>
		<?php endif; ?>

		<?php
		// Start the loop.

		while ( have_posts() ) :
			the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// End of the loop.
		endwhile;
		?>

		</main>

	</div>

</div>

<?php get_footer(); ?>

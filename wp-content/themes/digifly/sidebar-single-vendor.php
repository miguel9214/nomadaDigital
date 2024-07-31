<?php
/**
 * The Sidebar for the vendor page
 *
 * @since 1.0.0
 */
$digifly_fes_vendor_id      = absint( fes_get_vendor()->ID );
$digifly_fes_user_data      = get_userdata( $digifly_fes_vendor_id );
$digifly_fes_author_options = digifly_edd_download_author_options();

?>
<div id="secondary" class="<?php echo digifly_secondary_classes(); ?>">

	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">

		<?php do_action( 'digifly_edd_fes_sidebar_single_vendor_start' ); ?>

		<?php
		/**
		 * The vendor profile and contact form (if enabled)
		 */
		?>
		<section class="widget downloadAuthor">

			<?php
			/**
			 * Vendor's avatar.
			 */
			?>
			<div class="downloadAuthor-avatar">
				<?php echo get_avatar( $digifly_fes_vendor_id, $digifly_fes_author_options['avatar_size'], '', $digifly_fes_user_data->display_name ); ?>
			</div>

			<?php
			/**
			 * Vendor's name.
			 */
			$digifly_fes_user_info    = get_userdata( $digifly_fes_vendor_id );
			$digifly_fes_display_name = $digifly_fes_user_info->display_name;
			?>
			<h2 class="widget-title"><?php echo $digifly_fes_display_name; ?></h2>

			<?php
			/**
			 * Vendor's description.
			 */
			$digifly_fes_description = get_the_author_meta( 'description', $digifly_fes_vendor_id );
			if ( $digifly_fes_description ) :
				?>
			<div class="downloadAuthor-description">
				<p><?php echo $digifly_fes_description; ?></p>
			</div>
			<?php endif; ?>

			<?php
			/**
			 * Vendor's website.
			 */
			$digifly_fes_website = get_the_author_meta( 'user_url', $digifly_fes_vendor_id );
			if ( $digifly_fes_website ) :
				?>
			<div class="downloadAuthor-website">
				<p><a href="<?php echo esc_url( $digifly_fes_website ); ?>" target="_blank" rel="noopener"><?php _e( 'Visit website', 'digifly' ); ?></a></p>
			</div>
			<?php endif; ?>

			<?php
			/**
			 * Vendor's contact form.
			 */
			if ( digifly_edd_fes_vendor_contact_form() ) :
				?>

				<?php echo ( new FES_Forms() )->render_vendor_contact_form( $digifly_fes_vendor_id ); ?>

			<?php endif; ?>

		</section>

		<?php do_action( 'digifly_edd_fes_sidebar_single_vendor_end' ); ?>

	</div>

</div>

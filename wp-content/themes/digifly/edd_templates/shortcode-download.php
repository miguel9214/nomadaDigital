<?php
/**
 * A single download inside of the [downloads] shortcode.
 *
 * @since 2.9.0
 *
 * @package EDD
 * @category Template
 * @author Easy Digital Downloads
 * @version 1.0.0
 */

global $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i;

$digifly_download_grid_options = digifly_edd_download_grid_options( $edd_download_shortcode_item_atts );
?>

<div class="<?php echo esc_attr( apply_filters( 'edd_download_class', 'edd_download', get_the_ID(), $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i ) ); ?>" id="edd_download_<?php the_ID(); ?>">

	<div class="<?php echo esc_attr( apply_filters( 'edd_download_inner_class', 'edd_download_inner', get_the_ID(), $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i ) ); ?>">

		<div class="edd-download-content">
		<?php
			do_action( 'edd_download_before' );

		if ( true === $digifly_download_grid_options['thumbnails'] ) {
			edd_get_template_part( 'shortcode', 'content-image' );
			do_action( 'edd_download_after_thumbnail' );
		}
		?>
		<?php
			/**
			 * Used by digifly_edd_download_meta_before_title()
			 */
			do_action( 'edd_download_before_title' );

		if ( true === $digifly_download_grid_options['title'] ) {
			edd_get_template_part( 'shortcode', 'content-title' );
		}

			do_action( 'edd_download_after_title' );

		if ( true === $digifly_download_grid_options['excerpt'] && true !== $digifly_download_grid_options['full_content'] ) {
			// Show the excerpt.
			edd_get_template_part( 'shortcode', 'content-excerpt' );

			do_action( 'edd_download_after_content' );
		} elseif ( true === $digifly_download_grid_options['full_content'] ) {
			// Show the full content.
			edd_get_template_part( 'shortcode', 'content-full' );

			do_action( 'edd_download_after_content' );
		}

			/**
			 * Download footer
			 */
			digifly_edd_download_footer( $edd_download_shortcode_item_atts );

			do_action( 'edd_download_after' );

		?>
		</div>
	</div>

</div>

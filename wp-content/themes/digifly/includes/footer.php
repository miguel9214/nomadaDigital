<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Display the footer widgets
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'digifly_footer_widgets' ) ) :
	function digifly_footer_widgets() {

		if ( is_active_sidebar( 'footer-4' ) ) {
			$widget_columns = apply_filters( 'digifly_footer_widget_regions', 4 );
		} elseif ( is_active_sidebar( 'footer-3' ) ) {
			$widget_columns = apply_filters( 'digifly_footer_widget_regions', 3 );
		} elseif ( is_active_sidebar( 'footer-2' ) ) {
			$widget_columns = apply_filters( 'digifly_footer_widget_regions', 2 );
		} elseif ( is_active_sidebar( 'footer-1' ) ) {
			$widget_columns = apply_filters( 'digifly_footer_widget_regions', 1 );
		} else {
			$widget_columns = apply_filters( 'digifly_footer_widget_regions', 0 );
		}

		$classes = apply_filters( 'digifly_footer_widgets_classes', array( 'footer-widgets', 'container', 'wrapper', 'columns-' . intval( $widget_columns ) ), $widget_columns );

		if ( $widget_columns > 0 ) : ?>

			<?php do_action( 'digifly_footer_widgets_before' ); ?>

			<?php if ( apply_filters( 'digifly_footer_widgets_show', true ) ) : ?>
			<section class="<?php echo implode( ' ', $classes ); ?>">
				<div class="row">
				<?php do_action( 'digifly_footer_widgets_start' ); ?>

				<?php
				$i = 0;
				while ( $i < $widget_columns ) :
					++$i;

					if ( is_active_sidebar( 'footer-' . $i ) ) :
						$widget_column_classes = apply_filters( 'digifly_footer_widget_classes', array( digifly_footer_widget_column_classes( $widget_columns ), 'footer-widget', 'widget-column', 'footer-widget-' . intval( $i ) ) );
						?>
					<div class="<?php echo implode( ' ', array_filter( $widget_column_classes ) ); ?>">
						<?php dynamic_sidebar( 'footer-' . intval( $i ) ); ?>
					</div>
						<?php
					endif;
				endwhile;
				?>

				<?php do_action( 'digifly_footer_widgets_end' ); ?>
				</div>
			</section>
			<?php endif; ?>

			<?php do_action( 'digifly_footer_widgets_after' ); ?>

			<?php
		endif;
	}
endif;
add_action( 'digifly_footer', 'digifly_footer_widgets' );

/**
 * Display the site info
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'digifly_site_info' ) ) :
	function digifly_site_info() {
		?>
	<section class="site-info wrapper">
			<?php do_action( 'digifly_site_info' ); ?>
	</section>
		<?php
	}
endif;
add_action( 'digifly_footer', 'digifly_site_info' );

/**
 * Copyright
 *
 * @since 1.0.0
 */
function digifly_copyright() {
	$footer    = get_theme_mod( 'footer' );
	$copyright = isset( $footer['copyright'] ) ? $footer['copyright'] : '';

	if ( empty( $copyright ) ) {
		$copyright = sprintf( __( 'Copyright &copy; {Year} %s', 'digifly' ), esc_attr( get_bloginfo( 'name' ) ) );
	}

	$copyright = str_replace( '{Year}', date( 'Y' ), $copyright );
	echo apply_filters( 'digifly_copyright', '<p>' . $copyright . '</p>' );

	if ( apply_filters( 'digifly_footer_backlink', true ) ) {
		$author_uri = digifly_get_author_uri();
		echo sprintf( __( 'DigiFly Theme <a href="%s" target="_blank">Plugins & Snippets.</a>', 'digifly' ), esc_attr( $author_uri ) );
	}
}
add_action( 'digifly_site_info', 'digifly_copyright' );

/**
 * Footer widget column classes
 *
 * @since 1.0.0
 * @param int $widget_columns The number of widget columns in use
 *
 * @return string $classes The classes to be added
 */
function digifly_footer_widget_column_classes( $widget_columns ) {

	switch ( $widget_columns ) {

		case 5:
			$classes = 'col-xs-12 col-sm-6 col-lg-2';
			break;

		case 4:
			$classes = 'col-xs-12 col-sm-6 col-lg-3';
			break;

		case 3:
			$classes = 'col-xs-12 col-sm-6 col-lg-4';
			break;

		case 2:
		case 1:
			$classes = 'col-xs-12 col-sm-6';
			break;

	}

	return apply_filters( 'digifly_footer_widget_column_classes', $classes, $widget_columns );
}

function digifly_footer_columns_modify( $columns ) {
	$footer  = get_theme_mod( 'footer' );
	$columns = isset( $footer['columns'] ) ? $footer['columns'] : '';

	if ( empty( $columns ) ) {
		$columns = 4;
	}

	return $columns;
}
add_filter( 'digifly_footer_widget_regions', 'digifly_footer_columns_modify' );
add_filter( 'digifly_footer_widget_areas', 'digifly_footer_columns_modify' );

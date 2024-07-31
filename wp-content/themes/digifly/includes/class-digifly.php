<?php
/**
 * Digifly Class
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Digifly {

	public function __construct() {
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
	}

	/**
	 * Register widget area.
	 *
	 * Inspired by WooCommerce's Storefront theme
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
	 */
	public function widgets_init() {

		/**
		 * The main theme sidebar
		 */
		$sidebar_args['sidebar'] = array(
			'name'        => __( 'Sidebar', 'digifly' ),
			'id'          => 'sidebar-1',
			'description' => __( 'Add widgets here to appear in your sidebar.', 'digifly' ),
		);

		/**
		 * The download sidebar when Easy Digital Downloads is active
		 */
		if ( digifly_is_edd_active() ) {
			$sidebar_args['sidebar_download'] = array(
				'name'        => __( 'Download Sidebar', 'digifly' ),
				'id'          => 'sidebar-download',
				'description' => sprintf( __( 'Add widgets here to appear in your %s sidebar.', 'digifly' ), edd_get_label_singular() ),
			);
		}

		/**
		 * Sets the number of allowed widget areas
		 */
		$footer_widget_areas = apply_filters( 'digifly_footer_widget_areas', 4 );

		for ( $i = 1; $i <= intval( $footer_widget_areas ); $i++ ) {

			$footer = sprintf( 'footer_%d', $i );

			$sidebar_args[ $footer ] = array(
				'name'        => sprintf( __( 'Footer %d', 'digifly' ), $i ),
				'id'          => sprintf( 'footer-%d', $i ),
				'description' => sprintf( __( 'Add widgets here to appear in footer %d.', 'digifly' ), $i ),
			);

		}

		$sidebar_args = apply_filters( 'digifly_sidebar_args', $sidebar_args );

		foreach ( $sidebar_args as $sidebar => $args ) {

			$widget_tags = array(
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			);

			/**
			 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
			 *
			 * digifly_sidebar_widget_tags
			 * digifly_sidebar_download_widget_tags
			 *
			 * digifly_footer_1_widget_tags
			 * digifly_footer_2_widget_tags
			 * digifly_footer_3_widget_tags
			 * digifly_footer_4_widget_tags
			 */
			$filter_hook = sprintf( 'digifly_%s_widget_tags', $sidebar );
			$widget_tags = apply_filters( $filter_hook, $widget_tags );

			if ( is_array( $widget_tags ) ) {
				register_sidebar( $args + $widget_tags );
			}
		}
	}

}
new Digifly();

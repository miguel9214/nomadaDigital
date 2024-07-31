<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'digifly_styles' ) ) :
	function digifly_styles() {

		// Suffix.
		$suffix = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? '' : '.min';

		// Theme stylesheet.
		wp_enqueue_style( 'digifly-style', get_theme_file_uri( 'style' . $suffix . '.css' ), array(), DIGIFLY_VERSION );
	}
	add_action( 'wp_enqueue_scripts', 'digifly_styles' );
endif;

/**
 * Enqueue scripts and styles
 *
 * @since 1.0.0
 */
function digifly_scripts() {

	wp_register_script( 'comment-reply', '', '', '', true );

	// Suffix.
	$suffix = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'digifly-js', get_theme_file_uri( '/assets/js/digifly' . $suffix . '.js' ), array( 'jquery' ), DIGIFLY_VERSION, true );

	wp_localize_script(
		'digifly-js',
		'screenReaderText',
		array(
			'expand'   => '<span class="screen-reader-text">' . esc_html__( 'expand child menu', 'digifly' ) . '</span>',
			'collapse' => '<span class="screen-reader-text">' . esc_html__( 'collapse child menu', 'digifly' ) . '</span>',
		)
	);

	// Load the nav cart.
	if ( class_exists( 'digifly_EDD_Nav_Cart' ) ) {

		$cart_option = digifly_EDD_Nav_Cart::cart_option();

		if ( 'item_quantity' === $cart_option || 'all' === $cart_option ) {

			$cart_quantity_text = digifly_EDD_Nav_Cart::cart_quantity_text();

			// Cart text
			wp_localize_script(
				'digifly-js',
				'cartQuantityText',
				array(
					'singular' => $cart_quantity_text['singular'],
					'plural'   => $cart_quantity_text['plural'],
				)
			);
		}
	}

	/**
	 * Comments
	 */

	// We don't need the script on pages where there is no comment form and not on the homepage if it's a page. Neither do we need the script if comments are closed or not allowed. In other words, we only need it if "Enable threaded comments" is activated and a comment form is displayed.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'digifly_scripts' );

/**
 *  Load the admin styles
 *
 *  @since 1.0
 *  @return void
 */
function digifly_admin_styles( $hook ) {

	if ( 'themes.php' !== $hook && 'appearance_page_digifly-theme-options' !== $hook ) {
		return;
	}

	if ( isset( $_GET['page'] ) && 'digifly-theme-options' !== $_GET['page'] ) {
		return;
	}

	wp_enqueue_style( 'digifly-admin', get_theme_file_uri( '/assets/css/admin.css' ), array(), DIGIFLY_VERSION );
}
add_action( 'admin_enqueue_scripts', 'digifly_admin_styles' );

/**
 *  Load the admin script
 *
 *  @since 1.3.4
 *  @return void
 */
function digifly_admin_scripts( $hook ) {

	if ( 'themes.php' !== $hook && 'appearance_page_digifly-theme-options' !== $hook ) {
		return;
	}

	if ( isset( $_GET['page'] ) && 'digifly-theme-options' !== $_GET['page'] ) {
		return;
	}

	wp_enqueue_script( 'digifly-admin', get_theme_file_uri( '/assets/js/admin.js' ), array( 'jquery' ), DIGIFLY_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'digifly_admin_scripts' );

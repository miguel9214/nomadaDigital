<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Is EDD active?
 *
 * @since 1.0.0
 * @return bool
 */
function digifly_is_edd_active() {
	return class_exists( 'Easy_Digital_Downloads' );
}

/**
 * Is EDD Software Licensing active?
 *
 * @since 1.0.0
 * @return bool
 */
function digifly_is_edd_sl_active() {
	return class_exists( 'EDD_Software_Licensing' );
}

/**
 * Is EDD Recurring active?
 *
 * @since 1.0.0
 * @return bool
 */
function digifly_is_edd_recurring_active() {
	return class_exists( 'EDD_Recurring' );
}

/**
 * Is EDD Frontend Submissions active?
 *
 * @since 1.0.0
 * @return bool
 */
function digifly_is_edd_fes_active() {
	return class_exists( 'EDD_Front_End_Submissions' );
}

/**
 * Is EDD Requests active?
 *
 * @since 1.0.0
 * @return bool
 */
function digifly_is_edd_requests_active() {
	return class_exists( 'EDD_Requests' );
}

/**
 * Is EDD Recommended Products active?
 *
 * @since 1.0.0
 * @return bool
 */
function digifly_is_edd_recommended_products_active() {
	return class_exists( 'EDDRecommendedDownloads' );
}

/**
 * Is EDD Cross-sell & Upsell active?
 *
 * @since 1.0.0
 * @return bool
 */
function digifly_is_edd_cross_sell_upsell_active() {
	return class_exists( 'EDD_Cross_Sell_And_Upsell' );
}

/**
 * Is EDD Coming Soon active?
 *
 * @since 1.0.2
 * @return bool
 */
function digifly_is_edd_coming_soon_active() {
	return class_exists( 'EDD_Coming_Soon' );
}

/**
 * Is EDD Points and Rewards active?
 *
 * @since 1.0.0
 * @return bool
 */
function digifly_is_edd_points_and_rewards_active() {
	return function_exists( 'edd_points_plugin_loaded' );
}

/**
 * Is EDD Reviews active?
 *
 * @since 1.0.0
 * @return bool
 */
function digifly_is_edd_reviews_active() {
	return class_exists( 'EDD_Reviews' );
}


/**
 * Is WooCommerce active?
 *
 * @since 1.0.0
 * @return bool
 */
function digifly_is_woocommerce_active() {
	return class_exists( 'Woocommerce' );
}

/**
 * Is the subtitles plugin active?
 *
 * @since 1.0.0
 * @return bool
 */
function digifly_is_subtitles_active() {
	return class_exists( 'Subtitles' );
}

/**
 * Wrapper for get_sidebar()
 *
 * Allows sidebars to be disabled completely, or on a specific post/page/download
 * Allows sidebars to be swapped out on specific posts/pages/downloads
 *
 * @since 1.0.0
 */
function digifly_get_sidebar( $sidebar = '' ) {

	// Disable all sidebars.
	if ( ! apply_filters( 'digifly_show_sidebar', true ) ) {
		return false;
	}

	return get_sidebar( apply_filters( 'digifly_get_sidebar', $sidebar ) );
}

/**
 * DigiFly page header div classes
 *
 * @since 1.0.0
 * @param array $more_classes Any more classes that need to be added.
 *
 * @return string Classes
 */
function digifly_page_header_classes( $more_classes = array() ) {

	// Set up the default classes.
	$classes = array();

	$classes[] = 'pv-xs-2';
	$classes[] = 'pv-sm-3';
	$classes[] = 'pv-lg-4';

	if ( ! is_singular( 'post' ) ) {
		$classes[] = 'left-xs';
	}

	// Merge any new classes passed in.
	if ( is_array( $more_classes ) ) {
		$classes = array_merge( $classes, $more_classes );
	}

	// Make the classes filterable.
	$classes = apply_filters( 'digifly_page_header_classes', $classes );

	// Return the classes in a string.
	if ( ! empty( $classes ) ) {
		return ' ' . implode( ' ', $classes );
	}
}

/**
 * Controls the CSS classes applied to the main wrappers
 * Useful for overriding the wrapper widths etc
 *
 * @since 1.0.0
 */
function digifly_wrapper_classes() {

	$classes = array();

	// allow filtering of the wrapper classes
	$classes = apply_filters( 'digifly_wrapper_classes', $classes );

	if ( $classes ) {
		return ' ' . implode( ' ', $classes );
	}

	return implode( ' ', $classes );
}

/**
 * DigiFly primary div classes
 *
 * @since 1.0.0
 */
function digifly_primary_classes( $classes = array() ) {
	if (
		is_active_sidebar( 'sidebar-1' ) &&
		! (
			in_array( 'no-sidebar', get_body_class() ) ||
			in_array( 'slim', get_body_class() ) ||
			( function_exists( 'edd_is_checkout' ) && edd_is_checkout() && digifly_edd_distraction_free_checkout() ) ||
			digifly_Search::is_product_search_results() ||
			in_array( 'is-vendor-page', $classes ) ||
			isset( $GLOBALS['digifly_no_sidebar'] )
		) ||
		is_singular( 'download' ) ||
		(
			function_exists( 'is_woocommerce' ) && is_woocommerce()
			&& (
				( ! is_product_category() && ! is_product_category() )
				&& ( is_shop() && digifly_woocommerce_shop_template() === 'sidebar' )
			)
		)
	) {
		$classes[] = 'col-xs-12';
		$classes[] = 'col-md-8';
	}

	$classes = apply_filters( 'digifly_primary_classes', $classes );

	if ( $classes ) {
		return ' ' . implode( ' ', $classes );
	}
}

/**
 * DigiFly secondary div classes
 *
 * @since 1.0.0
 */
function digifly_secondary_classes() {

	$classes   = array();
	$classes[] = 'col-xs-12 col-md-4';

	$classes = apply_filters( 'digifly_secondary_classes', $classes );

	if ( $classes ) {
		return implode( ' ', $classes );
	}
}

/**
 * Display post excerpts
 *
 * @since 1.0.0
 *
 * @return boolean true if post excerpts are enabled, false otherwise
 */
function digifly_display_excerpts() {
	$theme_options    = get_theme_mod( 'theme_options' );
	$display_excerpts = isset( $theme_options['display_excerpts'] ) && true === $theme_options['display_excerpts'] ? true : false;

	return $display_excerpts;
}


/**
 * Read More button on archive pages for list/grid views
 *
 * @since 1.0.0
 */
function digifly_add_readmore_button() {
	$url = get_permalink();

	echo '<div class="digifly-read-more-button"><a href="' . $url . '" class="button">' . __( 'Read More', 'digifly' ) . '</a></div>';
}

/**
 * Full-width layout.
 *
 * @since 1.0.0
 *
 * @return boolean true if the full-width layout is enabled, false otherwise
 */
function digifly_layout_full_width() {
	$theme_options     = get_theme_mod( 'theme_options' );
	$layout_full_width = isset( $theme_options['layout_full_width'] ) && true === $theme_options['layout_full_width'] ? true : false;

	return $layout_full_width;
}

/**
 * Mini Cart
 *
 * @since 1.0.0
 *
 * @return boolean true if the full-width layout is enabled, false otherwise
 */
function digifly_mini_cart_enabled() {
	$theme_options = get_theme_mod( 'theme_options' );
	$mini_cart     = isset( $theme_options['mini_cart'] ) && true === $theme_options['mini_cart'] ? true : false;

	return $mini_cart;
}

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Fire the wp_body_open action.
	 * Adds backward compatibility for WordPress versions < 5.2
	 *
	 * @since 1.0.9
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Get Theme Author URI
 *
 * @since 1.0.0
 *
 * @return string/url
 */
function digifly_get_author_uri() {
	$my_theme = wp_get_theme();
	return $my_theme->get( 'AuthorURI' );
}


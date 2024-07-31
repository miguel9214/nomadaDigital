<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Compatibility with other plugins

/**
 * Subtitles
 *
 * @see https://wordpress.org/plugins/subtitles/
 */
if ( digifly_is_subtitles_active() ) {
	require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/class-digifly-subtitles.php';
}

/**
 * Easy Digital Downloads
 *
 * @see https://easydigitaldownloads.com
 */
if ( digifly_is_edd_active() ) {

	require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/functions.php';
	require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/functions-download-grid.php';
	require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/functions-download-author.php';
	require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/functions-download-meta.php';
	require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/functions-download-details.php';
	require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/actions.php';
	require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/filters.php';
	require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/class-digifly-edd-nav-cart.php';
	require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/widgets/class-digifly-download-author.php';
	require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/widgets/class-digifly-download-details.php';

	// EDD - Frontend Submissions
	if ( digifly_is_edd_fes_active() ) {
		require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/class-digifly-edd-frontend-submissions.php';
	}

	// EDD - Recommended Products
	if ( digifly_is_edd_recommended_products_active() ) {
		require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/class-digifly-edd-recommended-products.php';
	}

	// EDD - Cross-sell/Upsell
	if ( digifly_is_edd_cross_sell_upsell_active() ) {
		require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/class-digifly-edd-cross-sell-upsell.php';
	}

	// EDD - Points and Rewards
	if ( digifly_is_edd_points_and_rewards_active() ) {
		require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/class-digifly-edd-points-and-rewards.php';
	}

	// EDD - Reviews
	if ( digifly_is_edd_reviews_active() ) {
		require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/class-digifly-edd-reviews.php';
	}

	/**
	 * EDD - Coming Soon
	 *
	 * @since 1.0.2
	 */
	if ( digifly_is_edd_coming_soon_active() ) {
		require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility/edd/class-digifly-edd-coming-soon.php';
	}
}

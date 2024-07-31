<?php

/**
 * Loads the secondary menu into the secondary menu.
 *
 * @since 1.0.3
 */
function digifly_secondary_navigation_menu() {

	// Load the secondary navigation.
	if ( has_nav_menu( 'secondary' ) ) {
		add_action( 'digifly_secondary_menu', 'digifly_secondary_navigation' );
	}
}
add_action( 'template_redirect', 'digifly_secondary_navigation_menu', 5 );

/**
 * Show the date and author in the header on single posts
 *
 * @since 1.0.0
 */
function digifly_show_posted_on() {

	if ( is_singular( 'post' ) ) {
		digifly_posted_on();
	}
}
add_action( 'digifly_page_header_wrapper_end', 'digifly_show_posted_on' );

/**
 * Show the featured image on the digifly_article_start hook.
 * This allows us to remove the featured image dynamically where needed.
 *
 * @since 1.0.0
 */
function digifly_show_post_thumbnail() {
	digifly_post_thumbnail();
}
add_action( 'digifly_article_start', 'digifly_show_post_thumbnail' );

/**
 * Show the entry footer info (Categories and tags + edit link).
 *
 * @since 1.0.0
 */
function digifly_show_entry_footer() {

	if ( is_singular( 'post' ) ) {
		digifly_entry_footer();
	}
}
add_action( 'digifly_entry_content_end', 'digifly_show_entry_footer' );

/**
 * Load the biography template after the entry content on a single post.
 *
 * @since 1.0.0
 */
function digifly_show_author_biography() {

	if ( is_singular( 'post' ) && '' !== get_the_author_meta( 'description' ) ) {
		get_template_part( 'template-parts/biography' );
	}
}
add_action( 'digifly_entry_content_end', 'digifly_show_author_biography' );

/**
 * Redirect User to Checkout Page When Using Social Login on Checkout
 *
 * @since 1.0.0
 *
 * @param int $user_id ID of user who was logged in.
 * */
function digifly_redirect_to_checkout_on_nsl_login( $user_id ) {

	$redirect = \NSL\Persistent\Persistent::get( 'redirect' );

	if ( function_exists( 'edd_get_checkout_uri' ) && strstr( $redirect, edd_get_checkout_uri() ) ) {
		wp_redirect( $redirect );
		die();
	}
}
add_action( 'nsl_login', 'digifly_redirect_to_checkout_on_nsl_login', 10 );

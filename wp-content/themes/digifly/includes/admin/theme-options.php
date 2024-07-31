<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function digifly_theme_options() {
	require trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'admin/theme-options-markup.php';
}

function digifly_hook_theme_options_panel() {
	add_theme_page(
		__( 'DigiFly', 'digifly' ),
		__( 'DigiFly', 'digifly' ),
		'manage_options',
		'digifly-theme-options',
		'digifly_theme_options'
	);
}
add_action( 'admin_menu', 'digifly_hook_theme_options_panel' );

/**
 * Processes the subscription request
 * */
function digifly_handle_subscription_request() {

	check_ajax_referer( 'digifly_subscribe', 'security' );

	if ( isset( $_POST['email'] ) && filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) {
		$email = $_POST['email'];
	} else {
		$email = get_option( 'admin_email' );
	}

	wp_remote_post(
		DIGIFLY_SUBSCRIBE_URL,
		array(
			'body' => array(
				'email'       => $email,
				'plugin_name' => DIGIFLY_NAME,
			),
		)
	);

	wp_send_json(
		array(
			'processed' => 1,
		)
	);
}
add_action( 'wp_ajax_digifly_handle_subscription_request', 'digifly_handle_subscription_request' );

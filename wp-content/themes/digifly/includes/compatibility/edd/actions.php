<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds digifly_edd_price() and digifly_edd_purchase_link() to the download details widget.
 *
 * @since 1.0.0
 */
function digifly_edd_download_details_widget( $instance, $download_id ) {
	do_action( 'digifly_edd_download_info', $download_id );
}
add_action( 'edd_product_details_widget_before_purchase_button', 'digifly_edd_download_details_widget', 10, 2 );

/**
 * Download price
 *
 * @since 1.0.0
 */
function digifly_edd_price( $download_id ) {

	// Return early if price enhancements has been disabled.
	if ( false === digifly_edd_price_enhancements() ) {
		return;
	}

	if ( edd_is_free_download( $download_id ) ) {
		$price = '<span id="edd_price_' . get_the_ID() . '" class="edd_price">' . __( 'Free', 'digifly' ) . '</span>';
	} elseif ( edd_has_variable_prices( $download_id ) ) {
		$price = '<span id="edd_price_' . get_the_ID() . '" class="edd_price">' . __( 'From', 'digifly' ) . '&nbsp;' . edd_currency_filter( edd_format_amount( edd_get_lowest_price_option( $download_id ) ) ) . '</span>';
	} else {
		$price = edd_price( $download_id, false );
	}

	echo $price;
}
add_action( 'digifly_edd_download_info', 'digifly_edd_price', 10, 1 );

/**
 * Download purchase link
 *
 * @since 1.0.0
 */
function digifly_edd_purchase_link( $download_id ) {

	if ( get_post_meta( $download_id, '_edd_hide_purchase_link', true ) ) {
		return; // Do not show if auto output is disabled
	}

	echo edd_get_purchase_link();
}
add_action( 'digifly_edd_download_info', 'digifly_edd_purchase_link', 10, 1 );

/**
 * Remove and deactivate all styling included with EDD
 *
 * @since 1.0.0
 */
remove_action( 'wp_enqueue_scripts', 'edd_register_styles' );

/**
 * Remove the purchase link at the bottom of the single download page.
 *
 * @since 1.0.0
 */
remove_action( 'edd_after_download_content', 'edd_append_purchase_link' );

/**
 * Alter EDD download loops.
 *
 * Affects:
 *
 * archive-download.php,
 * taxonomy-download-category.php
 * taxonomy-download-category.php
 *
 * @since 1.0.0
 * @since 1.0.3 Added support for all orderby options.
 *
 * @return void
 */

function digifly_edd_pre_get_posts( $query ) {

	// Get the download grid options.
	$download_grid_options = digifly_edd_download_grid_options();

	// Defaults to 9 downloads like EDD's [downloads] shortcode.
	$downloads_per_page = $download_grid_options['number'];

	// Get the order
	$order = $download_grid_options['order'];

	// Get the orderby
	$orderby = $download_grid_options['orderby'];

	switch ( $orderby ) {

		case 'price':
			$orderby = 'meta_value_num';
			break;

		case 'title':
			$orderby = 'title';
			break;

		case 'id':
			$orderby = 'ID';
			break;

		case 'random':
			$orderby = 'rand';
			break;

		case 'post__in':
			$orderby = 'post__in';
			break;

		default:
			$orderby = 'post_date';
			break;

	}

	// Bail if in the admin or we're not working with the main WP query.
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	// Set the number of downloads to show.
	if (
		is_post_type_archive( 'download' ) || // archive-download.php page
		is_tax( 'download_category' ) || // taxonomy-download-category.php
		is_tax( 'download_tag' )              // taxonomy-download-category.php
	) {

		// Set the number of downloads per page
		$query->set( 'posts_per_page', $downloads_per_page );

		// Set the order. ASC | DESC
		$query->set( 'order', $order );

		// Set meta_key query when ordering by price.
		if ( 'meta_value_num' === $orderby ) {
			$query->set( 'meta_key', 'edd_price' );
		}

		// Set the orderby.
		$query->set( 'orderby', $orderby );

	}
}

add_action( 'pre_get_posts', 'digifly_edd_pre_get_posts', 1 );

/**
 * Distraction Free Checkout
 *
 * @since  1.0.0
 *
 * @return void
 */
function digifly_edd_set_distraction_free_checkout() {

	/**
	 * Distraction Free Checkout
	 * Removes various distractions from the EDD checkout page to improve the customer's buying experience.
	 */
	if ( edd_is_checkout() && digifly_edd_distraction_free_checkout() && edd_get_cart_contents() ) {

		// Remove page header.
		add_filter( 'digifly_page_header', '__return_false' );

		// Remove the primary navigation.
		remove_action( 'digifly_site_header_main', 'digifly_primary_menu' );

		// Remove the primary navigation if moved to the digifly_site_header_wrap hook.
		remove_action( 'digifly_site_header_wrap', 'digifly_primary_menu' );

		// Remove the mobile menu.
		remove_action( 'digifly_site_header_main', 'digifly_menu_toggle' );

		// Remove the secondary menu.
		remove_action( 'digifly_site_header_wrap', 'digifly_secondary_menu' );

		// Remove the footer.
		remove_action( 'digifly_footer', 'digifly_footer_widgets' );

		// Remove the sidebar.
		add_filter( 'digifly_show_sidebar', '__return_false' );

		// Remove the custom header (if set)
		remove_action( 'digifly_header', 'digifly_header_image' );
	}
}
add_action( 'template_redirect', 'digifly_edd_set_distraction_free_checkout' );

function digifly_myreg_login() {
	if ( edd_can_checkout() ) {
		do_action( 'edd_purchase_form_before_register_login' );
		$show_register_form = edd_get_option( 'show_register_form', 'none' );
		?>
		<?php
		if ( ! is_user_logged_in() ) :
			if ( $show_register_form === 'login' || $show_register_form === 'both' ) :
				?>
				<div id="login" class="tab-pane fade in">
					<div id="edd_checkout_login" class="login_form">
						<?php do_action( 'edd_purchase_form_login_fields' ); ?>
						<?php
						do_action( '[login_form]' );
						?>
					</div>
				</div>
				<?php endif; ?>

				<?php if ( $show_register_form === 'registration' || $show_register_form === 'both' ) : ?>
				<div id="register" class="tab-pane fade ">
					<div id="edd_checkout_register" class="register_form">
						<?php do_action( 'edd_purchase_form_register_fields' ); ?>
					</div>
				</div>
				<?php endif; ?>
			<?php
		endif;
		// if( (  is_user_logged_in() ) || ! isset( $show_register_form ) || 'none' === $show_register_form || 'login' === $show_register_form ) {
			do_action( 'edd_purchase_form_after_user_info' );
		// }
	}
}
add_action( 'edd_checkout_form_top', 'digifly_myreg_login', -1 );

/**
 * Renders the Purchase Form, hooks are provided to add to the purchase form.
 * The default Purchase Form rendered displays a list of the enabled payment
 * gateways, a user registration form (if enable) and a credit card info form
 * if credit cards are enabled
 *
 * @since 1.4
 * @return string
 */
function digifly_show_purchase_form() {
	$payment_mode = edd_get_chosen_gateway();

	/**
	 * Hooks in at the top of the purchase form.
	 *
	 * @since 1.4
	 */
	do_action( 'edd_purchase_form_top' );

	// Maybe load purchase form.
	if ( edd_can_checkout() ) {

		/**
		 * Hooks in before the credit card form.
		 *
		 * @since 1.4
		 */
		do_action( 'edd_purchase_form_before_cc_form' );

		if ( edd_get_cart_total() > 0 ) {

			// Load the credit card form and allow gateways to load their own if they wish.
			if ( has_action( 'edd_' . $payment_mode . '_cc_form' ) ) {
				do_action( 'edd_' . $payment_mode . '_cc_form' );
			} else {
				do_action( 'edd_cc_form' );
			}
		}

		/**
		 * Hooks in after the credit card form.
		 *
		 * @since 1.4
		 */
		do_action( 'edd_purchase_form_after_cc_form' );

		// Can't checkout.
	} else {
		do_action( 'edd_purchase_form_no_access' );
	}

	/**
	 * Hooks in at the bottom of the purchase form.
	 *
	 * @since 1.4
	 */
	do_action( 'edd_purchase_form_bottom' );
}
add_action( 'edd_purchase_form', 'digifly_show_purchase_form', -1 );

/**
 * Renders the Checkout Submit section.
 *
 * @since 1.3.3
 */
function digifly_edd_checkout_submit() {
	?>
	<fieldset id="edd_purchase_submit">
		<?php //do_action( 'edd_purchase_form_before_submit' ); ?>

		<?php edd_checkout_hidden_fields(); ?>

		<?php echo edd_checkout_button_purchase(); ?>

		<?php do_action( 'edd_purchase_form_after_submit' ); ?>

		<?php if ( edd_is_ajax_disabled() ) : ?>
			<p class="edd-cancel"><a href="<?php echo esc_url( edd_get_checkout_uri() ); ?>"><?php esc_html_e( 'Go back', 'digifly' ); ?></a></p>
		<?php endif; ?>
	</fieldset>
	<?php
}
remove_action( 'edd_purchase_form_after_cc_form', 'edd_checkout_submit', 9999 );
add_action( 'edd_purchase_form_after_cc_form', 'digifly_edd_checkout_submit', 999 );

if ( class_exists( 'NextendSocialLogin' ) ) {
	/**
	 * Show Link/Unlink Buttons provided by Nextend Social Login on
	 * My Profile's Setings tab when the plugin is active
	 * */
	function digifly_add_nsl_login_buttons() {
		$settings = NextendSocialLogin::$settings;
		$settings->set( 'edd_checkout', '' );
		echo '<h2>' . esc_html__( 'My Social Login Accounts', 'digifly' ) . '</h2>';
		echo NextendSocialLogin::renderLinkAndUnlinkButtons(); // phpcs:ignore
	}
	add_action( 'edd_profile_editor_after', 'digifly_add_nsl_login_buttons' );

	/**
	 * Show Nextend Social Login Buttons in Hidden Login Container on
	 * Checkout Page
	 * */
	function digifly_show_nsl_login_on_checkout() {
		$settings = NextendSocialLogin::$settings;
		$settings->set( 'edd_checkout', '' );
		echo NextendSocialLogin::renderButtonsWithContainer(); // phpcs:ignore
	}
	add_action( 'edd_purchase_form_login_fields', 'digifly_show_nsl_login_on_checkout' );
}

<?php

/**
 * Note: Do not add any custom code here. Please use a child theme or custom functionality plugin so that your customizations are not lost during updates.
 * http://codex.wordpress.org/Child_Themes
 */

/**
 * DigiFly only works with WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/includes/back-compat.php';
	return;
}

/**
 * Constants
 *
 * @since 1.0.0
*/
if ( ! defined( 'DIGIFLY_VERSION' ) ) {
	define( 'DIGIFLY_VERSION', '1.3.5' );
}

if ( ! defined( 'DIGIFLY_AUTHOR' ) ) {
	define( 'DIGIFLY_AUTHOR', 'Plugins & Snippets' );
}

if ( ! defined( 'DIGIFLY_NAME' ) ) {
	define( 'DIGIFLY_NAME', 'DigiFly' );
}

if ( ! defined( 'DIGIFLY_INCLUDES_DIR' ) ) {
	define( 'DIGIFLY_INCLUDES_DIR', trailingslashit( get_template_directory() ) . 'includes' );
}

if ( ! defined( 'DIGIFLY_THEME_URL' ) ) {
	define( 'DIGIFLY_THEME_URL', trailingslashit( get_template_directory_uri() ) );
}

if ( ! defined( 'DIGIFLY_SUBSCRIBE_URL' ) ) {
	define( 'DIGIFLY_SUBSCRIBE_URL', 'https://www.pluginsandsnippets.com/?ps-subscription-request=1' );
}

if ( ! defined( 'DIGIFLY_PS_PROMOTION_ITEMS' ) ) {
	define(
		'DIGIFLY_PS_PROMOTION_ITEMS',
		array(
			array(
				'title'        => 'Freelancer Marketplace',
				'url'          => 'https://www.pluginsandsnippets.com/downloads/freelancer-marketplace-plugin/',
				'image'        => DIGIFLY_THEME_URL . 'assets/images/promotions/freelance-market-plugin.jpg',
				'description'  => 'will transform your WordPress website into a freelancer marketplace. It allows customers to submit projects and freelancers to find work. The plugin includes a project submission process, bidding system, workflows for file uploads, messaging, and various other features to operate a comprehensive freelancer marketplace in WordPress.',
				'initial_link' => true,
			),
			array(
				'title'        => 'UpsellMaster',
				'url'          => 'https://www.pluginsandsnippets.com/downloads/upsellmaster/',
				'image'        => DIGIFLY_THEME_URL . 'assets/images/promotions/upsell-master-image.png',
				'description'  => 'uses a data-driven algorithm to automatically calculate the most suitable Upsells for each product via a 1-click calculate all button. Presenting the most suitable Upsells at the right places normally enhances the sales of your WooCommerce or Easy Digital Downloads webstore. These tailored Upsells are then displayed on the Product Page, Checkout Page, and Purchase Receipt Pages or can be added via widget, shortcode, or Gutenberg block on any page of your webstore. The plugin offers a flexible algorithm where you can quickly change the criteria on how to calculate your most suitable Upsells. The plugin also tracks the sales results from Upsells and also offers to show Recently Viewed Products as well.',
				'initial_link' => true,
			),
			array(
				'title'        => 'EDD Advanced Shortcodes',
				'url'          => 'https://www.pluginsandsnippets.com/downloads/edd-advanced-shortcodes/',
				'image'        => DIGIFLY_THEME_URL . 'assets/images/promotions/eas-plugin.png',
				'description'  => 'plugin provides enhanced shortcodes to easily create lists and carousels of products, reviews, and authors for Easy Digital Downloads Webstores. These shortcodes come with an extensive number of attributes that allow presenting your products at nearly unlimited possibilities. You can use the shortcodes to insert into your blog posts, your knowledge page, or even create a rich demonstration page of all types of products your Easy Digital Downloads store contains. Furthermore, the plugin also manages to show sales notification popup messages which add credibility to your webstore.',
				'initial_link' => true,
			),
			array(
				'title'        => 'EDD Landing Pages for Categories and Tags',
				'url'          => 'https://www.pluginsandsnippets.com/downloads/edd-landing-pages-for-categories-and-tags/',
				'image'        => DIGIFLY_THEME_URL . 'assets/images/promotions/edd-landing-pages-plugin.png',
				'description'  => 'turns the category and tag pages of your Easy Digital Downloads webstore into feature-rich landing pages. Download Category and Tag pages now can show a featured image, text above and below the list of products, and add images and formatting to your text. The plugin also enhances the number of columns and products to be displayed per page and adds quick sorting options. Furthermore, the plugin also includes a variety of shortcodes to show your categories in the form of product carousels or lists in blog posts or even create a directory of all your categories and tags. This is a great plugin to add if you seek to enhance the user experience and site navigation for your Easy Digital Downloads webstore.',
				'initial_link' => true,
			),
			array(
				'title'        => 'eBook: How to Build a Digital Product Marketplace',
				'url'          => 'https://www.pluginsandsnippets.com/downloads/how-to-build-a-digital-product-marketplace-in-wordpress/',
				'image'        => DIGIFLY_THEME_URL . 'assets/images/promotions/ebook-digital-product-marketplace.png',
				'description'  => '<p>Before you actually start building a digital product marketplace, it is very important to know all these necessary details and information. Starting from reasons to start a digital marketplace, concepts and strategies to apply, setting up, installing a marketplace theme and specific plugins, sourcing vendors, marketing campaigns, operating the marketplace, and other important things to consider.</p><p>Now, here we offer a <a target="_blank" href="https://www.pluginsandsnippets.com/downloads/how-to-build-a-digital-product-marketplace-in-wordpress/">comprehensive eBook</a> on how to set up and operate a digital product marketplace with Easy Digital Downloads in WordPress. We went through everything you need to know about developing your idea into a good digital product marketplace, offering lots of practical advice, tips, and strategies along the way.</p>',
				'initial_link' => false,
			),
			array(
				'title'        => 'How To Effectively Upsell On Your Website?',
				'url'          => 'https://www.pluginsandsnippets.com/downloads/how-to-effectively-upsell-on-your-website-a-guide-for-woocommerce-and-easy-digital-downloads/',
				'image'        => DIGIFLY_THEME_URL . 'assets/images/promotions/ebook-upsell-website-guide.png',
				'description'  => '<p>Upselling is a sales tactic that involves persuading customers to buy a more expensive, upgraded, or premium version of a purchased item or other things in order to increase the size of the sale. Upsells placed at key points in the customer journey can assist in increased purchase quantities and many more advantages for your webstore.</p><p>This <a target="_blank" href="https://www.pluginsandsnippets.com/downloads/how-to-effectively-upsell-on-your-website-a-guide-for-woocommerce-and-easy-digital-downloads/">eBook</a> for WooCommerce and Easy Digital Downloads store will help you get to know more about Upselling, Benefits, Tips, the Best Time to Upsell, Signs why your Upselling isn’t working, and most of all the 10 best Upsell Plugins for WordPress in 2022.</p><p>You’re wasting money if you’re not using upselling and cross-selling in your firm. Offer appropriate items to your clients to ensure that they obtain the entire spectrum of your services and that you get the highest return on investment. Download this FREE eBook now!</p>',
				'initial_link' => false,
			),
		)
	);
}
/**
 * Includes
 *
 * @since 1.0.0
*/
require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'setup.php';
require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'class-digifly.php';
require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'functions.php';
require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'scripts.php';
require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'template-tags.php';
require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'header.php';
require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'footer.php';
require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'actions.php';
require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'filters.php';
require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'customizer.php';
require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'compatibility.php';
require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'class-digifly-search.php';
require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'admin/theme-options.php';
require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'woocommerce.php';

remove_action( 'edd_purchase_form', 'edd_show_purchase_form' );

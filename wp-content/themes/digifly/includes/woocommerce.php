<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'woocommerce' ) ) :

	function digifly_remove_sidebar_from_tags_cats() {
		if ( is_product_category() || is_product_tag() || ( is_shop() && digifly_woocommerce_shop_template() === 'full' ) ) {
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		}
	}
	add_action( 'woocommerce_before_main_content', 'digifly_remove_sidebar_from_tags_cats' );


	function digifly_remove_default_sidebar_from_tags_cats( $show ) {
		if ( is_product_category() || is_product_tag() || ( is_shop() && digifly_woocommerce_shop_template() === 'full' ) ) {
			$show = false;
		}
		return $show;
	}
	add_filter( 'digifly_show_sidebar', 'digifly_remove_default_sidebar_from_tags_cats' );


	function digifly_woocommerce_shop_template() {
		$theme_options = get_theme_mod( 'theme_options' );
		if ( ! isset( $theme_options['shop_template'] ) || empty( $theme_options['shop_template'] ) ) {
			$theme_options['shop_template'] = 'sidebar';
		}

		return apply_filters( 'digifly_woocommerce_shop_template_name', $theme_options['shop_template'] );
	}

	function digifly_add_nosidebar_class_for_fullwidth_shop( $classes ) {
		if ( ! is_shop() ) {
			return $classes;
		}

		if ( digifly_woocommerce_shop_template() === 'full' ) {
			$classes[] = 'no-sidebar';
		}

		return $classes;
	}
	add_filter( 'body_class', 'digifly_add_nosidebar_class_for_fullwidth_shop', 100 );

endif;

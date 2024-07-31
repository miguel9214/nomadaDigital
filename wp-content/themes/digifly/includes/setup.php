<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * DigiFly setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since 1.0
 */
if ( ! function_exists( 'digifly_setup' ) ) :

	function digifly_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on digifly, use a find and replace
		 * to change 'digifly' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'digifly', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// This theme styles the visual editor to resemble the theme style.
		add_editor_style( 'css/editor-style.css' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'customize-selective-refresh-widgets' );

		digifly_set_post_thumbnail_size();

		// Register menus
		register_nav_menus(
			array(
				'primary'   => __( 'Primary Menu', 'digifly' ),
				'secondary' => __( 'Secondary Menu', 'digifly' ),
				'mobile'    => __( 'Mobile Menu', 'digifly' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/**
		 * Enable support for custom logo
		 *
		 * @since 1.0.0
		 */
		add_theme_support(
			'custom-logo',
			array(
				'width'       => 250,
				'height'      => 50,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_image_size( 'digifly-download-grid', 300, 150, true );
		add_image_size( 'digifly-blog-grid', 500, 250, true );
	}
endif;
add_action( 'after_setup_theme', 'digifly_setup' );

/**
 * Set the post thumbnail size (aka featured image)
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'digifly_set_post_thumbnail_size' ) ) :
	function digifly_set_post_thumbnail_size() {
		set_post_thumbnail_size( 991, 9999 );
	}
endif;

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function digifly_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'digifly_content_width', 991 );
}
add_action( 'after_setup_theme', 'digifly_content_width', 0 );

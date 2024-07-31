<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since DigiFly 1.0.0
 */
function digifly_custom_header() {

	// Get the default colors to compare against.
	$defaults = digifly_customize_color_defaults();

	/**
	 * Filter the arguments used when adding 'custom-background' support in Digifly
	 *
	 * @since 1.0.0
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 * @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support(
		'custom-background',
		apply_filters(
			'digifly_customize_custom_background_args',
			array(
				'default-color' => $defaults['background_color'],
			)
		)
	);

	/**
	 * Filter the arguments used when adding 'custom-header' support in Digifly
	 *
	 * @since DigiFly 1.0.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type int      $width            Width in pixels of the custom header image. Default 1480.
	 *     @type int      $flex-width       Whether to allow flexible-width header images. Default true.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
	add_theme_support(
		'custom-header',
		apply_filters(
			'digifly_customize_custom_header_args',
			array(
				'flex-width'       => true,
				'width'            => 1480, // Recommended width.
				'flex-height'      => true,
				'height'           => 280, // Recommended height.
				'wp-head-callback' => 'digifly_header_style',
			)
		)
	);
}
add_action( 'after_setup_theme', 'digifly_custom_header' );


/**
 * Set default colors
 *
 * @since 1.0.0
 *
 * @return array $defaults
 */
function digifly_customize_color_defaults() {

	$light_grey   = '#f5f5f5';
	$dark_grey    = '#222222';
	$medium_grey  = '#a2a2a2';
	$white        = '#ffffff';
	$body         = '#696969';
	$primary      = '#448fd5';
	$button_hover = '#2f83d0';
	$link_hover   = '#215b92';

	$defaults = array(
		'background_color'                          => $white,
		'header_background_color'                   => $white,
		'header_textcolor'                          => $dark_grey,
		'header_search_background_color'            => $light_grey,
		'header_search_text_color'                  => $body,
		'header_search_icon_color'                  => $body,
		'site_title_color'                          => $dark_grey,
		'menu_primary_sub_background_hover_color'   => '',
		'menu_primary_sub_background_color'         => $dark_grey,
		'link_color'                                => $primary,
		'link_hover_color'                          => $link_hover,
		'menu_primary_sub_background_active_color'  => '',
		'menu_primary_sub_link_color'               => $medium_grey,
		'menu_primary_sub_link_hover_color'         => $white,
		'menu_primary_sub_link_active_color'        => $white,
		'menu_secondary_link_color'                 => $body,
		'menu_secondary_link_hover_color'           => $dark_grey,
		'menu_primary_background_color'             => '',
		'menu_primary_link_color'                   => $body,
		'menu_primary_link_hover_color'             => $dark_grey,
		'menu_primary_link_background_hover_color'  => '',
		'menu_primary_link_background_active_color' => '',
		'menu_primary_link_active_color'            => $dark_grey,
		'mobile_cart_icon_color'                    => $dark_grey,
		'tagline_color'                             => $medium_grey,
		'cart_icon_color'                           => $dark_grey,
		'button_background_color'                   => $primary,
		'button_background_hover_color'             => $button_hover,
		'button_text_color'                         => $white,
		'button_text_hover_color'                   => $white,
		'menu_mobile_button_background_color'       => $white,
		'menu_mobile_background_color'              => '',
		'menu_mobile_link_color'                    => $dark_grey,
		'menu_mobile_button_text_color'             => $primary,
		'menu_mobile_search_background_color'       => $light_grey,
		'menu_mobile_search_text_color'             => $body,
		'menu_mobile_search_icon_color'             => $body,
		'footer_background_color'                   => $white,
		'footer_text_color'                         => $medium_grey,
		'footer_link_color'                         => $medium_grey,
		'footer_heading_color'                      => $dark_grey,
		'footer_link_hover_color'                   => $dark_grey,
		'footer_site_info_color'                    => $medium_grey,
	);

	return apply_filters( 'digifly_customize_color_defaults', $defaults );
}

if ( ! function_exists( 'digifly_header_style' ) ) :
	/**
	 * Styles the header text displayed on the site.
	 *
	 * Create your own digifly_header_style() function to override in a child theme.
	 *
	 * @since DigiFly 1.0.0
	 *
	 * @see digifly_custom_header().
	 */
	function digifly_header_style() {

		// Get the header text color.
		$text_color = get_header_textcolor();

		// Get the default colors to compare against.
		$defaults = digifly_customize_color_defaults();

		// If no custom color for text is set, let's bail.
		if ( display_header_text() && $text_color === get_theme_support( 'custom-header', 'default-text-color' ) ) {
			return;
		}

		?>

		<style type="text/css" id="digifly-header-css">
			<?php
				// Has the text been hidden?
			if ( ! display_header_text() ) :
				?>
			.site-branding .site-title,
			.site-description {
				clip: rect(1px, 1px, 1px, 1px);
				position: absolute;
			}
				<?php
				// If the user has set a custom color for the text, use that.
				elseif ( $text_color !== get_theme_support( 'custom-header', 'default-text-color' ) && ( '#' . $text_color !== $defaults['header_textcolor'] ) ) :
					?>
				.site-title a, .site-title a:hover { color: #<?php echo esc_attr( $text_color ); ?>; }
			<?php endif; ?>
		</style>

		<?php
	}
endif;

/**
 * Bind JS handlers to instantly live-preview changes.
 *
 * @since 1.0.0
 */
function digifly_customize_preview_js() {
	wp_enqueue_script( 'digifly-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview' ), DIGIFLY_VERSION, true );

	wp_localize_script( 'digifly-customize-preview', 'defaults', digifly_customize_color_defaults() );

	wp_enqueue_style( 'digifly-customize-preview', get_theme_file_uri( '/assets/css/customize-preview.css' ), array(), DIGIFLY_VERSION );
}
add_action( 'customize_preview_init', 'digifly_customize_preview_js' );


/**
 * Adds postMessage support for site title and description for the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function digifly_customize_register( $wp_customize ) {

	require_once trailingslashit( DIGIFLY_INCLUDES_DIR ) . 'class-digifly-wp-customizer-typo-control.php';

	$wp_customize->register_control_type( 'Digifly_WP_Customizer_Typo_Control' );

	// Default colors.
	$defaults = digifly_customize_color_defaults();

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {

		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'            => '.site-title a',
				'container_inclusive' => false,
				'render_callback'     => 'digifly_customize_partial_blogname',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'            => '.site-description',
				'container_inclusive' => false,
				'render_callback'     => 'digifly_customize_partial_blogdescription',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'easy_digital_downloads[cart_icon]',
			array(
				'selector'            => '.navCart-icon',
				'container_inclusive' => true,
				'render_callback'     => 'digifly_customize_partial_cart_icon',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'easy_digital_downloads[cart_options]',
			array(
				'selector'            => '.navCart-cartQuantityAndTotal',
				'container_inclusive' => true,
				'render_callback'     => 'digifly_customize_partial_cart_options',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'theme_options[header_search]',
			array(
				'selector'            => array( '.site-header-menu .search-form', '#mobile-menu .menu-item-search' ),
				'container_inclusive' => true,
				'render_callback'     => 'digifly_customize_partial_header_search',
			)
		);

	}

	// Rename the label to "Site Title Color" because this only affects the site title in this theme.
	$wp_customize->get_control( 'header_textcolor' )->label = __( 'Site Title Color', 'digifly' );

	// Add a description to the Site Title Color.
	$wp_customize->get_control( 'header_textcolor' )->description = __( 'The color of the site title.', 'digifly' );

	// Move the Site Title color to the "Header" section of the "colors" panel
	$wp_customize->get_control( 'header_textcolor' )->section = 'header_colors';

	// Set the default color of the Site Title setting.
	$wp_customize->get_setting( 'header_textcolor' )->default = $defaults['header_textcolor'];

	// Add a description to the "Background Color".
	$wp_customize->get_control( 'background_color' )->description = __( 'The color of the site\'s background.', 'digifly' );

	// Move the Background color to the "General" section of the "colors" panel
	$wp_customize->get_control( 'background_color' )->section = 'general_colors';

	// Set the default color of the Background Color setting.
	$wp_customize->get_setting( 'background_color' )->default = $defaults['background_color'];

	// Tagline color.
	$wp_customize->add_setting(
		'colors[tagline_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['tagline_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'tagline_color',
			array(
				'label'       => __( 'Tagline Color', 'digifly' ),
				'description' => __( 'The color of the site tagline (if set).', 'digifly' ),
				'section'     => 'header_colors',
				'settings'    => 'colors[tagline_color]',
			)
		)
	);

	/**
	 * Add (actually replaces) the "Colors" section
	 */
	$wp_customize->add_panel(
		'colors',
		array(
			'priority'        => 21,
			'capability'      => 'edit_theme_options',
			'theme_supports'  => '',
			'title'           => __( 'Colors', 'digifly' ),
			'active_callback' => 'digifly_customize_color_options',
		)
	);

	/**
	 * Add the "general" colors section
	 */
	$wp_customize->add_section(
		'general_colors',
		array(
			'priority'       => 10,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'General', 'digifly' ),
			'panel'          => 'colors',
		)
	);

	/**
	 * Add the "Header" colors section
	 */
	$wp_customize->add_section(
		'header_colors',
		array(
			'priority'       => 10,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Header', 'digifly' ),
			'panel'          => 'colors',
		)
	);

	/**
	 * Add the "Footer" colors section
	 */
	$wp_customize->add_section(
		'footer_colors',
		array(
			'priority'       => 10,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Footer', 'digifly' ),
			'panel'          => 'colors',
		)
	);

	/**
	 * Add the "Mobile Menu" colors section
	 */
	$wp_customize->add_section(
		'mobile_device_colors',
		array(
			'priority'       => 10,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Mobile Devices', 'digifly' ),
			'panel'          => 'colors',
		)
	);

	// Header background color.
	$wp_customize->add_setting(
		'colors[header_background_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['header_background_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_background_color',
			array(
				'label'       => __( 'Header Background Color', 'digifly' ),
				'description' => __( 'The background color of the site header.', 'digifly' ),
				'settings'    => 'colors[header_background_color]',
				'section'     => 'header_colors',
			)
		)
	);

	/**
	 * Primary menu
	 */

	// Primary menu background color.
	$wp_customize->add_setting(
		'colors[menu_primary_background_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_primary_background_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_primary_background_color',
			array(
				'label'       => __( 'Primary Menu Background Color', 'digifly' ),
				'description' => __( 'The background color of the primary menu.', 'digifly' ),
				'settings'    => 'colors[menu_primary_background_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Primary menu link color.
	$wp_customize->add_setting(
		'colors[menu_primary_link_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_primary_link_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_primary_link_color',
			array(
				'label'       => __( 'Primary Menu Link Color', 'digifly' ),
				'description' => __( 'The color of primary menu links.', 'digifly' ),
				'settings'    => 'colors[menu_primary_link_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Primary menu link hover color.
	$wp_customize->add_setting(
		'colors[menu_primary_link_hover_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_primary_link_hover_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_primary_link_hover_color',
			array(
				'label'       => __( 'Primary Menu Link Hover Color', 'digifly' ),
				'description' => __( 'The hover color of primary menu links.', 'digifly' ),
				'settings'    => 'colors[menu_primary_link_hover_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Primary menu link active color.
	$wp_customize->add_setting(
		'colors[menu_primary_link_active_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_primary_link_active_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_primary_link_active_color',
			array(
				'label'       => __( 'Primary Menu Link Active Color', 'digifly' ),
				'description' => __( 'The active color of primary menu links.', 'digifly' ),
				'settings'    => 'colors[menu_primary_link_active_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Primary menu link background hover color.
	$wp_customize->add_setting(
		'colors[menu_primary_link_background_hover_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_primary_link_background_hover_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_primary_link_background_hover_color',
			array(
				'label'       => __( 'Primary Menu Link Background Hover Color', 'digifly' ),
				'description' => __( 'The background hover color of primary menu links.', 'digifly' ),
				'settings'    => 'colors[menu_primary_link_background_hover_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Primary menu link background active color.
	$wp_customize->add_setting(
		'colors[menu_primary_link_background_active_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_primary_link_background_active_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_primary_link_background_active_color',
			array(
				'label'       => __( 'Primary Menu Link Background Active Color', 'digifly' ),
				'description' => __( 'The background active color of primary menu links.', 'digifly' ),
				'settings'    => 'colors[menu_primary_link_background_active_color]',
				'section'     => 'header_colors',
			)
		)
	);

	/**
	 * Sub-menu
	 */

	// Primary sub-menu link color.
	$wp_customize->add_setting(
		'colors[menu_primary_sub_link_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_primary_sub_link_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_primary_sub_link_color',
			array(
				'label'       => __( 'Primary Sub-menu Link Color', 'digifly' ),
				'description' => __( 'The color of primary sub-menu links.', 'digifly' ),
				'settings'    => 'colors[menu_primary_sub_link_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Primary sub-menu link hover color.
	$wp_customize->add_setting(
		'colors[menu_primary_sub_link_hover_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_primary_sub_link_hover_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_primary_sub_link_hover_color',
			array(
				'label'       => __( 'Primary Sub-menu Link Hover Color', 'digifly' ),
				'description' => __( 'The hover color of primary sub-menu links.', 'digifly' ),
				'settings'    => 'colors[menu_primary_sub_link_hover_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Primary sub-menu link active color.
	$wp_customize->add_setting(
		'colors[menu_primary_sub_link_active_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_primary_sub_link_active_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_primary_sub_link_active_color',
			array(
				'label'       => __( 'Primary Sub-menu Link Active Color', 'digifly' ),
				'description' => __( 'The active color of primary sub-menu links.', 'digifly' ),
				'settings'    => 'colors[menu_primary_sub_link_active_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Primary sub-menu background color.
	$wp_customize->add_setting(
		'colors[menu_primary_sub_background_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_primary_sub_background_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_primary_sub_background_color',
			array(
				'label'       => __( 'Primary Sub-menu Background Color', 'digifly' ),
				'description' => __( 'The background color of primary sub-menus.', 'digifly' ),
				'settings'    => 'colors[menu_primary_sub_background_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Primary sub-menu link background hover color.
	$wp_customize->add_setting(
		'colors[menu_primary_sub_background_hover_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_primary_sub_background_hover_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_primary_sub_background_hover_color',
			array(
				'label'       => __( 'Primary Sub-menu Background Hover Color', 'digifly' ),
				'description' => __( 'The background hover color of primary sub-menu links.', 'digifly' ),
				'settings'    => 'colors[menu_primary_sub_background_hover_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Primary sub-menu link background active color.
	$wp_customize->add_setting(
		'colors[menu_primary_sub_background_active_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_primary_sub_background_active_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_primary_sub_background_active_color',
			array(
				'label'       => __( 'Primary Sub-menu Background Active Color', 'digifly' ),
				'description' => __( 'The background active color of primary sub-menu links.', 'digifly' ),
				'settings'    => 'colors[menu_primary_sub_background_active_color]',
				'section'     => 'header_colors',
			)
		)
	);

	/**
	 * Secondary menu
	 */

	// Secondary menu link color.
	$wp_customize->add_setting(
		'colors[menu_secondary_link_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_secondary_link_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_secondary_link_color',
			array(
				'label'       => __( 'Secondary Menu Link Color', 'digifly' ),
				'description' => __( 'The color of secondary menu links.', 'digifly' ),
				'settings'    => 'colors[menu_secondary_link_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Secondary menu link hover/active color.
	$wp_customize->add_setting(
		'colors[menu_secondary_link_hover_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_secondary_link_hover_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_secondary_link_hover_color',
			array(
				'label'       => __( 'Secondary Menu Link Hover', 'digifly' ),
				'description' => __( 'The hover color of secondary menu links.', 'digifly' ),
				'settings'    => 'colors[menu_secondary_link_hover_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Link color.
	$wp_customize->add_setting(
		'colors[link_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['link_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_color',
			array(
				'label'       => __( 'Link Color', 'digifly' ),
				'description' => __( 'The color of general links.', 'digifly' ),
				'section'     => 'general_colors',
				'settings'    => 'colors[link_color]',
			)
		)
	);

	// Link hover color.
	$wp_customize->add_setting(
		'colors[link_hover_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['link_hover_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_hover_color',
			array(
				'label'       => __( 'Link Hover Color', 'digifly' ),
				'description' => __( 'The hover color of general links.', 'digifly' ),
				'section'     => 'general_colors',
				'settings'    => 'colors[link_hover_color]',
			)
		)
	);

	// Button background color.
	$wp_customize->add_setting(
		'colors[button_background_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['button_background_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'button_background_color',
			array(
				'label'       => __( 'Button Background Color', 'digifly' ),
				'description' => __( 'The background color of buttons.', 'digifly' ),
				'settings'    => 'colors[button_background_color]',
				'section'     => 'general_colors',
			)
		)
	);

	// Button background hover color.
	$wp_customize->add_setting(
		'colors[button_background_hover_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['button_background_hover_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'button_background_hover_color',
			array(
				'label'       => __( 'Button Background Hover Color', 'digifly' ),
				'description' => __( 'The background hover color of buttons.', 'digifly' ),
				'settings'    => 'colors[button_background_hover_color]',
				'section'     => 'general_colors',
			)
		)
	);

	// Button text color.
	$wp_customize->add_setting(
		'colors[button_text_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['button_text_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'button_text_color',
			array(
				'label'       => __( 'Button Text Color', 'digifly' ),
				'description' => __( 'The button text color.', 'digifly' ),
				'settings'    => 'colors[button_text_color]',
				'section'     => 'general_colors',
			)
		)
	);

	// Button text hover color.
	$wp_customize->add_setting(
		'colors[button_text_hover_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['button_text_hover_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'button_text_hover_color',
			array(
				'label'       => __( 'Button Text Hover Color', 'digifly' ),
				'description' => __( 'The button text hover color.', 'digifly' ),
				'settings'    => 'colors[button_text_hover_color]',
				'section'     => 'general_colors',
			)
		)
	);

	/**
	 * Easy Digital Downloads section
	 */
	$wp_customize->add_section(
		'easy_digital_downloads',
		array(
			'title'           => __( 'Easy Digital Downloads', 'digifly' ),
			'priority'        => 22,
			'active_callback' => 'digifly_is_edd_active',
		)
	);

	if ( digifly_is_edd_active() ) {
		/**
		* "Restrict Header Search" setting
		*/
		$wp_customize->add_setting(
			'easy_digital_downloads[restrict_header_search]',
			array(
				'sanitize_callback' => 'digifly_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'restrict_header_search',
			array(
				'label'       => __( 'Restrict Header Search', 'digifly' ),
				'settings'    => 'easy_digital_downloads[restrict_header_search]',
				'section'     => 'easy_digital_downloads',
				'type'        => 'checkbox',
				'description' => sprintf( esc_html__( 'If enabled, the header search will only search %s. Requires the "Header Search" option from Theme Options to be enabled.', 'digifly' ), strtolower( edd_get_label_plural() ) ),
			)
		);

		/**
		* Distraction Free Checkout setting
		*/
		$wp_customize->add_setting(
			'easy_digital_downloads[distraction_free_checkout]',
			array(
				'sanitize_callback' => 'digifly_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'distraction_free_checkout',
			array(
				'label'       => __( 'Distraction Free Checkout', 'digifly' ),
				'settings'    => 'easy_digital_downloads[distraction_free_checkout]',
				'section'     => 'easy_digital_downloads',
				'type'        => 'checkbox',
				'description' => __( 'Header menus, footer widgets and sidebars will all be removed from checkout, allowing customers to complete their purchase with no distractions.', 'digifly' ),
			)
		);
	}

	/**
	 * Frontend Submissions - Display vendor contact form
	*/
	if ( digifly_is_edd_fes_active() ) {
		$wp_customize->add_setting(
			'easy_digital_downloads[fes_vendor_contact_form]',
			array(
				'sanitize_callback' => 'digifly_sanitize_checkbox',
				'default'           => true,
			)
		);

		$wp_customize->add_control(
			'fes_vendor_contact_form',
			array(
				'label'       => __( 'Display Vendor Contact Form', 'digifly' ),
				'settings'    => 'easy_digital_downloads[fes_vendor_contact_form]',
				'section'     => 'easy_digital_downloads',
				'type'        => 'checkbox',
				'description' => __( 'Display the vendor contact form on the vendor page.', 'digifly' ),
			)
		);
	}

	$wp_customize->add_panel(
		'typography',
		array(
			'priority' => 5,
			'title'    => esc_html__( 'Typography', 'digifly' ),
		)
	);

	$typography_sections = array(
		'body_typography'     => esc_html__( 'Body', 'digifly' ),
		'p_typography'        => esc_html__( 'Paragraphs', 'digifly' ),
		'headings_typography' => esc_html__( 'Headings', 'digifly' ),
	);

	foreach ( $typography_sections as $typo_section => $typo_section_name ) {
		$wp_customize->add_section(
			$typo_section,
			array(
				'panel' => 'typography',
				'title' => $typo_section_name,
			)
		);

		// Headings are created in single group
		if ( $typo_section == 'headings_typography' ) {
			continue;
		}

		$wp_customize->add_setting(
			$typo_section . '_font_family',
			array(
				'default'           => 'Montserrat',
				'sanitize_callback' => 'esc_attr',
			)
		);
		$wp_customize->add_setting(
			$typo_section . '_font_weight',
			array(
				'default'           => '400',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_setting(
			$typo_section . '_font_style',
			array(
				'default'           => 'normal',
				'sanitize_callback' => 'esc_attr',
			)
		);
		$wp_customize->add_setting(
			$typo_section . '_font_size',
			array(
				'default'           => '16',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_setting(
			$typo_section . '_line_height',
			array(
				'default'           => '32',
				'sanitize_callback' => 'absint',
			)
		);
	}

	for ( $heading_level = 1; $heading_level <= 6; $heading_level++ ) {
		$heading_font_family = 'h' . $heading_level . '_font_family';
		$heading_font_weight = 'h' . $heading_level . '_font_weight';
		$heading_font_style  = 'h' . $heading_level . '_font_style';
		$heading_font_size   = 'h' . $heading_level . '_font_size';

		$wp_customize->add_setting(
			$heading_font_family,
			array(
				'default'           => 'Montserrat',
				'sanitize_callback' => 'esc_attr',
			)
		);

		$wp_customize->add_setting(
			$heading_font_weight,
			array(
				'default'           => '700',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_setting(
			$heading_font_style,
			array(
				'default'           => 'normal',
				'sanitize_callback' => 'esc_attr',
			)
		);

		$wp_customize->add_setting(
			$heading_font_size,
			array(
				'default'           => '',
				'sanitize_callback' => 'intval',
			)
		);
	}

	foreach ( $typography_sections as $typo_section => $typo_section_name ) {
		if ( $typo_section == 'headings_typography' ) {
			continue;
		}

		$wp_customize->add_control(
			new Digifly_WP_Customizer_Typo_Control(
				$wp_customize,
				$typo_section . '_id',
				array(
					'label'       => esc_html__( 'Paragraph Typography', 'digifly' ),
					'description' => __( 'Select how you want your paragraphs to appear.', 'digifly' ),
					'section'     => $typo_section,

					// Tie a setting (defined via `$wp_customize->add_setting()`) to the control.
					'settings'    => array(
						'family'      => $typo_section . '_font_family',
						'weight'      => $typo_section . '_font_weight',
						'style'       => $typo_section . '_font_style',
						'size'        => $typo_section . '_font_size',
						'line_height' => $typo_section . '_line_height',
					),

					// Pass custom labels. Use the setting key (above) for the specific label.
					'l10n'        => array(),
				)
			)
		);
	}

	for ( $heading_level = 1; $heading_level <= 6; $heading_level++ ) {
		$heading_typography_id = 'h' . $heading_level . '_typography_id';
		$heading_font_family   = 'h' . $heading_level . '_font_family';
		$heading_font_weight   = 'h' . $heading_level . '_font_weight';
		$heading_font_style    = 'h' . $heading_level . '_font_style';
		$heading_font_size     = 'h' . $heading_level . '_font_size';

		$wp_customize->add_control(
			new Digifly_WP_Customizer_Typo_Control(
				$wp_customize,
				$heading_typography_id,
				array(
					'label'       => sprintf( esc_html__( 'Heading %s', 'digifly' ), $heading_level ),
					'description' => sprintf( esc_html__( 'Select how you want your heading %s to appear', 'digifly' ), $heading_level ),
					'section'     => 'headings_typography',

					// Tie a setting (defined via `$wp_customize->add_setting()`) to the control.
					'settings'    => array(
						'family' => $heading_font_family,
						'weight' => $heading_font_weight,
						'style'  => $heading_font_style,
						'size'   => $heading_font_size,
					),

					// Pass custom labels. Use the setting key (above) for the specific label.
					'l10n'        => array(),
				)
			)
		);
	}

	if ( digifly_is_edd_active() ) {
		/**
		* Cart icon setting
		*/
		$wp_customize->add_setting(
			'easy_digital_downloads[cart_icon]',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'digifly_sanitize_checkbox',
				'default'           => true,
			)
		);

		$wp_customize->add_control(
			'cart_icon',
			array(
				'label'    => __( 'Display Cart Icon', 'digifly' ),
				'settings' => 'easy_digital_downloads[cart_icon]',
				'section'  => 'easy_digital_downloads',
				'type'     => 'checkbox',

			)
		);

		/**
		* Downloads Layout
		*/
		$wp_customize->add_setting(
			'easy_digital_downloads[archive_layout]',
			array(
				'transport'         => 'postMessage',
				'default'           => 'grid',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'archive_layout',
			array(
				'label'       => __( 'Products Layout', 'digifly' ),
				'description' => __( 'Controls the layout on archives and shortcodes.', 'digifly' ),
				'settings'    => 'easy_digital_downloads[archive_layout]',
				'section'     => 'easy_digital_downloads',
				'type'        => 'select',
				'choices'     => array(
					'list' => __( 'List View', 'digifly' ),
					'grid' => __( 'Grid View', 'digifly' ),
				),
			)
		);

		$wp_customize->add_setting(
			'easy_digital_downloads[show_featured_image]',
			array(
				'transport'         => 'postMessage',
				'default'           => 'grid',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'show_featured_image',
			array(
				'label'       => __( 'Show/Hide Featured Image on Download Pages', 'digifly' ),
				'description' => __( 'Controls visibility of Featured Image on Download Details page.', 'digifly' ),
				'settings'    => 'easy_digital_downloads[show_featured_image]',
				'section'     => 'easy_digital_downloads',
				'type'        => 'select',
				'default'     => 'show',
				'choices'     => array(
					'show' => __( 'Show', 'digifly' ),
					'hide' => __( 'Hide', 'digifly' ),
				),
			)
		);

		/**
		* Cart options setting
		*/
		$wp_customize->add_setting(
			'easy_digital_downloads[cart_options]',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'digifly_sanitize_cart_options',
				'default'           => 'all',
			)
		);

		$wp_customize->add_control(
			'cart_options',
			array(
				'label'       => __( 'Item Quantity and Cart Total', 'digifly' ),
				'description' => __( 'Display either the item quantity or cart total, both the item quantity and cart total, or nothing at all.', 'digifly' ),
				'settings'    => 'easy_digital_downloads[cart_options]',
				'section'     => 'easy_digital_downloads',
				'type'        => 'select',
				'choices'     => digifly_customize_cart_options(),
			)
		);

		/**
		* Custom Post Type Archive page title.
		* This option does not show if the archive page has been disabled.
		*/
		if ( ! ( defined( 'EDD_DISABLE_ARCHIVE' ) && true === EDD_DISABLE_ARCHIVE ) ) {

			$wp_customize->add_setting(
				'easy_digital_downloads[post_type_archive_title]',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$slug = defined( 'EDD_SLUG' ) ? EDD_SLUG : 'downloads';

			$wp_customize->add_control(
				'post_type_archive_title',
				array(
					'label'       => __( 'Custom Post Type Archive Title', 'digifly' ),
					'settings'    => 'easy_digital_downloads[post_type_archive_title]',
					'section'     => 'easy_digital_downloads',
					'type'        => 'text',
					'description' => sprintf( __( 'Configure the title for the Custom Post Type Archive Title page at %s', 'digifly' ), esc_url( home_url( $slug ) ) ),
				)
			);

		}
	}

	/**
	 * Theme Options section
	 */
	$wp_customize->add_section(
		'theme_options',
		array(
			'title'    => __( 'Theme Options', 'digifly' ),
			'priority' => 21,
		)
	);

	/**
	 * Full-width layout
	 */
	$wp_customize->add_setting(
		'theme_options[layout_full_width]',
		array(
			'sanitize_callback' => 'digifly_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'theme_options[layout_full_width]',
		array(
			'label'       => __( 'Full Width Layout', 'digifly' ),
			'description' => __( 'Display a full width layout. This will be noticeable once colors have been configured.', 'digifly' ),
			'settings'    => 'theme_options[layout_full_width]',
			'section'     => 'theme_options',
			'type'        => 'checkbox',

		)
	);

	/**
	 * Display excerpts setting
	 */
	$wp_customize->add_setting(
		'theme_options[display_excerpts]',
		array(
			'sanitize_callback' => 'digifly_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'theme_options[display_excerpts]',
		array(
			'label'       => __( 'Display Excerpts', 'digifly' ),
			'description' => __( 'Display excerpts for posts instead of the full content.', 'digifly' ),
			'settings'    => 'theme_options[display_excerpts]',
			'section'     => 'theme_options',
			'type'        => 'checkbox',

		)
	);

	/**
	 * Enable search in header
	 */
	$wp_customize->add_setting(
		'theme_options[header_search]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'digifly_sanitize_checkbox',
			'default'           => false,
		)
	);

	$wp_customize->add_control(
		'theme_options[header_search]',
		array(
			'label'       => __( 'Header Search', 'digifly' ),
			'description' => __( 'Displays a search box in the header and mobile menu.', 'digifly' ),
			'settings'    => 'theme_options[header_search]',
			'section'     => 'theme_options',
			'type'        => 'checkbox',

		)
	);

	$wp_customize->add_setting(
		'theme_options[shop_template]',
		array(
			'transport'         => 'postMessage',
			'default'           => 'sidebar',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'theme_options[shop_template]',
		array(
			'label'       => __( 'Shop Page Template', 'digifly' ),
			'description' => __( 'Select between a sidebar layout and full width layout for Shop Page', 'digifly' ),
			'settings'    => 'theme_options[shop_template]',
			'section'     => 'woocommerce_product_catalog',
			'type'        => 'select',
			'choices'     => array(
				'sidebar' => __( 'Has Sidebar', 'digifly' ),
				'full'    => __( 'Full Width', 'digifly' ),
			),
		)
	);

	/**
	 * Mobile Menu
	 */

	// Mobile menu button background color.
	$wp_customize->add_setting(
		'colors[menu_mobile_button_background_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_mobile_button_background_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_mobile_button_background_color',
			array(
				'label'       => __( 'Mobile Menu Button Background Color', 'digifly' ),
				'description' => __( 'The background color of the mobile menu button.', 'digifly' ),
				'settings'    => 'colors[menu_mobile_button_background_color]',
				'section'     => 'mobile_device_colors',
			)
		)
	);

	// Mobile menu button text color.
	$wp_customize->add_setting(
		'colors[menu_mobile_button_text_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_mobile_button_text_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_mobile_button_text_color',
			array(
				'label'       => __( 'Mobile Menu Button Text Color', 'digifly' ),
				'description' => __( 'The text color of the mobile menu button.', 'digifly' ),
				'settings'    => 'colors[menu_mobile_button_text_color]',
				'section'     => 'mobile_device_colors',
			)
		)
	);

	// Mobile menu background color.
	$wp_customize->add_setting(
		'colors[menu_mobile_background_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_mobile_background_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_mobile_background_color',
			array(
				'label'       => __( 'Mobile Menu Background Color', 'digifly' ),
				'description' => __( 'The background color of the mobile menu.', 'digifly' ),
				'settings'    => 'colors[menu_mobile_background_color]',
				'section'     => 'mobile_device_colors',
			)
		)
	);

	// Mobile menu link color.
	$wp_customize->add_setting(
		'colors[menu_mobile_link_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_mobile_link_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_mobile_link_color',
			array(
				'label'       => __( 'Mobile Menu Link Color', 'digifly' ),
				'description' => __( 'The link color of the mobile menu.', 'digifly' ),
				'settings'    => 'colors[menu_mobile_link_color]',
				'section'     => 'mobile_device_colors',
			)
		)
	);

	/**
	 * Footer styling
	 */

	// Footer background color.
	$wp_customize->add_setting(
		'colors[footer_background_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['footer_background_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_background_color',
			array(
				'label'       => __( 'Footer Background Color', 'digifly' ),
				'description' => __( 'The background color of the footer.', 'digifly' ),
				'settings'    => 'colors[footer_background_color]',
				'section'     => 'footer_colors',
			)
		)
	);

	// Footer text color.
	$wp_customize->add_setting(
		'colors[footer_text_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['footer_text_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_text_color',
			array(
				'label'       => __( 'Footer Text Color', 'digifly' ),
				'description' => __( 'The color of footer text.', 'digifly' ),
				'section'     => 'footer_colors',
				'settings'    => 'colors[footer_text_color]',
			)
		)
	);

	// Footer link color.
	$wp_customize->add_setting(
		'colors[footer_link_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['footer_link_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_link_color',
			array(
				'label'       => __( 'Footer Link Color', 'digifly' ),
				'description' => __( 'The color of footer links.', 'digifly' ),
				'section'     => 'footer_colors',
				'settings'    => 'colors[footer_link_color]',
			)
		)
	);

	// Footer link hover color.
	$wp_customize->add_setting(
		'colors[footer_link_hover_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['footer_link_hover_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_link_hover_color',
			array(
				'label'       => __( 'Footer Link Hover Color', 'digifly' ),
				'description' => __( 'The hover color of footer links.', 'digifly' ),
				'section'     => 'footer_colors',
				'settings'    => 'colors[footer_link_hover_color]',
			)
		)
	);

	// Footer heading color.
	$wp_customize->add_setting(
		'colors[footer_heading_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['footer_heading_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_heading_color',
			array(
				'label'       => __( 'Footer Heading Color', 'digifly' ),
				'description' => __( 'The color of footer headings.', 'digifly' ),
				'section'     => 'footer_colors',
				'settings'    => 'colors[footer_heading_color]',
			)
		)
	);

	// Footer site info color.
	$wp_customize->add_setting(
		'colors[footer_site_info_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['footer_site_info_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_site_info_color',
			array(
				'label'       => __( 'Footer Site Info Color', 'digifly' ),
				'description' => __( 'The color of footer site info.', 'digifly' ),
				'section'     => 'footer_colors',
				'settings'    => 'colors[footer_site_info_color]',
			)
		)
	);

	/**
	 * Show EDD related options
	 */
	if ( digifly_is_edd_active() ) {

		// Mobile cart icon color.
		$wp_customize->add_setting(
			'colors[mobile_cart_icon_color]',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => $defaults['mobile_cart_icon_color'],
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'mobile_cart_icon_color',
				array(
					'label'       => __( 'Mobile Menu Cart Icon Color', 'digifly' ),
					'description' => __( 'The color of the cart icon in the mobile menu.', 'digifly' ),
					'settings'    => 'colors[mobile_cart_icon_color]',
					'section'     => 'mobile_device_colors',
				)
			)
		);

		// Cart icon color
		$wp_customize->add_setting(
			'colors[cart_icon_color]',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => $defaults['cart_icon_color'],
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cart_icon_color',
				array(
					'label'       => __( 'Cart Icon Color', 'digifly' ),
					'description' => __( 'The color of the cart icon.', 'digifly' ),
					'settings'    => 'colors[cart_icon_color]',
					'section'     => 'header_colors',
				)
			)
		);

	}

	// Header Search Background Color
	$wp_customize->add_setting(
		'colors[header_search_background_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['header_search_background_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_search_background_color',
			array(
				'label'       => __( 'Header Search Background Color', 'digifly' ),
				'description' => __( 'The background color of the search box in the header.', 'digifly' ),
				'settings'    => 'colors[header_search_background_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Header Search Text Color
	$wp_customize->add_setting(
		'colors[header_search_text_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['header_search_text_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_search_text_color',
			array(
				'label'       => __( 'Header Search Text Color', 'digifly' ),
				'description' => __( 'The color of the search box text in the header.', 'digifly' ),
				'settings'    => 'colors[header_search_text_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Header Search icon Color
	$wp_customize->add_setting(
		'colors[header_search_icon_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['header_search_icon_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_search_icon_color',
			array(
				'label'       => __( 'Header Search Icon Color', 'digifly' ),
				'description' => __( 'The color of the search box icon in the header.', 'digifly' ),
				'settings'    => 'colors[header_search_icon_color]',
				'section'     => 'header_colors',
			)
		)
	);

	// Mobile Search Background Color
	$wp_customize->add_setting(
		'colors[menu_mobile_search_background_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_mobile_search_background_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_mobile_search_background_color',
			array(
				'label'       => __( 'Mobile Search Background Color', 'digifly' ),
				'description' => __( 'The background color of the search box in the mobile menu.', 'digifly' ),
				'settings'    => 'colors[menu_mobile_search_background_color]',
				'section'     => 'mobile_device_colors',
			)
		)
	);

	// Mobile Search Text Color
	$wp_customize->add_setting(
		'colors[menu_mobile_search_text_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_mobile_search_text_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_mobile_search_text_color',
			array(
				'label'       => __( 'Mobile Search Text Color', 'digifly' ),
				'description' => __( 'The color of the search box in the mobile menu.', 'digifly' ),
				'settings'    => 'colors[menu_mobile_search_text_color]',
				'section'     => 'mobile_device_colors',
			)
		)
	);

	// Mobile Search icon Color
	$wp_customize->add_setting(
		'colors[menu_mobile_search_icon_color]',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['menu_mobile_search_icon_color'],
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_mobile_search_icon_color',
			array(
				'label'       => __( 'Mobile Search Icon Color', 'digifly' ),
				'description' => __( 'The color of the search box icon in the mobile menu.', 'digifly' ),
				'settings'    => 'colors[menu_mobile_search_icon_color]',
				'section'     => 'mobile_device_colors',
			)
		)
	);

	/**
	 * Footer section
	 */
	$wp_customize->add_section(
		'footer',
		array(
			'title'    => __( 'Footer Options', 'digifly' ),
			'priority' => 25,
		)
	);

	$wp_customize->add_setting(
		'footer[columns]',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => '4',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'footer[columns]',
		array(
			'type'        => 'select',
			'section'     => 'footer',
			'label'       => __( 'Footer Columns', 'digifly' ),
			'description' => __( 'Number of columns in footer', 'digifly' ),
			'choices'     => array(
				'1' => __( 'One Column', 'digifly' ),
				'2' => __( 'Two Columns', 'digifly' ),
				'3' => __( 'Three Columns', 'digifly' ),
				'4' => __( 'Four Columns', 'digifly' ),
				'5' => __( 'Five Columns', 'digifly' ),
			),
		)
	);

	$wp_customize->add_setting(
		'footer[copyright]',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => sprintf( __( 'Copyright &copy; {Year} %s', 'digifly' ), esc_attr( get_bloginfo( 'name' ) ) ),
		)
	);

	$wp_customize->add_control(
		'footer[copyright]',
		array(
			'type'        => 'text',
			'section'     => 'footer',
			'label'       => __( 'Copyright', 'digifly' ),
			'description' => __( '{Year} can be used to print current year.', 'digifly' ),
		)
	);

	/**
	 * Blog Settings
	 */
	$wp_customize->add_section(
		'blog',
		array(
			'title'    => __( 'Blog Options', 'digifly' ),
			'priority' => 25,
		)
	);

	$wp_customize->add_setting(
		'blog[layout]',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => 'standard',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'blog[layout]',
		array(
			'type'    => 'select',
			'section' => 'blog',
			'label'   => __( 'Layout', 'digifly' ),
			'choices' => array(
				'standard' => __( 'Standard', 'digifly' ),
				'grid'     => __( 'Grid View', 'digifly' ),
				'list'     => __( 'List View', 'digifly' ),
			),
		)
	);

	$wp_customize->add_setting(
		'blog[sidebars]',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => 'right',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'blog[sidebars]',
		array(
			'type'    => 'select',
			'section' => 'blog',
			'label'   => __( 'Sidebars', 'digifly' ),
			'choices' => array(
				'right'      => __( 'Right Sidebar', 'digifly' ),
				'left'       => __( 'Left Sidebar', 'digifly' ),
				'no_sidebar' => __( 'No Sidebar', 'digifly' ),
			),
		)
	);
}
add_action( 'customize_register', 'digifly_customize_register' );

/**
 * Output styling to <head>
 *
 * @since 1.0
 */
if ( ! function_exists( 'digifly_colors_output_customizer_styling' ) ) :
	function digifly_colors_output_customizer_styling() {
		?>

		<?php

		// Return early if color panel has been disabled.
		if ( ! apply_filters( 'digifly_customize_color_options', true ) ) {
			return;
		}

		// Get the default colors to compare against.
		$defaults = digifly_customize_color_defaults();

		$colors = get_theme_mod( 'colors' );

		// Merge the $colors and $defaults.
		$colors = wp_parse_args( $colors, $defaults );

		if ( $colors ) {
			$colors = array_filter( $colors );
		}

		if ( ! empty( $colors ) ) :
			?>
			<style id="digifly-custom-css" type="text/css">
			<?php

			// Tagline color.
			if ( isset( $colors['tagline_color'] ) ) {
				echo '.site-description
				{ color:' . esc_attr( $colors['tagline_color'] ) . ';}';
			}

			// Link color.
			if ( isset( $colors['link_color'] ) ) {
				echo '.entry-content a,
				.widget_text a,
				.comment-content a,
				.wp-block-button__link,
				.woocommerce ul.products li.product .price,
				a { color:' . esc_attr( $colors['link_color'] ) . ';}';
			}

			// Link hover color.
			if ( isset( $colors['link_hover_color'] ) ) {
				echo '.entry-content a:hover,
				.widget_text a:hover,
				.comment-content a:hover,
				.wp-block-button__link:hover,
				.woocommerce ul.products li.product .price:hover,
				a:hover
				{ color:' . esc_attr( $colors['link_hover_color'] ) . ';}';
			}

			// Site header background.
			if ( isset( $colors['header_background_color'] ) ) {
				echo '#masthead { background-color:' . esc_attr( $colors['header_background_color'] ) . ';}';
			}

			// Primary menu background color.
			if ( isset( $colors['menu_primary_background_color'] ) ) {
				echo '#site-header-menu { background-color:' . esc_attr( $colors['menu_primary_background_color'] ) . ';}';
			}

			// Primary menu link color.
			if ( isset( $colors['menu_primary_link_color'] ) ) {
				echo '.main-navigation a { color:' . esc_attr( $colors['menu_primary_link_color'] ) . ';}';
			}

			// Primary menu link hover color.
			if ( isset( $colors['menu_primary_link_hover_color'] ) ) {
				echo '.main-navigation li:hover > a, .main-navigation li.focus > a, .main-navigation li.current-menu-item > a { color:' . esc_attr( $colors['menu_primary_link_hover_color'] ) . ';}';
			}

			// Primary menu link active color.
			if ( isset( $colors['menu_primary_link_active_color'] ) ) {
				echo '.main-navigation .current-menu-item > a, .main-navigation .current_page_ancestor > a, .main-navigation .current_page_ancestor > a:hover, .main-navigation li.current_page_ancestor:hover > a { color:' . esc_attr( $colors['menu_primary_link_active_color'] ) . ';}';
			}

			// Primary menu link background hover color.
			if ( isset( $colors['menu_primary_link_background_hover_color'] ) ) {
				echo '.primary-menu > li:hover { background-color:' . esc_attr( $colors['menu_primary_link_background_hover_color'] ) . ';}';
			}

			// Primary menu link background active color.
			if ( isset( $colors['menu_primary_link_background_active_color'] ) ) {
				echo '.primary-menu > li.current-menu-item, .primary-menu > li.current_page_ancestor { background:' . esc_attr( $colors['menu_primary_link_background_active_color'] ) . ';}';
			}

			// Primary sub-menu background color.
			if ( isset( $colors['menu_primary_sub_background_color'] ) ) {
				echo '.main-navigation ul ul li, .main-navigation ul ul { background:' . esc_attr( $colors['menu_primary_sub_background_color'] ) . ';}';
			}

			// Primary sub-menu background hover color.
			if ( isset( $colors['menu_primary_sub_background_hover_color'] ) ) {
				echo '.main-navigation .sub-menu li:hover { background-color:' . esc_attr( $colors['menu_primary_sub_background_hover_color'] ) . ';}';
			}

			// Primary sub-menu link color.
			if ( isset( $colors['menu_primary_sub_link_color'] ) ) {
				echo '.main-navigation .sub-menu a { color:' . esc_attr( $colors['menu_primary_sub_link_color'] ) . ';}';
			}

			// Primary sub-menu link hover color.
			if ( isset( $colors['menu_primary_sub_link_hover_color'] ) ) {
				echo '.main-navigation .sub-menu li:hover > a, .main-navigation .sub-menu li.focus > a { color:' . esc_attr( $colors['menu_primary_sub_link_hover_color'] ) . ';}';
			}

			// Primary sub-menu link active color.
			if ( isset( $colors['menu_primary_sub_link_active_color'] ) ) {
				echo '.main-navigation .sub-menu .current-menu-item a { color:' . esc_attr( $colors['menu_primary_sub_link_active_color'] ) . ';}';
				echo '.main-navigation .sub-menu .current-menu-item a:hover { color:' . esc_attr( $colors['menu_primary_sub_link_active_color'] ) . ';}';
			}

			// Primary sub-menu background active color.
			if ( isset( $colors['menu_primary_sub_background_active_color'] ) ) {
				echo '.main-navigation .sub-menu .current-menu-item { background:' . esc_attr( $colors['menu_primary_sub_background_active_color'] ) . ';}';
				echo '.main-navigation .sub-menu li.hover { background:' . esc_attr( $colors['menu_primary_sub_background_active_color'] ) . ';}';
				echo '.main-navigation .sub-menu .current-menu-item { background:' . esc_attr( $colors['menu_primary_sub_background_active_color'] ) . ';}';
			}

			// Secondary menu link color.
			if ( isset( $colors['menu_secondary_link_color'] ) ) {
				echo '#site-header-secondary-menu a { color:' . esc_attr( $colors['menu_secondary_link_color'] ) . ';}';
			}

			// Secondary menu link hover color.
			if ( isset( $colors['menu_secondary_link_hover_color'] ) ) {
				echo '#site-header-secondary-menu a:hover { color:' . esc_attr( $colors['menu_secondary_link_hover_color'] ) . ';}';
			}

			// Mobile cart icon color.
			if ( isset( $colors['mobile_cart_icon_color'] ) ) {
				echo '.navCart-mobile .navCart-icon { fill:' . esc_attr( $colors['mobile_cart_icon_color'] ) . ';}';
			}

			// Cart icon color.
			if ( isset( $colors['cart_icon_color'] ) ) {
				echo '.navCart-icon { fill:' . esc_attr( $colors['cart_icon_color'] ) . ';}';
			}

			// Button background color.
			if ( isset( $colors['button_background_color'] ) ) {
				echo '.woocommerce .cart .button,
				.woocommerce a.button,
				.woocommerce .product .cart .button,
				.woocommerce button.button,
				.woocommerce button.button.alt,
				.woocommerce a.button.alt,
				.button,
				button,
				input[type="submit"],
				button[type="submit"],
				.edd-submit.button,
				.vendor-order-action-links > a,
				.edd-fes-action,
				a.edd-fes-action,
				#submit {
					background:' . esc_attr( $colors['button_background_color'] ) . ';
					border-color: ' . esc_attr( $colors['button_background_color'] ) . ';
				}';
			}

			// Button background hover color.
			if ( isset( $colors['button_background_hover_color'] ) ) {
				echo '.woocommerce .cart .button:hover,
				.woocommerce a.button:hover,
				.woocommerce .product .cart .button:hover,
				.woocommerce button.button:hover,
				.woocommerce button.button.alt:hover,
				.woocommerce a.button.alt:hover,
				.button:hover,
				.button:focus,
				button:hover,
				button:focus,
				input[type="submit"]:hover,
				button[type="submit"]:hover,
				.edd-submit.button:hover,
				.edd-submit.button:visited,
				.vendor-order-action-links > a:hover,
				.edd-fes-action:hover,
				a.edd-fes-action:hover,
				#submit:hover {
					background:' . esc_attr( $colors['button_background_hover_color'] ) . ';
					border-color: ' . esc_attr( $colors['button_background_hover_color'] ) . ';
				}';
			}

			// Button text color.
			if ( isset( $colors['button_text_color'] ) ) {
				echo '.woocommerce .cart .button,
				.woocommerce a.button,
				.woocommerce .product .cart .button,
				.woocommerce button.button,
				.woocommerce button.button.alt,
				.woocommerce a.button.alt,
				.button,
				a.button,
				button,
				input[type="submit"],
				button[type="submit"],
				#submit,
				.edd-submit.button,
				.edd-submit.button:visited,
				.vendor-order-action-links > a,
				.edd-fes-action,
				a.edd-fes-action
				{ color:' . esc_attr( $colors['button_text_color'] ) . '; }';
			}

			// Button text hover color.
			if ( isset( $colors['button_text_hover_color'] ) ) {
				echo '.woocommerce .cart .button:hover,
				.woocommerce a.button:hover,
				.woocommerce .product .cart .button:hover,
				.woocommerce button.button:hover,
				.woocommerce button.button.alt:hover,
				.woocommerce a.button.alt:hover,
				.button:hover,
				a.button:hover,
				button:hover,
				input[type="submit"]:hover,
				button[type="submit"]:hover,
				#submit:hover,
				.vendor-order-action-links > a:hover,
				.edd-fes-action:hover,
				a.edd-fes-action:hover,
				.edd-submit.button:hover
				{ color:' . esc_attr( $colors['button_text_hover_color'] ) . '; }';
			}

			/**
			 * Header search
			 */

			// Header search background color.
			if ( isset( $colors['header_search_background_color'] ) ) {
				echo '.site-header-menu .search-form .search-field,.site-header-menu .search-form .search-submit { background:' . esc_attr( $colors['header_search_background_color'] ) . '; }';
			}

			// Header search text color.
			if ( isset( $colors['header_search_text_color'] ) ) {
				echo '.site-header-menu .search-form .search-field { color:' . esc_attr( $colors['header_search_text_color'] ) . '; }';
			}

			// Header search icon color.
			if ( isset( $colors['header_search_icon_color'] ) ) {
				echo '.site-header-menu .search-form .search-submit svg * { stroke:' . esc_attr( $colors['header_search_icon_color'] ) . '; }';
			}

			/**
			 * Mobile menu
			 */

			// Mobile menu button background color.
			if ( isset( $colors['menu_mobile_button_background_color'] ) ) {
				echo '#menu-toggle { background:' . esc_attr( $colors['menu_mobile_button_background_color'] ) . '; border-color: ' . esc_attr( $colors['menu_mobile_button_background_color'] ) . '; }';
			}

			// Mobile menu button background color.
			if ( isset( $colors['menu_mobile_button_text_color'] ) ) {
				echo '#menu-toggle { color:' . esc_attr( $colors['menu_mobile_button_text_color'] ) . '; }';
			}

			// Mobile menu background color.
			if ( isset( $colors['menu_mobile_background_color'] ) ) {
				echo '#mobile-menu { background:' . esc_attr( $colors['menu_mobile_background_color'] ) . '; }';
			}

			// Mobile menu link color.
			if ( isset( $colors['menu_mobile_link_color'] ) ) {
				echo '#mobile-menu a, #mobile-menu .current-menu-item > a, .dropdown-toggle, .dropdown-toggle:hover  { color:' . esc_attr( $colors['menu_mobile_link_color'] ) . '; }';
			}

			// Mobile search background color.
			if ( isset( $colors['menu_mobile_search_background_color'] ) ) {
				echo '#mobile-menu .search-form .search-field, #mobile-menu .search-form .search-submit { background:' . esc_attr( $colors['menu_mobile_search_background_color'] ) . '; }';
			}

			// Mobile search text color.
			if ( isset( $colors['menu_mobile_search_text_color'] ) ) {
				echo '#mobile-menu .search-form .search-field { color:' . esc_attr( $colors['menu_mobile_search_text_color'] ) . '; }';
			}

			// Mobile search icon color.
			if ( isset( $colors['menu_mobile_search_icon_color'] ) ) {
				echo '#mobile-menu .search-form .search-submit svg * { stroke:' . esc_attr( $colors['menu_mobile_search_icon_color'] ) . '; }';
			}

			/**
			 * Site footer
			 */

			// Footer background color.
			if ( isset( $colors['footer_background_color'] ) ) {
				echo '.site-footer { background-color:' . esc_attr( $colors['footer_background_color'] ) . '; }';
			}

			// Footer text color.
			if ( isset( $colors['footer_text_color'] ) ) {
				echo '.site-footer { color:' . esc_attr( $colors['footer_text_color'] ) . '; }';
			}

			// Footer link color.
			if ( isset( $colors['footer_link_color'] ) ) {
				echo '.site-footer a { color:' . esc_attr( $colors['footer_link_color'] ) . '; }';
			}

			// Footer link hover color.
			if ( isset( $colors['footer_link_hover_color'] ) ) {
				echo '.site-footer a:hover { color:' . esc_attr( $colors['footer_link_hover_color'] ) . '; }';
			}

			// Footer heading color.
			if ( isset( $colors['footer_heading_color'] ) ) {
				echo '.site-footer h1, .site-footer h2, .site-footer h3, .site-footer h4, .site-footer h5, .site-footer h6 { color:' . esc_attr( $colors['footer_heading_color'] ) . '; }';
			}

			// Footer site info color.
			if ( isset( $colors['footer_site_info_color'] ) ) {
				echo '.site-info { color:' . esc_attr( $colors['footer_site_info_color'] ) . '; }';
			}

			?>
		</style>
		<?php endif; ?>

		<?php
	}
endif;
add_action( 'wp_head', 'digifly_colors_output_customizer_styling' );

if ( ! function_exists( 'digifly_typography_output_customizer_styling' ) ) :

	function digifly_typography_output_customizer_styling() {
		$style = '';

		$typography_sections = array(
			'body_typography' => 'body',
			'p_typography'    => 'p',
		);

		foreach ( $typography_sections as $typo_section => $selector ) {

			$style .= $selector . '{';

			$typo_section_font_family = $typo_section . '_font_family';
			$typo_section_font_weight = $typo_section . '_font_style';
			$typo_section_font_style  = $typo_section . '_font_weight';
			$typo_section_font_size   = $typo_section . '_font_size';

			$family = esc_attr( get_theme_mod( $typo_section_font_family, '' ) );

			if ( ! empty( $family ) ) {
				$style .= 'font-family:' . esc_attr( $family ) . ';';
			}

			$font_style = esc_attr( get_theme_mod( $typo_section_font_weight, '' ) );

			if ( ! empty( $font_style ) ) {
				$style .= 'font-style:' . esc_attr( $font_style ) . ';';
			}

			$weight = esc_attr( get_theme_mod( $typo_section_font_style, '' ) );

			if ( ! empty( $weight ) ) {
				$style .= 'font-weight:' . absint( $weight ) . ';';
			}

			$size = esc_attr( get_theme_mod( $typo_section_font_size, '' ) );

			if ( ! empty( $size ) ) {
				$style .= 'font-size:' . intval( $size ) . 'px;';
			}

			$line_height = esc_attr( get_theme_mod( $typo_section . '_font_line_height', '' ) );

			if ( ! empty( $line_height ) && ! empty( $line_height ) ) {
				$style .= 'line-height:' . intval( $line_height ) / intval( $size ) . 'px;';
			}

			$style .= '}';
		}

		// Generate headings
		for ( $heading_level = 1; $heading_level <= 6; $heading_level++ ) {
			$style .= 'h' . $heading_level . '{';

			$heading_font_family = 'h' . $heading_level . '_font_family';
			$heading_font_weight = 'h' . $heading_level . '_font_weight';
			$heading_font_style  = 'h' . $heading_level . '_font_style';
			$heading_font_size   = 'h' . $heading_level . '_font_size';

			$family = esc_attr( get_theme_mod( $heading_font_family, '' ) );

			if ( ! empty( $family ) ) {
				$style .= 'font-family: ' . esc_attr( $family ) . ';';
			}

			$weight = esc_attr( get_theme_mod( $heading_font_weight, '' ) );

			if ( ! empty( $weight ) ) {
				$style .= 'font-weight: ' . absint( $weight ) . ';';
			}

			$font_style = esc_attr( get_theme_mod( $heading_font_style, '' ) );

			if ( ! empty( $font_style ) ) {
				$style .= 'font-style: ' . esc_attr( $font_style ) . ';';
			}

			$size = esc_attr( get_theme_mod( $heading_font_size, '' ) );

			if ( ! empty( $size ) ) {
				$style .= 'font-size: ' . intval( $size ) . 'px;';
			}
			$style .= '}';
		}

		if ( ! empty( $style ) ) {
			$style = '<style id="digifly-customizer-typography">' . $style . '</style>';
			echo apply_filters( 'digifly_customizer_typography_styles', $style );
		}
	}
endif;
add_action( 'wp_head', 'digifly_typography_output_customizer_styling', 50 );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since 1.0.0
 * @see digifly_customize_register()
 *
 * @return void
 */
function digifly_customize_partial_blogname() {
	esc_attr( bloginfo( 'name' ) );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since 1.0.0
 * @see digifly_customize_register()
 *
 * @return void
 */
function digifly_customize_partial_blogdescription() {
	esc_attr( bloginfo( 'description' ) );
}

/**
 * Render the header search for the selective refresh partial.
 *
 * @since 1.0.3
 * @see digifly_customize_register()
 *
 * @return void
 */
function digifly_customize_partial_header_search() {
	digifly_search()->digifly_search_form();
}

/**
 * Render the cart icon for the selective refresh partial.
 *
 * @since 1.0.0
 * @see digifly_customize_register()
 *
 * @return void
 */
function digifly_customize_partial_cart_icon() {
	echo digifly_edd_nav_cart()->cart_icon();
}

/**
 * Render the cart quantity and total for the selective refresh partial.
 *
 * @since 1.0.0
 * @see digifly_customize_register()
 *
 * @return void
 */
function digifly_customize_partial_cart_options() {

	$cart_option = digifly_edd_nav_cart()->cart_option();

	switch ( $cart_option ) {

		case 'all':
			echo digifly_edd_nav_cart()->cart_quantity();
			echo digifly_edd_nav_cart()->cart_total();

			break;

		case 'item_quantity':
			echo digifly_edd_nav_cart()->cart_quantity();
			break;

		case 'cart_total':
			echo digifly_edd_nav_cart()->cart_total();
			break;

	}
}

/**
 * Sanitize checkbox
 *
 * @since 1.0.0
 * @param boolean $checked
 *
 * @return boolean true if checked, false otherwise
 */
function digifly_sanitize_checkbox( $checked ) {
	return ( isset( $checked ) && true === $checked ? true : false );
}

/**
 * Sanitization callback for cart options.
 *
 * @since 1.0.0
 *
 * @param  string $value option name value.
 * @return string option name.
 */
function digifly_sanitize_cart_options( $value ) {

	$options = digifly_customize_cart_options();

	if ( ! array_key_exists( $value, $options ) ) {
		$value = 'all';
	}

	return $value;
}

/**
 * Cart options
 *
 * @since 1.0.0
 *
 * @return array cart options
 */
function digifly_customize_cart_options() {
	return array(
		'item_quantity' => __( 'Display item quantity only', 'digifly' ),
		'cart_total'    => __( 'Display cart total only', 'digifly' ),
		'all'           => __( 'Display item quantity and cart total', 'digifly' ),
		'none'          => __( 'Display nothing', 'digifly' ),
	);
}

/**
 * Determine if the "colors" panel is active
 *
 * @since 1.0.0
 *
 * @return boolean true if color panel can be shown, false otherwise.
 */
function digifly_customize_color_options() {

	if ( apply_filters( 'digifly_customize_color_options', true ) ) {
		return true;
	}

	return false;
}

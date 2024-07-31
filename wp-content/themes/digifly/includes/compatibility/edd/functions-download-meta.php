<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Download meta functions
 */

/**
 * Determine if there's download meta
 *
 * @since 1.0.0
 *
 * @return bool true if download meta, false otherwise.
 */
function digifly_edd_has_download_meta() {

	$has_download_meta = false;

	// Get the download meta options
	$options = digifly_edd_download_meta_options();

	if (
		true === $options['price'] ||
		true === $options['author_name'] ||
		true === $options['avatar']
	) {
		$has_download_meta = true;
	}

	return $has_download_meta;
}


/**
 * Download meta position.
 *
 * Appears in a download on the download grid (either with the [downloads] shortcode or archive-download.php)
 *
 * Possible values are:
 * after_title (default)
 * after
 * before_title
 *
 * @since 1.0.0
 * @return string $position The position of the download meta
 */
function digifly_edd_download_meta_position() {

	$options  = digifly_edd_download_meta_options();
	$position = $options['position'];

	return $position;
}

/**
 * Download meta options.
 *
 * @since 1.0.0
 *
 * @return array $options Download meta options
 */
function digifly_edd_download_meta_options() {

	$options = array(
		'echo'        => true,
		'position'    => 'after_title', // See digifly_edd_download_meta_position() for possible values.
		'price'       => false,
		'price_link'  => false, // Whether or not the price is linked through to the download.
		'author_name' => false,
		'author_link' => true,
		'author_by'   => __( 'by', 'digifly' ),
		'avatar'      => false,
		'avatar_size' => 32, // Size of avatar, in pixels.
	);

	// Display author name (which will be their store name) and avatar if FES is active.
	if ( digifly_is_edd_fes_active() ) {
		$options['author_name'] = true;
		$options['avatar']      = true;
	}

	return apply_filters( 'digifly_edd_download_meta_options', $options );
}

/**
 * Load the download meta.
 *
 * @since 1.0.3
 */
function digifly_edd_load_download_meta() {

	// Return early if download meta has been disabled.
	if ( ! apply_filters( 'digifly_edd_download_meta', true, get_the_ID() ) ) {
		return;
	}

	switch ( digifly_edd_download_meta_position() ) {

		case 'after':
			add_action( 'digifly_edd_download_footer_end', 'digifly_edd_download_meta_after' );
			break;

		case 'after_title':
			add_action( 'edd_download_after_title', 'digifly_edd_download_meta_after_title' );
			break;

		case 'before_title':
			add_action( 'edd_download_before_title', 'digifly_edd_download_meta_before_title' );
			break;

	}
}
add_action( 'template_redirect', 'digifly_edd_load_download_meta' );

/**
 * Display the download meta in the download footer.
 *
 * @since 1.0.0
 */
function digifly_edd_download_meta_after() {
	digifly_edd_display_download_meta( array( 'position' => 'after' ) );
}

/**
 * Display the download meta after the download title.
 *
 * @since 1.0.0
 */
function digifly_edd_download_meta_after_title() {
	digifly_edd_display_download_meta( array( 'position' => 'after_title' ) );
}

/**
 * Display the download meta before the download title.
 *
 * @since 1.0.0
 */
function digifly_edd_download_meta_before_title() {
	digifly_edd_display_download_meta( array( 'position' => 'before_title' ) );
}

/**
 * Display the download meta
 *
 * @since 1.0.0
 */
function digifly_edd_display_download_meta( $args = array() ) {

	global $post;

	$options = digifly_edd_download_meta_options();
	$args    = wp_parse_args( $args, $options );

	if ( empty( $args['position'] ) ) {
		$args['position'] = 'after_title';
	}

	// Avatar display.
	$avatar = $args['avatar'];

	// Avatar size.
	$avatar_size = $args['avatar_size'];

	// Author Name.
	$author = $args['author_name'];

	// Author Link.
	$author_link = $args['author_link'];

	// Author "by"
	$author_by = $args['author_by'] ? $args['author_by'] . '&nbsp;' : '';

	// Price.
	$price = $args['price'];

	// Price link.
	$price_link = $args['price_link'];

	// Classes.
	$classes = array( 'eddDownloadMeta' );

	$echo = true;

	// Don't output download meta if everything has been turned off.
	if ( ! $price && ! $author && ! $avatar ) {
		return;
	}

	ob_start();
	?>

	<div class="<?php echo implode( ' ', array_filter( $classes ) ); ?>">

		<?php do_action( 'digifly_edd_download_meta_start' ); ?>

		<?php
		/**
		 * Price
		 */
		if ( $price ) :
			?>

			<?php if ( $price_link ) : ?>
				<a href="<?php the_permalink(); ?>" class="eddDownloadMeta-price"><?php echo digifly_edd_download_meta_price(); ?></a>
			<?php else : ?>
				<span class="eddDownloadMeta-price"><?php echo digifly_edd_download_meta_price(); ?></span>
			<?php endif; ?>

		<?php endif; ?>

		<?php

		$vendor_name = get_the_author_meta( 'display_name', $post->post_author );

		/**
		 * FES - link through to vendor page
		 */
		if ( digifly_is_edd_fes_active() ) :

			$vendor_url        = ( new digifly_EDD_Frontend_Submissions() )->author_url( get_the_author_meta( 'ID', $post->post_author ) );
			$vendor_store_name = get_the_author_meta( 'name_of_store', $post->post_author );

			?>

			<?php if ( $author_link ) : ?>
				<a class="eddDownloadMeta-author" href="<?php echo $vendor_url; ?>">
			<?php else : ?>
				<span class="eddDownloadMeta-author">
			<?php endif; ?>

				<?php
				/**
				 * Avatar.
				 */
				?>
				<?php if ( $avatar ) : ?>
				<span class="eddDownloadMeta-authorAvatar">
					<?php echo get_avatar( get_the_author_meta( 'ID', $post->post_author ), $avatar_size, '', $vendor_store_name ); ?>
				</span>
				<?php endif; ?>

				<?php if ( $author ) : ?>
				<span class="eddDownloadMeta-authorName">
					<?php echo ! empty( $vendor_store_name ) ? $author_by . $vendor_store_name : $vendor_name; ?>
				</span>
				<?php endif; ?>

			<?php if ( $author_link ) : ?>
				</a>
			<?php else : ?>
				</span>
			<?php endif; ?>

		<?php else : ?>

			<span class="eddDownloadMeta-author">

				<?php if ( $avatar ) : ?>
				<span class="eddDownloadMeta-authorAvatar">
					<?php echo get_avatar( get_the_author_meta( 'ID', $post->post_author ), $avatar_size, '', $vendor_name ); ?>
				</span>
				<?php endif; ?>

				<?php if ( $author ) : ?>
				<span class="eddDownloadMeta-authorName">
					<?php echo $author_by . get_the_author_meta( 'display_name', $post->post_author ); ?>
				</span>
				<?php endif; ?>

			</span>

		<?php endif; ?>

		<?php do_action( 'digifly_edd_download_meta_end' ); ?>

	</div>

	<?php

	if ( $echo ) {
		echo ob_get_clean();
	} else {
		return ob_get_clean();
	}
}

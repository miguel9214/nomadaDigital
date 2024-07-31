<?php
/**
 * The template for displaying the header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php
	if ( is_singular() && pings_open( get_queried_object() ) ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
	?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php do_action( 'digifly_site_before' ); ?>

<div id="page" class="hfeed site">

	<?php do_action( 'digifly_header' ); ?>

	<div id="content" class="site-content">

	<?php do_action( 'digifly_content_start' ); ?>

<?php
/**
 * The Sidebar containing the main widget area
 *
 * @since 1.0.0
 */
?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
<div id="secondary" class="<?php echo digifly_secondary_classes(); ?>">
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">

		<?php do_action( 'digifly_primary_sidebar_start' ); ?>

		<?php dynamic_sidebar( 'sidebar-1' ); ?>

		<?php do_action( 'digifly_primary_sidebar_end' ); ?>

	</div>
</div>
<?php endif; ?>

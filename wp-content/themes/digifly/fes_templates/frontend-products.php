<?php
/**
 * The "Products" tab for the FES Vendor Dashboard
 *
 * @package DigiFly
 */
global $products;

if ( count( $products ) > 0 ) {
	echo EDD_FES()->dashboard->product_list_status_bar();

	foreach ( $products as $edd_product ) :
		$edd_product_thumb = get_the_post_thumbnail( $edd_product->ID, 'digifly-download-grid' );
		?>
		<div class="vendor-product clear">
			<div class="vendor-product-info">
				<h5 class="vendor-product-title">
					<span class="vendor-product-status"><?php echo EDD_FES()->dashboard->product_list_status( $edd_product->ID ); ?> </span>
					<?php echo EDD_FES()->dashboard->product_list_title( $edd_product->ID ); ?>
				</h5>

				<?php if ( ! empty( $edd_product_thumb ) ) { ?>
					<div class="vendor-product-image">
						<?php echo $edd_product_thumb; ?>
					</div>
				<?php } ?>

				<div class="vendor-product-details">
					<div class="vendor-product-info-group">
						<span class="vendor-product-label">
							<?php echo _x( 'Price', 'FES vendor dashboard Product display', 'digifly' ) . ': '; ?>
						</span>
						<span class="vendor-product-price">
							<?php echo EDD_FES()->dashboard->product_list_price( $edd_product->ID ); ?>
						</span>
					</div>
					<div class="vendor-product-info-group">
						<span class="vendor-product-label">
							<?php echo _x( 'Purchases', 'FES vendor dashboard Product display', 'digifly' ) . ': '; ?>
						</span>
						<span class="vendor-product-sales">
							<?php echo EDD_FES()->dashboard->product_list_sales_esc( $edd_product->ID ); ?>
						</span>
					</div>
					<div class="vendor-product-info-group">
						<span class="vendor-product-label">
							<?php echo _x( 'Details', 'FES vendor dashboard Product display', 'digifly' ) . ': '; ?>
						</span>
						<span class="vendor-product-status-details">
							<?php echo EDD_FES()->dashboard->product_list_date( $edd_product->ID ); ?>
						</span>
					</div>
				</div>
				<div class="vendor-product-actions">
					<span class="vendor-product-action-links">
						<?php EDD_FES()->dashboard->product_list_actions( $edd_product->ID ); ?>
					</span>
				</div>
			</div>
		</div>
		<?php
		do_action( 'fes-product-table-column-value' );
	endforeach;
} else {
	_e( 'No items found', 'digifly' );
}

EDD_FES()->dashboard->product_list_pagination();

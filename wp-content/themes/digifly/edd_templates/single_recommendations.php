<?php

global $post;
$edd_rp_suggestion_data = edd_rp_get_suggestions( $post->ID );
$edd_rp_count           = (int) edd_get_option( 'edd_rp_suggestion_count', 3 );

if ( is_array( $edd_rp_suggestion_data ) && ! empty( $edd_rp_suggestion_data ) ) :
	$edd_rp_suggestions = array_keys( $edd_rp_suggestion_data );

	$edd_rp_suggested_downloads = new WP_Query(
		array(
			'post__in'  => $edd_rp_suggestions,
			'post_type' => 'download',
		)
	);

	if ( $edd_rp_suggested_downloads->have_posts() ) : ?>
		<div id="edd-rp-single-wrapper">
			<h5 id="edd-rp-single-header"><?php echo sprintf( __( 'Users who purchased %s, also purchased:', 'digifly' ), get_the_title() ); ?></h5>
			<div id="edd-rp-items-wrapper" class="mb-xs-2 edd_downloads_list edd_download_columns_<?php echo $edd_rp_count; ?> edd-rp-single">
				
				<?php while ( $edd_rp_suggested_downloads->have_posts() ) : ?>
					<?php $edd_rp_suggested_downloads->the_post(); ?>
					<div class="edd_download edd-rp-item <?php echo ( ! current_theme_supports( 'post-thumbnails' ) ) ? 'edd-rp-nothumb' : ''; ?>">
						<div class="edd_download_inner">

							<?php do_action( 'edd_rp_item_before' ); ?>

							<?php if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail( get_the_ID() ) ) : ?>
								<div class="edd_download_image">
									<a href="<?php the_permalink(); ?>">
										<?php echo get_the_post_thumbnail( get_the_ID() ); ?>
									</a>
								</div>
							<?php endif; ?>

							<?php do_action( 'edd_rp_item_after_thumbnail' ); ?>
							<div class="edd-download-content">
								<h3 class="edd_download_title">
									<a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
								</h3>

								<?php if ( ! edd_has_variable_prices( get_the_ID() ) ) : ?>
									<?php edd_price( get_the_ID() ); ?>
								<?php endif; ?>

								<?php do_action( 'edd_rp_item_after_price' ); ?>

								<div class="edd_download_buy_button">
									<?php
									$edd_purchase_link_args = array(
										'download_id' => get_the_ID(),
										'price'       => false,
										'direct'      => false,
									);
									$edd_purchase_link_args = apply_filters( 'edd_rp_purchase_link_args', $edd_purchase_link_args );

									echo edd_get_purchase_link( $edd_purchase_link_args );
									?>
								</div>
							</div>
							<?php do_action( 'edd_rp_item_after' ); ?>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

<?php endif; ?>

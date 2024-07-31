<div class="wrap">
	<h1><?php _e( 'Theme Options', 'digifly' ); ?></h1>

	<p><?php _e( 'The Theme Customization Options for DigiFly are available in the ', 'digifly' ); ?> <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php _e( 'Customizer', 'digifly' ); ?></a></p>

	<hr>
	<div class="digifly-subscription-callout-wrapper">
		<div class="digifly-subscription-callout">
			<div class="digifly-subscription-callout-main">
				<h3><?php _e( 'Get Pro Tips on how to Start a Great Webstore!', 'digifly' ); ?></h3>
				<p><?php _e( 'A great webstore converts traffic into paying customers. The beauty with WordPress is you can start small and scale up as you go. Learn some Pro Tips on how to Start a Great Webstore and what steps to do in which order to obtain a high converting webstore. Sign-up for our Pro Tips from the founders of <a href="https://www.pluginsandsnippets.com" target="_blank">Plugins & Snippets</a> and subscribe to our newsletter.', 'digifly' ); ?></p>

				<div class="digifly-subscription-error" style="display: none;"><?php _e( 'There was an error in processing your request, please try again.', 'digifly' ); ?></div>

				<form method="POST" class="digifly-subscription-form">
					<input type="email" required value="<?php echo esc_attr( get_option( 'admin_email' ) ); ?>">
					
					<?php wp_nonce_field( 'digifly_subscribe' ); ?>

					<div class="digifly-subscription-actions">
						<button class="button-primary"><?php _e( 'Subscribe', 'digifly' ); ?></button>
					</div>
				</form>
			</div>

			<div class="digifly-subscription-callout-thanks" style="display: none;">
				<h3><?php _e( 'Thank you for signing up to our Newsletter!', 'digifly' ); ?></h3>
			</div>

		</div>
	</div>

	<hr>
	<h2><?php _e( 'Additional Resources', 'digifly' ); ?></h2>
	<p><a href="<?php echo digifly_get_author_uri(); ?>" target="_blank"><?php _e( 'Plugins & Snippets ', 'digifly' ); ?></a><?php _e( 'offers many plugins and resources to increase the conversion rates of your webstore. Supercharge your Webshop with our plugins and get up to date on important Webhshop Conversion Topics', 'digifly' ); ?></p>

	<div class="digifly-other-plugins">
		<?php

		if ( DIGIFLY_PS_PROMOTION_ITEMS ) {
			$digifly_promotion_items = DIGIFLY_PS_PROMOTION_ITEMS;

			foreach ( $digifly_promotion_items as $item ) {
				?>
					<div class="digifly-other-plugin">
						<div class="digifly-other-plugin-title"><a href="<?php echo esc_url( $item['url'] ); ?>" target="_blank"><?php echo $item['title']; ?></a></div>
						<div class="digifly-other-plugin-image"><a href="<?php echo esc_url( $item['url'] ); ?>" target="_blank"><img src="<?php echo esc_url( $item['image'] ); ?>" /></a></div>
						<div class="digifly-other-plugin-desc">

						<?php if ( $item['initial_link'] ) : ?>
							<a href="<?php echo esc_url( $item['url'] ); ?>" target="_blank"><?php echo $item['title']; ?></a> 
							<?php endif; ?>

						<?php echo $item['description']; ?>
						</div>
					</div>
				<?php
			}
		}
		?>
	</div>
</div>

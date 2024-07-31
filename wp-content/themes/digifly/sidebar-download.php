<?php
/**
 * The Sidebar for the single-download.php containing the main widget area
 *
 * @since 1.0.0
 */

// Get the author options.
$digifly_author_options = digifly_edd_download_author_options();

// Get the download options.
$digifly_edd_download_options = digifly_edd_download_details_options();

?>
<div id="secondary" class="<?php echo digifly_secondary_classes(); ?>">

	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">

		<?php do_action( 'digifly_edd_sidebar_download_start' ); ?>

		<?php if ( ! dynamic_sidebar( 'sidebar-download' ) ) : ?>

			<section class="widget widget_edd_product_details">
				<?php
				/**
				 * The price and purchase button are loaded onto this hook.
				 * This hook is also added to EDD's Download Details widget.
				 */
				do_action( 'digifly_edd_download_info', $post->ID );
				?>
			</section>

			<?php do_action( 'digifly_edd_sidebar_download_product_details_after' ); ?>

			<?php
			/**
			 * Show the Author Details
			 */
			if ( digifly_edd_show_download_author() ) :
				?>

				<section class="widget downloadAuthor">

					<?php
					/**
					 * Author avatar
					 */
					$digifly_edd_user       = new WP_User( $post->post_author );
					$digifly_fes_vendor_url = digifly_is_edd_fes_active() ? ( new digifly_EDD_Frontend_Submissions() )->author_url( get_the_author_meta( 'ID', $post->post_author ) ) : '';

					if ( true === $digifly_author_options['avatar'] ) :
						?>

						<div class="downloadAuthor-avatar">
						<?php if ( $digifly_fes_vendor_url ) : ?>
							<a href="<?php echo $digifly_fes_vendor_url; ?>"><?php echo get_avatar( $digifly_edd_user->ID, $digifly_author_options['avatar_size'], '', get_the_author_meta( 'display_name' ) ); ?></a>
						<?php else : ?>
							<?php echo get_avatar( $digifly_edd_user->ID, $digifly_author_options['avatar_size'], '', get_the_author_meta( 'display_name' ) ); ?>
						<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php
					/**
					 * Author's store name.
					 */
					if ( true === $digifly_author_options['store_name'] ) :
						$digifly_edd_store_name = get_the_author_meta( 'name_of_store', $post->post_author );
						?>

						<?php if ( digifly_is_edd_fes_active() && ! empty( $digifly_edd_store_name ) ) : ?>
							<h2 class="widget-title"><?php echo $digifly_edd_store_name; ?></h2>
						<?php endif; ?>

					<?php endif; ?>

					<ul>
					<?php
						do_action( 'digifly_edd_sidebar_download_author_list_start', $digifly_author_options );

						/**
						 * Author name.
						 */
					if ( true === $digifly_author_options['name'] ) :
						?>

							<li class="downloadAuthor-author">
								<span class="downloadAuthor-name"><?php _e( 'Author:', 'digifly' ); ?></span>
								<span class="downloadAuthor-value">
									<?php if ( digifly_is_edd_fes_active() ) : ?>
										<a class="vendor-url" href="<?php echo $digifly_fes_vendor_url; ?>">
											<?php echo $digifly_edd_user->display_name; ?>
										</a>
									<?php else : ?>
										<?php echo $digifly_edd_user->display_name; ?>
									<?php endif; ?>
								</span>
							</li>
						<?php endif; ?>

						<?php
						/**
						 * Author signup date.
						 */
						if ( true === $digifly_author_options['signup_date'] ) :
							?>

							<li class="downloadAuthor-authorSignupDate">
								<span class="downloadAuthor-name"><?php _e( 'Author since:', 'digifly' ); ?></span>
								<span class="downloadAuthor-value"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $digifly_edd_user->user_registered ) ); ?></span>
							</li>
						<?php endif; ?>

						<?php
						/**
						 * Author website.
						 */
						$digifly_edd_author_website = get_the_author_meta( 'user_url', $post->post_author );

						if ( ! empty( $digifly_edd_author_website ) && true === $digifly_author_options['website'] ) :
							?>

							<li class="downloadAuthor-website">
								<span class="downloadAuthor-name"><?php _e( 'Website:', 'digifly' ); ?></span>
								<span class="downloadAuthor-value"><a href="<?php echo esc_url( $digifly_edd_author_website ); ?>" target="_blank" rel="noopener"><?php echo esc_url( $digifly_edd_author_website ); ?></a></span>
							</li>
							<?php
						endif;
						do_action( 'digifly_edd_sidebar_download_author_list_end', $digifly_author_options );
						?>

					</ul>

				</section>

			<?php endif; ?>

			<?php do_action( 'digifly_edd_sidebar_download_author_after' ); ?>

			<?php
			/**
			 * Show the Download Details
			 */
			if ( digifly_edd_show_download_details() ) :
				?>

				<section class="widget downloadDetails">

					<?php
					/**
					 * Widget title.
					 */
					if ( ! empty( $digifly_edd_download_options['title'] ) ) :
						?>
						<h2 class="widget-title"><?php echo $digifly_edd_download_options['title']; ?></h2>
					<?php endif; ?>

					<ul>

						<?php do_action( 'digifly_edd_sidebar_download_details_list_start', $digifly_edd_download_options ); ?>

						<?php
						/**
						 * Date published.
						 */
						if ( true === $digifly_edd_download_options['date_published'] ) :
							?>
							<li class="downloadDetails-datePublished">
								<span class="downloadDetails-name"><?php _e( 'Published:', 'digifly' ); ?></span>
								<span class="downloadDetails-value"><?php echo digifly_edd_download_date_published(); ?></span>
							</li>
						<?php endif; ?>

						<?php
						/**
						 * Sale count.
						 */
						if ( true === $digifly_edd_download_options['sale_count'] ) :
							$digifly_edd_sales = edd_get_download_sales_stats( $post->ID );
							?>
							<li class="downloadDetails-sales">
								<span class="downloadDetails-name"><?php _e( 'Sales:', 'digifly' ); ?></span>
								<span class="downloadDetails-value"><?php echo $digifly_edd_sales; ?></span>
							</li>
						<?php endif; ?>

						<?php
						/**
						 * Version.
						 */
						if ( true === $digifly_edd_download_options['version'] ) :

							$digifly_edd_version = digifly_edd_download_version( $post->ID );

							if ( $digifly_edd_version ) :
								?>
								<li class="downloadDetails-version">
									<span class="downloadDetails-name"><?php _e( 'Version:', 'digifly' ); ?></span>
									<span class="downloadDetails-value"><?php echo $digifly_edd_version; ?></span>
								</li>
							<?php endif; ?>
						<?php endif; ?>

						<?php
						/**
						 * Download categories.
						 */
						if ( true === $digifly_edd_download_options['categories'] ) :

							$digifly_edd_categories = digifly_edd_download_categories( $post->ID );

							if ( $digifly_edd_categories ) :
								?>
								<li class="downloadDetails-categories">
									<span class="downloadDetails-name"><?php _e( 'Categories:', 'digifly' ); ?></span>
									<span class="downloadDetails-value"><?php echo $digifly_edd_categories; ?></span>
								</li>
							<?php endif; ?>
						<?php endif; ?>

						<?php
						/**
						 * Download tags.
						 */
						if ( true === $digifly_edd_download_options['tags'] ) :

							$digifly_edd_tags = digifly_edd_download_tags( $post->ID );

							if ( $digifly_edd_tags ) :
								?>
								<li class="downloadDetails-tags">
									<span class="downloadDetails-name"><?php _e( 'Tags:', 'digifly' ); ?></span>
									<span class="downloadDetails-value"><?php echo $digifly_edd_tags; ?></span>
								</li>
							<?php endif; ?>
						<?php endif; ?>

						<?php do_action( 'digifly_edd_sidebar_download_details_list_end', $digifly_edd_download_options ); ?>

					</ul>
				</section>
			<?php endif; ?>

		<?php endif; // end sidebar widget area ?>

		<?php do_action( 'digifly_edd_sidebar_download_end' ); ?>

	</div>

</div>

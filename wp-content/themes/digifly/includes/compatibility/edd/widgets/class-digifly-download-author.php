<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Download Author Widget
 * Inspired by the same widget from the Vendd theme: https://easydigitaldownloads.com/downloads/vendd/
 *
 * This widget is designed to replace the default author info that
 * displays in Digifly's download sidebar by default. This purely exists
 * as an alternative to the default so that you can control your sidebar
 * and rearrange items.
 *
 * @since 1.0.0
 */
class Digifly_Download_Author extends WP_Widget {

	/**
	 * Register the widget
	 */
	public function __construct() {

		parent::__construct(
			'digifly_download_author',
			sprintf( __( 'Digifly: %s Author', 'digifly' ), edd_get_label_singular() ),
			array(
				'description' => sprintf( __( 'Display the %s author\'s details.', 'digifly' ), strtolower( edd_get_label_singular() ) ),
				'classname'   => 'downloadAuthor',
			)
		);
	}

	/**
	 * Output the content of the widget
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		global $post;

		// Return early if not a single download.
		if ( 'download' !== get_post_type( $post ) ) {
			return;
		}

		// Get the author.
		$author = new WP_User( $post->post_author );

		if ( digifly_is_edd_fes_active() ) {
			$vendor_url = ( new digifly_EDD_Frontend_Submissions() )->author_url( get_the_author_meta( 'ID', $author->post_author ) );
		}

		if ( isset( $instance['title'] ) ) {
			$instance['title'] = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		}

		// Allow the author details to show when using the widget.
		$instance['show'] = true;

		$options = digifly_edd_download_author_options( $instance );

		// Return early if author details cannot be shown.
		if ( ! digifly_edd_show_download_author( $options ) ) {
			return;
		}

		echo $args['before_widget'];

		if ( ! empty( $options['title'] ) && $options['title'] ) {
			echo $args['before_title'] . $options['title'] . $args['after_title'];
		}

		/**
		 * Author avatar.
		 */
		if ( true === $options['avatar'] ) {

			if ( digifly_is_edd_fes_active() ) : ?>
				<div class="downloadAuthor-avatar">
					<a class="vendor-url" href="<?php echo esc_url( $vendor_url ); ?>"><?php echo get_avatar( $author->ID, $options['avatar_size'], '', get_the_author_meta( 'display_name' ) ); ?></a>
				</div>
			<?php else : ?>
				<div class="downloadAuthor-avatar">
					<?php echo get_avatar( $author->ID, $options['avatar_size'], '', get_the_author_meta( 'display_name' ) ); ?>
				</div>
				<?php
			endif;

		}

		/**
		 * Author's store name.
		 */
		if ( true === $options['store_name'] ) :
			?>

			<?php
			if ( digifly_is_edd_fes_active() ) :

				// Get the name of the store.
				$vendor_store = get_the_author_meta( 'name_of_store', $post->post_author );

				?>
			<h2 class="widget-title"><?php echo $vendor_store; ?></h2>
			<?php endif; ?>

		<?php endif; ?>

		<ul>

		<?php do_action( 'digifly_edd_sidebar_download_author_list_start', $options ); ?>

		<?php
		/**
		 * Author name.
		 */
		if ( true === $options['name'] ) :
			?>
			<li class="downloadAuthor-author">
				<span class="downloadAuthor-name"><?php _e( 'Author:', 'digifly' ); ?></span>
				<span class="downloadAuthor-value">
					<?php if ( digifly_is_edd_fes_active() ) : ?>
						<a class="vendor-url" href="<?php echo esc_url( $vendor_url ); ?>">
							<?php echo $author->display_name; ?>
						</a>
					<?php else : ?>
						<?php echo $author->display_name; ?>
					<?php endif; ?>
				</span>
			</li>
		<?php endif; ?>

		<?php
		/**
		 * Author signup date.
		 */
		if ( true === $options['signup_date'] ) :
			?>
			<li class="downloadAuthor-authorSignupDate">
				<span class="downloadAuthor-name"><?php _e( 'Author since:', 'digifly' ); ?></span>
				<span class="downloadAuthor-value"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $author->user_registered ) ); ?></span>
			</li>
		<?php endif; ?>

		<?php
		/**
		 * Author website.
		 */
		if ( true === $options['website'] ) :

			// Get the website.
			$website = get_the_author_meta( 'user_url', $post->post_author );

			?>

			<?php if ( ! empty( $website ) ) : ?>
			<li class="downloadAuthor-website">
				<span class="downloadAuthor-name"><?php _e( 'Website:', 'digifly' ); ?></span>
				<span class="downloadAuthor-value"><a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener"><?php echo esc_url( $website ); ?></a></span>
			</li>
			<?php endif; ?>

		<?php endif; ?>

		<?php do_action( 'digifly_edd_sidebar_download_author_list_end', $options ); ?>

		</ul>

		<?php
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		// Default settings.
		$defaults = array(
			'avatar'      => true,
			'store_name'  => true,
			'name'        => true,
			'signup_date' => true,
			'website'     => true,
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p class="digifly-widget-usage"><em><?php _e( 'Only for use in Download Sidebar', 'digifly' ); ?></em></p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'digifly' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'avatar' ) ); ?>" <?php checked( $instance['avatar'], true ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>"><?php _e( 'Show author avatar', 'digifly' ); ?></label>
		</p>

		<?php if ( digifly_is_edd_fes_active() ) : ?>
		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'store_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'store_name' ) ); ?>" <?php checked( $instance['store_name'], true ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'store_name' ) ); ?>"><?php _e( 'Show store name', 'digifly' ); ?></label>
		</p>
		<?php endif; ?>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" <?php checked( $instance['name'], true ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php _e( 'Show author name', 'digifly' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'signup_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'signup_date' ) ); ?>" <?php checked( $instance['signup_date'], true ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'signup_date' ) ); ?>"><?php _e( 'Show author signup date', 'digifly' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'website' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'website' ) ); ?>" <?php checked( $instance['website'], true ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'website' ) ); ?>"><?php _e( 'Show website', 'digifly' ); ?></label>
		</p>

		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {

		$instance                = $old_instance;
		$instance['title']       = ! empty( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['avatar']      = ! empty( $new_instance['avatar'] ) ? true : false;
		$instance['store_name']  = ! empty( $new_instance['store_name'] ) ? true : false;
		$instance['name']        = ! empty( $new_instance['name'] ) ? true : false;
		$instance['signup_date'] = ! empty( $new_instance['signup_date'] ) ? true : false;
		$instance['website']     = ! empty( $new_instance['website'] ) ? true : false;

		return $instance;
	}

}

/**
 * Register the widget.
 *
 * @since 1.0.0
 */
function digifly_register_widget_download_author() {
	register_widget( 'Digifly_Download_Author' );
}
add_action( 'widgets_init', 'digifly_register_widget_download_author' );

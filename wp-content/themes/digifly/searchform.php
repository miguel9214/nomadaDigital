<?php
/**
 * Template for displaying search forms in Digifly
 */
$digifly_unique_id   = esc_attr( uniqid( 'search-form-' ) );
$digifly_search_text = apply_filters( 'digifly_search_text', esc_attr_x( 'Search', 'placeholder', 'digifly' ) );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $digifly_unique_id; ?>">
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'digifly' ); ?></span>
		<input type="search" id="<?php echo $digifly_unique_id; ?>" class="search-field" placeholder="<?php echo $digifly_search_text; ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>

	<?php if ( apply_filters( 'digifly_show_search_button', true ) ) : ?>
	<button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'digifly' ); ?></span><?php echo digifly_Search::search_icon(); ?></button>
	<?php endif; ?>

</form>

<?php
/**
 * The template used for displaying a download's content.
 * Loaded by single-download.php
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'digifly_entry_article_start' ); ?>

	<?php
	if ( apply_filters( 'digifly_show_download_featured_image', true ) ) :
		digifly_post_thumbnail();
		endif;
	?>

	<div class="entry-content">

		<?php do_action( 'digifly_entry_content_start' ); ?>

		<?php the_content(); ?>

		<?php do_action( 'digifly_entry_content_end' ); ?>

	</div>
</article>

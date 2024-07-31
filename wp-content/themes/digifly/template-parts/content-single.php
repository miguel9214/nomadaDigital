<?php
/**
 * The template used for displaying page content
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * The featured image is loaded onto this hook
	 */
	do_action( 'digifly_article_start' );
	?>

	<div class="entry-content">

		<?php do_action( 'digifly_entry_content_start' ); ?>

		<?php the_content(); ?>

		<?php
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'digifly' ),
					'after'  => '</div>',
				)
			);
			?>

		<?php do_action( 'digifly_entry_content_end' ); ?>

	</div>

</article>

<?php
/**
 * The template part for displaying content
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php do_action( 'digifly_entry_header_start' ); ?>

		<div class="entry-header-title-meta">

			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php digifly_posted_on( false ); ?>

		</div>

		<?php do_action( 'digifly_entry_header_end' ); ?>
	</header>

	<?php digifly_post_thumbnail(); ?>

	<?php if ( ( is_search() || is_archive() ) && digifly_display_excerpts() ) : ?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

	<?php else : ?>

		<div class="entry-content">
			<?php
				/* translators: %s: Name of current post */
				the_content(
					sprintf(
						__( 'Continue reading %s', 'digifly' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					)
				);

				wp_link_pages(
					array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'digifly' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'digifly' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			?>
		</div>

	<?php endif; ?>

</article>

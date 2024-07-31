<?php
/**
 * The main template file
 */

$posts_layout = get_theme_mod( 'blog' );
$blog_page    = get_option( 'page_for_posts' );
$sidebars     = is_array( $posts_layout ) && isset( $posts_layout['sidebars'] ) ? $posts_layout['sidebars'] : '';
$posts_layout = is_array( $posts_layout ) && isset( $posts_layout['layout'] ) ? $posts_layout['layout'] : '';

if ( empty( $posts_layout ) ) {
	$posts_layout = 'standard';
}

if ( empty( $sidebars ) ) {
	$sidebars = 'right';
}

if ( 'no_sidebar' === $sidebars ) {
	$GLOBALS['digifly_no_sidebar'] = true;
}

if ( 'standard' !== $posts_layout ) {
	add_action( 'digifly_entry_header_end', 'digifly_add_readmore_button', 10 );
}

get_header(); ?>

<div class="content-wrapper<?php echo digifly_wrapper_classes(); ?>">

	<?php
	if ( 'left' === $sidebars ) {
		digifly_get_sidebar();
	}
	?>

	<div id="primary" class="content-area<?php echo digifly_primary_classes(); ?>">

		<main id="main" class="site-main" role="main">

			<?php if ( apply_filters( 'digifyly_show_blog_main_title', true ) ) : ?>
				<div class="blog-page-header">
					<h1><?php echo get_the_title( $blog_page ); ?></h1>
				</div>
			<?php endif; ?>

			<?php
			if ( have_posts() ) :

				if ( 'standard' !== $posts_layout ) :
					?>
					<div class="blog-posts-layout-<?php echo $posts_layout; ?>">
					<?php
					endif;

				while ( have_posts() ) :
					the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );

					endwhile;

				if ( 'standard' !== $posts_layout ) :
					?>
					</div>
					<?php
					endif;

				digifly_paging_nav();

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>

		</main>
	</div>

	<?php
	if ( 'right' === $sidebars ) {
		digifly_get_sidebar();
	}
	?>

</div>

<?php
get_footer();

<?php
/**
 * Template part for displaying content  in post.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moral
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-meta">
		    <?php
			blogbook_post_author(); 

			blogbook_posted_on(); 
		    ?>
		</div><!-- .entry-meta -->

	<header class="entry-header">
	    <h2 class="entry-title"><?php the_title();?></h2>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="featured-image">
		    <?php the_post_thumbnail( 'large', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
		</div><!-- .featured-image -->
	<?php endif; ?>

	<div class="entry-content">
        <?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'blogbook' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blogbook' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<div class="tags-read-more clear">
	    <?php blogbook_tags();?>

	    <?php blogbook_cats(); ?>

        <?php blogbook_entry_footer(); ?>
	</div><!-- .tags-read-more -->
</article><!-- #post-<?php the_ID(); ?> -->
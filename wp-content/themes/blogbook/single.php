<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Moral
 */

get_header(); ?>

    <div id="inner-content-wrapper" class="wrapper relative clear">
		
		<?php get_sidebar( 'left' );?>
		
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <div class="single-post-wrapper blog-posts">
					<?php
					while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content', 'single' );

						the_post_navigation( array(
								'prev_text'          => blogbook_get_svg( array( 'icon' => 'left-arrow' ) ) . '<span>%title</span>',
								'next_text'          => '<span>%title</span>' . blogbook_get_svg( array( 'icon' => 'left-arrow' ) ),
							) );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>
				</div>
			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>

    </div><!-- #inner-content-wrapper-->
<?php
get_footer();

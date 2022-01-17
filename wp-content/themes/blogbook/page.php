<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moral
 */

get_header(); ?>
	
	<div id="inner-content-wrapper" class="wrapper page-section">
		
		<?php get_sidebar( 'left' );?>

        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <div class="single-post-wrapper blog-posts">
					<?php
					while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content', 'page' );
						?>
						<?php
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

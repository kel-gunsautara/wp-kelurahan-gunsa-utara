<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moral
 */

get_header(); ?>
    <div id="inner-content-wrapper" class="wrapper relative clear">
			
			<?php get_sidebar( 'left' );?>

			<div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                    <div id="latest-posts" class="relative blog-posts">
                    	<div id="blogbook-infinite-scroll">
                    		
							<?php
							if ( have_posts() ) :

								/* Start the Loop */
								while ( have_posts() ) : the_post();

									/*
									 * Include the Post-Format-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
									 */
									get_template_part( 'template-parts/content', get_post_format() );

								endwhile;

								wp_reset_postdata();

							else :

								get_template_part( 'template-parts/content', 'none' );

							endif; ?>

                    	</div><!-- #blogbook-infinite-scroll -->
					</div><!-- .blog-posts-wrapper -->
					<?php blogbook_posts_pagination();?>
				</main><!-- #main -->
			</div><!-- #primary -->

			<?php get_sidebar();?>
	</div>
<?php get_footer();

<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Moral
 */

get_header(); ?>

    	<div id="inner-content-wrapper" class="wrapper relative clear">
        	
        	<?php get_sidebar( 'left' );?>

			<div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                    <div class="blog-posts">
                    	<div id="blogbook-infinite-scroll" class="blog-archive-wrapper">

						<?php
						/* Start the Loop */
						if ( have_posts() ) :
							while ( have_posts() ) : the_post();

								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content', get_post_format() );

							endwhile;

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif; ?>
						</div>
					</div><!-- .posts-wrapper -->
					<?php blogbook_posts_pagination();?>
				</main><!-- #main -->
			</div><!-- #primary -->
			
			<?php get_sidebar(); ?>
				
		</div>

<?php
get_footer();

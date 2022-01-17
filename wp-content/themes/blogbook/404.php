<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Moral
 */

get_header(); ?>
	<div id="inner-content-wrapper" class="wrapper relative clear">
        
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <div class="single-post-wrapper">

					<p><?php esc_html_e( 'Oops! That page can&rsquo;t be found. Maybe try a search?', 'blogbook' ); ?></p>

					<?php get_search_form(); ?>
				</div>
			</main><!-- #main -->
		</div><!-- #primary -->
        
    </div><!-- #inner-content-wrapper-->

<?php
get_footer();

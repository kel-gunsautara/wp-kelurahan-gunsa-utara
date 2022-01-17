<?php
/**
 * Template part for displaying featured posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moral
 */

$sticky_posts = get_option( 'sticky_posts' );  
$count = count( $sticky_posts );

if ( ! empty( $sticky_posts ) ) :
?>
    <div id="featured-posts" class="relative">
        <div class="wrapper">
            <?php if ( $count > 1 ) : ?>
                <div class="grid">
            <?php endif; ?>
                <?php 
                $args = array( 'posts_per_page' => 4, 'post__in' => $sticky_posts );
                $query = new WP_Query( $args );
                        
                if ( $query->have_posts() ) :
                    /* Start the Loop */
                    while ( $query->have_posts() ) : $query->the_post(); ?>
                        <?php if ( $count > 1 ) : ?>
                            <div class="grid-item">
                        <?php endif; ?>

                            <article class="has-featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'large' ); ?>');">
                                
                                <?php blogbook_cats( true );?>

                                <div class="entry-container">
                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
                                    </header>
                                    <div class="entry-meta">
                                        <?php blogbook_post_author( false );?>
                                        <?php blogbook_posted_on();?>
                                    </div><!-- .entry-meta -->
                                </div><!-- .entry-container -->  
                            </article> 

                        <?php if ( $count > 1 ) : ?>
                            </div><!-- .grid-item -->
                        <?php endif;
                    endwhile;
                    wp_reset_postdata();
                endif;
            if ( $count > 1 ) : ?>
                </div><!-- .grid -->
            <?php endif; ?>
        </div><!-- .wrapper -->
    </div><!-- #featured-posts -->
<?php
endif;

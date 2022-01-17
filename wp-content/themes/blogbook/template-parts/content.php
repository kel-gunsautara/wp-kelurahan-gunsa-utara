<?php
/**
 * Template part for displaying posts
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
		    <h2 class="entry-title">
    			<a href="<?php the_permalink();?>">
					<?php the_title(); ?>
    			</a>
		    </h2>
		</header>

		<?php if ( has_post_format( 'gallery', get_the_ID() ) ) : ?>
			<div class="entry-content">
			    <div class="images-gallery clear">
			    	<?php
					$attachments = get_post_gallery( get_the_ID(), false );
					if ( isset( $attachments['ids'] ) ) {
						$attachments = explode( ',', $attachments['ids'] );
				    	if ( count( $attachments ) > 4 ) {
					    	$first_four_attachments = array_slice( $attachments, 0, 4 );
					    	$remaining_attachments_count = count( array_slice( $attachments, 3 ) );
					    	$i = 0;
					    	foreach ( $first_four_attachments as $attachment ) { 
					    		?>
					        	<div class="gallery-image-item">
					        		<?php echo wp_get_attachment_image( $attachment, 'blogbook-gallery' ); ?>
						    		<?php if ( ++$i === 4 ) : ?>
					    				<a href="<?php the_permalink();?>"><span class="gallery-count"><?php echo esc_html( '+', 'blogbook' ) . absint( $remaining_attachments_count );?></span></a>
						    		<?php endif; ?>
					        	</div>
					    	<?php 
					    	} ?>
				    	<?php
				    	} else {
					    	foreach ( $attachments as $attachment ) { ?>
					        	<div class="gallery-image-item">
					        		<?php echo wp_get_attachment_image( $attachment, 'blogbook-gallery' ); ?>
					        	</div>
					    	<?php 
					    	} 
				    	}
					}
			    	?>
			    </div><!-- .images-gallery -->
			</div>
		<?php endif; ?>

	<?php
	if ( has_post_thumbnail() ) : ?>
		<div class="featured-image">
		    <a href="<?php the_permalink();?>"><?php the_post_thumbnail( 'large', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?></a>
		</div><!-- .featured-image -->
	<?php endif; ?>
	
	<div class="tags-read-more clear">
	    <?php blogbook_tags();?>

        <?php blogbook_entry_footer(); ?>

	    <div class="read-more">
	        <a href="<?php the_permalink();?>" class="btn"><?php echo esc_html( get_theme_mod( 'blogbook_archive_excerpt', esc_html__( 'Read More', 'blogbook' ) ) ); ?></a>
	    </div><!-- .read-more -->
	</div><!-- .tags-read-more -->
</article><!-- #post-<?php the_ID(); ?> -->

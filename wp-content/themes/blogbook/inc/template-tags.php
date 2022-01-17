<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Moral
 */

if ( ! function_exists( 'blogbook_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function blogbook_posted_on( $echo = true ) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

		if ( $echo ) {
			echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
		} else {
			return '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
		}

	}
endif;

if ( ! function_exists( 'blogbook_tags' ) ) :
	function blogbook_tags() {
		if ( 'post' === get_post_type() ) {
			if ( is_single() || ( blogbook_is_page_displays_posts() ) ) {
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'blogbook' ) );
				$tag_svg = blogbook_get_svg( array( 'icon' => 'tags' ) );
				$tags_list_arr = explode( ',', $tags_list );
				if ( $tags_list ) {
					if ( count( $tags_list_arr ) > 3 ) {
						$first_three_tags_arr = array_slice( $tags_list_arr, 0, 3 );
						$first_three_tags = implode( ', ', $first_three_tags_arr );

						$last_tags_arr = array_slice( $tags_list_arr, 3 );
						$last_tags = implode( '', $last_tags_arr );

						printf( '<span class="tags-links first-three">' . $tag_svg . '%1$s</span>', $first_three_tags ); // WPCS: XSS OK.
						printf( '<span class="more-tags"><span class="count">%1$s</span>',  __( ' , +', 'blogbook' ) . count( $last_tags_arr ) ); // WPCS: XSS OK.
						printf( '<span class="tags-links last-tags">%1$s</span></span>', $last_tags ); // WPCS: XSS OK.
					} else {
						/* translators: 1: list of tags. */
						printf( '<span class="tags-links">' . $tag_svg . '%1$s</span>', $tags_list ); // WPCS: XSS OK.
					}
				}
			}
		}
	}
endif;

if ( ! function_exists( 'blogbook_cats' ) ) :
	function blogbook_cats( $first_cat = false ) {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			if ( ( is_single() ) || ( blogbook_is_page_displays_posts() ) ) {
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( esc_html__( ', ', 'blogbook' ) );
				if ( $first_cat ) {
					$categories_list = explode( ',', $categories_list );
					$categories_list = $categories_list[0];
				}

				if ( $categories_list ) {
					$svg = '';
					if ( is_single() ) {
						$svg = blogbook_get_svg( array( 'icon' => 'cats' ) );
					}
					echo '<span class="cat-links">' . $svg . $categories_list . '</span> '; // WPCS: XSS OK.
				}
			}
		}

	}
endif;

if ( ! function_exists( 'blogbook_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function blogbook_entry_footer() {
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			if ( blogbook_is_page_displays_posts() ) {

				echo '<span class="comments-link">';      
				comments_popup_link(
					sprintf(
						wp_kses(
							/* translators: %s: post title */
							__( ' Leave a Comment<span class="screen-reader-text"> on %s</span>', 'blogbook' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					)
				);
				echo '</span>';
			}
		}
		
		if ( get_edit_post_link() ) {
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( ' Edit <span class="screen-reader-text">%s</span>', 'blogbook' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
		}
	}
endif;

if ( ! function_exists( 'blogbook_post_author' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function blogbook_post_author( $img_enable = true ) {
	$name = get_the_author();
	$author_img = '';
	if ( $img_enable ) {
		$author_img = get_avatar( get_the_author_meta( 'ID' ), 60, '404' );
		if ( $author_img ) {
			$author_img = $author_img;
		} else {
			$first_letter = mb_substr( $name, 0, 1, 'utf-8' );
			$author_img = '<span class="dropcap">' . esc_html( $first_letter ) . '</span>';
		}
	}

	$author_html = '<span class="byline"><span class="author vcard">' . $author_img . '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span></span>';
	echo $author_html;
}
endif;

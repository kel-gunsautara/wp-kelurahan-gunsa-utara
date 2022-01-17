<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Moral
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function blogbook_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
    	$classes[] = 'both-sidebar';
	} elseif( is_active_sidebar( 'sidebar-1' ) ) {
    	$classes[] = 'right-sidebar';

	} elseif( is_active_sidebar( 'sidebar-2' ) ) {
    	$classes[] = 'left-sidebar';
	} else {
    	$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'blogbook_body_classes' );

function blogbook_post_classes( $classes ) {
	if ( blogbook_is_page_displays_posts() ) {
		// Search 'has-post-thumbnail' returned by default and remove it.
		$key = array_search( 'has-post-thumbnail', $classes );
		unset( $classes[ $key ] );
		
		if( has_post_thumbnail() ) {
			$classes[] = 'has-post-thumbnail';
		} else {
			$classes[] = 'no-post-thumbnail';
		}
	}

	return $classes;
}
add_filter( 'post_class', 'blogbook_post_classes' );

/**
 * Excerpt length
 * 
 * @since Moral 1.0.0
 * @return Excerpt length
 */
function blogbook_excerpt_length( $length ){
	if ( is_admin() ) {
		return $length;
	}

	$length = get_theme_mod( 'blogbook_archive_excerpt_length', 60 );
	return $length;
}
add_filter( 'excerpt_length', 'blogbook_excerpt_length', 999 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function blogbook_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'blogbook_pingback_header' );

/**
 * Checks to see if we're on the homepage or not.
 */
function blogbook_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Your latest posts".
 */
function blogbook_is_latest_posts() {
	return ( is_front_page() && is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Posts page".
 */
function blogbook_is_frontpage_blog() {
	return ( is_home() && ! is_front_page() );
}

/**
 * Checks to see if the current page displays any kind of post listing.
 */
function blogbook_is_page_displays_posts() {
	return ( blogbook_is_frontpage_blog() || is_search() || is_archive() || blogbook_is_latest_posts() );
}

/**
 * Pagination in archive/blog/search pages.
 */
function blogbook_posts_pagination() { 
	$archive_pagination = get_theme_mod( 'blogbook_archive_pagination_type', 'numeric' );
	if ( 'disable' === $archive_pagination ) {
		return;
	}
	if ( 'numeric' === $archive_pagination ) {
		the_posts_pagination( array(
            'prev_text'          => blogbook_get_svg( array( 'icon' => 'left-arrow' ) ) . esc_html__( 'Previous', 'blogbook' ),
            'next_text'          => esc_html__( 'Next', 'blogbook' ) . blogbook_get_svg( array( 'icon' => 'left-arrow' ) ),
        ) );
	} elseif ( 'older_newer' === $archive_pagination ) {
        the_posts_navigation( array(
            'prev_text'          => blogbook_get_svg( array( 'icon' => 'left-arrow' ) ) . '<span>'. esc_html__( 'Older', 'blogbook' ) .'</span>',
            'next_text'          => '<span>'. esc_html__( 'Newer', 'blogbook' ) .'</span>' . blogbook_get_svg( array( 'icon' => 'left-arrow' ) ),
        )  );
	}
}

function blogbook_get_svg_by_url( $url = false ) {
	if ( ! $url ) {
		return false;
	}

	$social_icons = blogbook_social_links_icons();

	foreach ( $social_icons as $attr => $value ) {
		if ( false !== strpos( $url, $attr ) ) {
			return blogbook_get_svg( array( 'icon' => esc_attr( $value ) ) );
		}
	}
}

function blogbook_background_color() {
    $bg_color = get_background_color();
    $custom_css = '
        body {
            background-color: #' . esc_attr( $bg_color ) . '
        }';
    wp_add_inline_style( 'blogbook-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'blogbook_background_color' );

// Add comment svg before comment.
add_filter( 'comments_number', 'blogbook_add_comment_svg' );
function blogbook_add_comment_svg( $output ) {
    return blogbook_get_svg( array( 'icon' => 'comment' ) ) . $output;
}

/**
 * Hide the gravatar if id doesn't exists
 */
function blogbook_filter_avatar( $avatar, $id_or_email, $size, $default, $alt, $args ) 
{
    $headers = get_headers( $args['url'] );
    if ( ! is_admin() ) {
	    if( ! preg_match( "|200|", $headers[0] ) ) {
	        return;
	    }
    }

    return $avatar; 
}
add_filter( 'get_avatar','blogbook_filter_avatar', 10, 6 );
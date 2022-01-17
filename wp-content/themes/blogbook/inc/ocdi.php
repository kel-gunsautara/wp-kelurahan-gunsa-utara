<?php
/**
 * Moral OCDI plugin compatible functions
 *
 * @package Moral
 */

add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

function blogbook_intro_text( $default_text ) {
    $default_text .= sprintf( '<p class="about-description">%1$s <a href="%2$s">%3$s</a></p>', esc_html__( 'Demo content files for Blogbook Theme.', 'blogbook' ),
    esc_url( 'https://themepalace.com/instructions/themes/blogbook' ), esc_html__( 'Click here for Demo File download', 'blogbook' ) );

    return $default_text;
}
add_filter( 'pt-ocdi/plugin_intro_text', 'blogbook_intro_text' );
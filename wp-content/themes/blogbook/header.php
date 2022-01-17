<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Moral
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'wp_body_open' ); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'blogbook' ); ?></a>
    
        <div class="menu-overlay"></div>

        <header id="masthead" class="site-header" role="banner">
            <div id="site-details" class="wrapper">
                <div class="site-branding">
                    <div class="site-branding-wrapper">
                        <?php if ( has_custom_logo() ) : ?>
                            <div class="site-logo">
            					<?php the_custom_logo(); ?>
                            </div><!-- .site-logo -->
                        <?php endif; ?>

                        <div id="site-identity">
                            <?php
        					if ( is_front_page() ) : ?>
        						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
        					<?php else : ?>
        						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
        					<?php
        					endif;

        					$description = get_bloginfo( 'description', 'display' );
        					if ( $description || is_customize_preview() ) : ?>
        						<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
        					<?php endif; ?>
                        </div><!-- #site-identity -->
                    </div><!-- .site-branding-wrapper -->

                    <?php if ( has_nav_menu( 'social' ) ) : ?>
                        <div class="social-icons">
                            <?php
                            wp_nav_menu( array(
                                'theme_location' => 'social',
                                'menu_class'     => 'social-icons',
                                'container_class' => 'social-menu',
                                'depth'          => 1,
                                'link_before'    => '<span class="screen-reader-text">',
                                'link_after'     => '</span>' . blogbook_get_svg( array( 'icon' => 'chain' ) ),
                            ) );
                            ?>
                        </div>
                    <?php endif; ?>
                </div><!-- .site-branding -->
            </div><!-- .wrapper -->

            <div id="site-menu">
                <div class="wrapper">
                    <?php if ( has_nav_menu( 'primary' ) ) : ?>
                        <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html__( 'Primary Menu', 'blogbook' );?>">
                            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                                <span class="menu-label"><?php esc_html__( 'Menu', 'blogbook' );?></span>
                                <svg viewBox="0 0 40 40" class="icon-menu">
                                    <g>
                                        <rect y="7" width="40" height="2"/>
                                        <rect y="19" width="40" height="2"/>
                                        <rect y="31" width="40" height="2"/>
                                    </g>
                                </svg>
                                <svg viewBox="0 0 612 612" class="icon-close">
                                    <polygon points="612,36.004 576.521,0.603 306,270.608 35.478,0.603 0,36.004 270.522,306.011 0,575.997 35.478,611.397 
                                    306,341.411 576.521,611.397 612,575.997 341.459,306.011"/>
                                </svg>
                            </button>
                        <?php
    					wp_nav_menu( array(
    						'theme_location' => 'primary',
    						'menu_id'        => 'primary-menu',
    						'menu_class'	 => 'menu nav-menu',
    						'container'		 => 'nav',
    						'container_class' => 'main-navigation',
    						'container_id' => 'site-navigation',
                        ) );
                    elseif( current_user_can( 'edit_theme_options' ) ): ?>
                        <nav class="main-navigation" id="site-navigation">
                            <ul id="primary-menu" class="menu nav-menu">
                                <li><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>"><?php echo esc_html__( 'Add a menu', 'blogbook' );?></a></li>
                            </ul>
                    <?php endif; ?> 
                    </nav><!-- #site-navigation -->
                </div><!-- .wrapper -->
            </div><!-- #site-menu -->
        </header><!-- #masthead -->

    <?php 
    if ( ! is_single() && ! blogbook_is_latest_posts() ) : ?>
        <div id="page-site-header">
            <div class="wrapper">
                <header class="page-header">
                    <?php 
                    if ( blogbook_is_frontpage_blog() ) { ?>
                        <h1 class="page-title"><?php single_post_title(); ?></h1>
                    <?php } elseif ( is_page() ) {
                        the_title( '<h1 class="page-title">', '</h1>' );
                    } elseif ( is_archive() ) {
                        the_archive_title( '<h1 class="page-title">', '</h1>' );
                        the_archive_description( '<div class="archive-description">', '</div>' );
                    } elseif ( is_404() ) { ?>
                         <h1 class="page-title"><?php esc_html_e( '404', 'blogbook' ); ?></h1>
                    <?php } elseif ( is_search() ) { ?>
                        <h1 class="page-title"><?php
                            /* translators: %s: search query. */
                            printf( esc_html__( 'Search Results for: %s', 'blogbook' ), '<span>' . get_search_query() . '</span>' );
                        ?></h1>
                    <?php } ?>
                </header>
            </div><!-- .wrapper -->
        </div><!-- #page-site-header -->
    <?php endif; ?>
    
    <div id="content" class="site-content">    
        <?php 
        if ( is_front_page() ) {
            get_template_part( 'template-parts/featured', 'posts' );
        }
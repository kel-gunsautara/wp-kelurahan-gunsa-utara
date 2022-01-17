<?php
/**
 * Moral functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Moral
 */

if ( ! function_exists( 'blogbook_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function blogbook_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Moral, use a find and replace
		 * to change 'blogbook' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'blogbook' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		add_theme_support( "responsive-embeds" );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'blogbook' ),
			'social' => esc_html__( 'Social', 'blogbook' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'blogbook_custom_background_args', array(
			'default-color' => 'F6F6F6',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		add_image_size( 'blogbook-gallery', 245, 245, true );

		add_theme_support( 'post-formats', array( 
			'gallery', 'video', 'image' 
		) );

    	/*
    	 * This theme styles the visual editor to resemble the theme style,
    	 * specifically font, colors, and column width.
     	 */
    	add_editor_style( array( 'assets/css/editor-style.css', blogbook_fonts_url() ) );

    	// Gutenberg support
		add_theme_support( 'editor-color-palette', array(
	       	array(
				'name' => esc_html__( 'Blue', 'blogbook' ),
				'slug' => 'blue',
				'color' => '#5376bb',
	       	),
	       	array(
	           	'name' => esc_html__( 'Green', 'blogbook' ),
	           	'slug' => 'green',
	           	'color' => '#07d79c',
	       	),
	       	array(
	           	'name' => esc_html__( 'Orange', 'blogbook' ),
	           	'slug' => 'orange',
	           	'color' => '#ff8737',
	       	),
	       	array(
	           	'name' => esc_html__( 'Black', 'blogbook' ),
	           	'slug' => 'black',
	           	'color' => '#2f3633',
	       	),
	       	array(
	           	'name' => esc_html__( 'Grey', 'blogbook' ),
	           	'slug' => 'grey',
	           	'color' => '#82868b',
	       	),
	   	));

		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-font-sizes', array(
		   	array(
		       	'name' => esc_html__( 'small', 'blogbook' ),
		       	'shortName' => esc_html__( 'S', 'blogbook' ),
		       	'size' => 12,
		       	'slug' => 'small'
		   	),
		   	array(
		       	'name' => esc_html__( 'regular', 'blogbook' ),
		       	'shortName' => esc_html__( 'M', 'blogbook' ),
		       	'size' => 16,
		       	'slug' => 'regular'
		   	),
		   	array(
		       	'name' => esc_html__( 'larger', 'blogbook' ),
		       	'shortName' => esc_html__( 'L', 'blogbook' ),
		       	'size' => 36,
		       	'slug' => 'larger'
		   	),
		   	array(
		       	'name' => esc_html__( 'huge', 'blogbook' ),
		       	'shortName' => esc_html__( 'XL', 'blogbook' ),
		       	'size' => 48,
		       	'slug' => 'huge'
		   	)
		));
		add_theme_support('editor-styles');
		add_theme_support( 'wp-block-styles' );
	}
endif;
add_action( 'after_setup_theme', 'blogbook_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function blogbook_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'blogbook_content_width', 900 );
}
add_action( 'after_setup_theme', 'blogbook_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function blogbook_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'blogbook' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'blogbook' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'blogbook' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'blogbook' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	for ( $i=1; $i <= 4; $i++ ) { 
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Widget Area ', 'blogbook' )  . $i,
			'id'            => 'footer-' . $i,
			'description'   => esc_html__( 'Add widgets here.', 'blogbook' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}
add_action( 'widgets_init', 'blogbook_widgets_init' );

/**
 * Register custom fonts.
 */
function blogbook_fonts_url() {
	$fonts_url = '';

	$font_families = array();
	
	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Montserrat, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$roboto = _x( 'on', 'Roboto font: on or off', 'blogbook' );

	if ( 'off' !== $roboto ) {
		$font_families[] = 'Roboto: 300,400,500,700';
	}

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);

	$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles.
 */
function blogbook_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'blogbook-fonts', blogbook_fonts_url(), array(), null );

	// blocks
	wp_enqueue_style( 'blogbook-blocks', get_template_directory_uri() . '/assets/css/blocks.css' );

	wp_enqueue_style( 'blogbook-style', get_stylesheet_uri() );

	wp_enqueue_script( 'packery-pkgd', get_theme_file_uri( '/assets/js/packery.pkgd.js' ), array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'sticky-kit', get_theme_file_uri( '/assets/js/sticky-kit.js' ), array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'blogbook-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array(), '20151215', true );

	wp_enqueue_script( 'blogbook-skip-link-focus-fix', get_theme_file_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'blogbook-custom', get_theme_file_uri( '/assets/js/custom.js' ), array( 'jquery' ), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'blogbook_scripts' );

/**
 * Enqueue editor styles for Gutenberg
 *
 * @since Blogbook 1.0.0
 */
function blogbook_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'blogbook-block-editor-style', get_theme_file_uri( '/assets/css/editor-blocks.css' ) );
	// Add custom fonts.
	wp_enqueue_style( 'blogbook-fonts', blogbook_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'blogbook_block_editor_styles' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_parent_theme_file_path() . '/inc/jetpack.php';
}

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

/**
 * Widgets call
 */
require get_parent_theme_file_path( '/inc/widgets.php' );

/**
 * Admin welcome page
 */
require get_parent_theme_file_path( '/inc/welcome.php' );

/**
 * TGMPA call
 */
require get_parent_theme_file_path( '/inc/tgmpa/call.php' );

/**
 * OCDI compatibility.
 */
if ( class_exists( 'OCDI_Plugin' ) ) {
	require get_parent_theme_file_path( '/inc/ocdi.php' );
}

/**
 * Enqueue admin css.
 * @return [type] [description]
 */
function blogbook_load_custom_wp_admin_style( $hook ) {
	if ( 'appearance_page_blogbook-welcome' != $hook ) {
        return;
    }
    wp_register_style( 'blogbook-admin', get_theme_file_uri( 'assets/css/blogbook-admin.css' ), false, '1.0.0' );
    wp_enqueue_style( 'blogbook-admin' );
}
add_action( 'admin_enqueue_scripts', 'blogbook_load_custom_wp_admin_style' );

/**
 * Styles the header image and text displayed on the blog.
 *
 * @see blogbook_custom_header_setup().
 */
function blogbook_header_text_style() {
	// If we get this far, we have custom styles. Let's do this.
	$header_text_display = get_theme_mod( 'blogbook_header_text_display', true );
	?>
	<style type="text/css">
	<?php if ( ! $header_text_display ) : ?>
		#site-identity {
			display: none;
		}
	<?php endif; ?>

	.site-title a{
		color: <?php echo esc_attr( get_theme_mod( 'blogbook_header_title_color', '#5376bb' ) ); ?>;
	}
	.site-description {
		color: <?php echo esc_attr( get_theme_mod( 'blogbook_header_tagline', '#7b7b7b' ) ); ?>;
	}
	</style>
	<?php
}
add_action( 'wp_head', 'blogbook_header_text_style' );

/**
 * Custom comment walker
 *
 * @users Walker_Comment
 */
class Blogbook_Walker_Comment extends Walker_Comment {
	function html5_comment( $comment, $depth, $args ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php 
						$avatar = get_avatar( $comment, $args['avatar_size'], '404' );
						if ( $avatar ) {
							echo $avatar;
						} else {
							$name  = get_comment_author( $comment );
							$first_letter = mb_substr( $name, 0, 1, 'utf-8' );
							echo '<span class="dropcap">' . esc_html( $first_letter ) . '</span>';
						}
						?>

						<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'blogbook' ); ?></p>
						<?php endif; ?>

						<div class="comment-wrap">
							<?php
								/* translators: %s: comment author link */
								printf( __( '%s <span class="says">says:</span>', 'blogbook' ),
									sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) )
								);
							?>
							<div class="comment-content">
								<?php comment_text(); ?>
							</div><!-- .comment-content -->
						</div>
					</div><!-- .comment-author -->
				</footer><!-- .comment-meta -->

				<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>'
				) ) );
				?>
				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php
								/* translators: 1: comment date, 2: comment time */
								printf( __( '%1$s at %2$s', 'blogbook' ), esc_html( get_comment_date( '', $comment ) ), esc_html( get_comment_time() ) );
							?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit', 'blogbook' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-metadata -->
			</article><!-- .comment-body -->
<?php
	}
}

if ( ! function_exists( 'blogbook_exclude_featured_posts' ) ) {
    function blogbook_exclude_featured_posts( $query ) {
        if ( ! is_admin() && $query->is_main_query() && $query->is_home() && $query->is_front_page() ) {

            $sticky_posts = get_option( 'sticky_posts' );  
            if ( ! empty( $sticky_posts ) ) {
            	$query->set('post__not_in', $sticky_posts );
            }
            
            $query->set('ignore_sticky_posts', true );
        }
    }
}
add_action( 'pre_get_posts', 'blogbook_exclude_featured_posts' );
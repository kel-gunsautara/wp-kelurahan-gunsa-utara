<?php
/**
 * Moral Theme Customizer
 *
 * @package Moral
 */

/**
 * Get all the default values of the theme mods.
 */
function blogbook_get_default_mods() {
	$blogbook_default_mods = array(

		// Footer copyright
		'blogbook_copyright_txt' => sprintf( esc_html__( 'Theme: %1$s by %2$s.', 'blogbook' ), 'Blogbook', '<a href="' . esc_url( 'http://moralthemes.com/' ) . '">Moral Themes</a>' ),

	);

	return apply_filters( 'blogbook_default_mods', $blogbook_default_mods );
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blogbook_customize_register( $wp_customize ) {

	$default = blogbook_get_default_mods();

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'blogbook_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'blogbook_customize_partial_blogdescription',
		) );
	}

	/**
	 *
	 * 
	 * Header panel
	 *
	 * 
	 */
	// Header panel
	$wp_customize->add_panel(
		'blogbook_header_panel',
		array(
			'title' => esc_html__( 'Header', 'blogbook' ),
			'priority' => 100
		)
	);

	$wp_customize->get_section( 'title_tagline' )->panel         = 'blogbook_header_panel';

	// Header text display setting
	$wp_customize->add_setting(	
		'blogbook_header_text_display',
		array(
			'sanitize_callback' => 'blogbook_sanitize_checkbox',
			'default' => true,
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'blogbook_header_text_display',
		array(
			'section'		=> 'title_tagline',
			'type'			=> 'checkbox',
			'label'			=> esc_html__( 'Display Site Title and Tagline', 'blogbook' ),
		)
	);

	/**
	 *
	 * General settings panel
	 * 
	 */
	// General settings panel
	$wp_customize->add_panel(
		'blogbook_general_panel',
		array(
			'title' => esc_html__( 'Advanced Settings', 'blogbook' ),
			'priority' => 107
		)
	);

	$wp_customize->get_section( 'colors' )->panel         = 'blogbook_general_panel';
	
	// Header title color setting
	$wp_customize->add_setting(	
		'blogbook_header_title_color',
		array(
			'sanitize_callback' => 'blogbook_sanitize_hex_color',
			'default' => '#5376bb',
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control( 
		$wp_customize,
			'blogbook_header_title_color',
			array(
				'section'		=> 'colors',
				'label'			=> esc_html__( 'Site title Color:', 'blogbook' ),
			)
		)
	);

	// Header tagline color setting
	$wp_customize->add_setting(	
		'blogbook_header_tagline',
		array(
			'sanitize_callback' => 'blogbook_sanitize_hex_color',
			'default' => '#7b7b7b',
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control( 
		$wp_customize,
			'blogbook_header_tagline',
			array(
				'section'		=> 'colors',
				'label'			=> esc_html__( 'Site tagline Color:', 'blogbook' ),
			)
		)
	);

	$wp_customize->get_section( 'background_image' )->panel         = 'blogbook_general_panel';
	$wp_customize->get_section( 'custom_css' )->panel         = 'blogbook_general_panel';

	/**
	 * General settings
	 */
	// General settings
	$wp_customize->add_section(
		'blogbook_general_section',
		array(
			'title' => esc_html__( 'General', 'blogbook' ),
			'panel' => 'blogbook_general_panel',
		)
	);

	// Backtop enable setting
	$wp_customize->add_setting(
		'blogbook_back_to_top_enable',
		array(
			'sanitize_callback' => 'blogbook_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'blogbook_back_to_top_enable',
		array(
			'section'		=> 'blogbook_general_section',
			'label'			=> esc_html__( 'Enable Scroll up.', 'blogbook' ),
			'type'			=> 'checkbox',
		)
	);

	/**
	 * Blog/Archive section 
	 */
	// Blog/Archive section 
	$wp_customize->add_section(
		'blogbook_archive_settings',
		array(
			'title' => esc_html__( 'Archive/Blog', 'blogbook' ),
			'description' => esc_html__( 'Settings for archive pages including blog page too.', 'blogbook' ),
			'panel' => 'blogbook_general_panel',
		)
	);

	// Archive excerpt setting
	$wp_customize->add_setting(
		'blogbook_archive_excerpt',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => esc_html__( 'Read More', 'blogbook' ),
		)
	);

	$wp_customize->add_control(
		'blogbook_archive_excerpt',
		array(
			'section'		=> 'blogbook_archive_settings',
			'label'			=> esc_html__( 'Excerpt more text:', 'blogbook' ),
		)
	);

	// Archive excerpt length setting
	$wp_customize->add_setting(
		'blogbook_archive_excerpt_length',
		array(
			'sanitize_callback' => 'blogbook_sanitize_number_range',
			'default' => 60,
		)
	);

	$wp_customize->add_control(
		'blogbook_archive_excerpt_length',
		array(
			'section'		=> 'blogbook_archive_settings',
			'label'			=> esc_html__( 'Excerpt more length:', 'blogbook' ),
			'type'			=> 'number',
			'input_attrs'   => array( 'min' => 5 ),
		)
	);

	// Pagination type setting
	$wp_customize->add_setting(
		'blogbook_archive_pagination_type',
		array(
			'sanitize_callback' => 'blogbook_sanitize_select',
			'default' => 'numeric',
		)
	);

	$archive_pagination_description = '';
	$archive_pagination_choices = array( 
				'disable' => esc_html__( '--Disable--', 'blogbook' ),
				'numeric' => esc_html__( 'Numeric', 'blogbook' ),
				'older_newer' => esc_html__( 'Older / Newer', 'blogbook' ),
			);
	if ( ! class_exists( 'JetPack' ) ) {
		$archive_pagination_description = sprintf( esc_html__( 'We recommend to install %1$sJetpack%2$s and enable %3$sInfinite Scroll%4$s feature for automatic loading of posts.', 'blogbook' ), '<a target="_blank" href="http://wordpress.org/plugins/jetpack">', '</a>', '<b>', '</b>' );
	} else {
		$archive_pagination_choices['infinite_scroll'] = esc_html__( 'Infinite Load', 'blogbook' );
	}
	$wp_customize->add_control(
		'blogbook_archive_pagination_type',
		array(
			'section'		=> 'blogbook_archive_settings',
			'label'			=> esc_html__( 'Pagination type:', 'blogbook' ),
			'description'			=>  $archive_pagination_description,
			'type'			=> 'select',
			'choices'		=> $archive_pagination_choices,
		)
	);
}
add_action( 'customize_register', 'blogbook_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function blogbook_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function blogbook_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blogbook_customize_preview_js() {
	wp_enqueue_script( 'blogbook-customizer', get_theme_file_uri( '/assets/js/customizer.js' ), array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'blogbook_customize_preview_js' );

/**
 *
 * Sanitization callbacks.
 * 
 */

/**
 * Checkbox sanitization callback example.
 * 
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function blogbook_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}


/**
 * HEX Color sanitization callback example.
 *
 * - Sanitization: hex_color
 * - Control: text, WP_Customize_Color_Control
 *
 */
function blogbook_sanitize_hex_color( $hex_color, $setting ) {
	// Sanitize $input as a hex value without the hash prefix.
	$hex_color = sanitize_hex_color( $hex_color );
	
	// If $input is a valid hex value, return it; otherwise, return the default.
	return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
}

/**
 * Select sanitization callback example.
 *
 * - Sanitization: select
 * - Control: select, radio
 */
function blogbook_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Number Range sanitization callback example.
 *
 * - Sanitization: number_range
 * - Control: number, tel
 * 
 */
function blogbook_sanitize_number_range( $number, $setting ) {
	
	// Ensure input is an absolute integer.
	$number = absint( $number );
	
	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;
	
	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
	
	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
	
	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
	
	// If the number is within the valid range, return it; otherwise, return the default
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}
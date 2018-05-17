<?php
/**
 * Registers a selection of social network links with the theme customizer
 *
 * @param      object    $wp_customize    The WordPress Theme Customizer
 */
function ppt_register_social_links( $wp_customize ) {
	$social_networks = array(
		'Instagram',
		'Twitter',
		'Facebook',
		'Snapchat',
		'Google+',
		'Pinterest',
		'YouTube',
		'LinkedIn',
		'Flickr',
		'Medium',
		'Tumblr',
		'GitHub',
	);

	$wp_customize->add_section(
		'ppt_social_links',
		array(
			'title'     => 'Social Links',
			'priority'  => 30
		)
	);

	foreach ( $social_networks as $network ) {
		$link_class = 'ppt_social_'.preg_replace( '[^a-z]', '', strtolower( $network ) );

		$wp_customize->add_setting(
			$link_class,
			array(
				'default'            => '',
				'sanitize_callback'  => 'ppt_sanitize_input',
				'transport'          => 'refresh'
			)
		);
		$wp_customize->add_control(
			$link_class,
			array(
				'section'  => 'ppt_social_links',
				'label'    => $network,
				'type'     => 'text'
			)
		);
	}
}

/**
 * Registers options with the Theme Customizer
 *
 * @param      object    $wp_customize    The WordPress Theme Customizer
 * @package    Pillar Press
 * @since      1.0.0
 * @version    1.0.0
 */
function ppt_register_theme_customizer( $wp_customize ) {
	/* Link Color */
	$wp_customize->add_setting(
		'ppt_link_color',
		array(
			'default'           => '#4E5C6B',
			'sanitize_callback' => 'ppt_sanitize_input',
			'transport'         => 'refresh'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_color',
			array(
			    'label'    => 'Link Color',
			    'section'  => 'colors',
			    'settings' => 'ppt_link_color'
			)
		)
	);

	/* Header Background Color */
	$wp_customize->add_setting(
		'ppt_header_background_color',
		array(
			'default'           => '#222',
			'sanitize_callback' => 'ppt_sanitize_input',
			'transport'         => 'refresh'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_background_color',
			array(
			    'label'    => 'Header Background Color',
			    'section'  => 'colors',
			    'settings' => 'ppt_header_background_color'
			)
		)
	);


	/*-----------------------------------------------------------*
	 * Defining our own 'Social Links' section
	 *-----------------------------------------------------------*/
	ppt_register_social_links( $wp_customize );

	/*-----------------------------------------------------------*
	 * Defining our own 'Display Options' section
	 *-----------------------------------------------------------*/
	$wp_customize->add_section(
		'ppt_display_options',
		array(
			'title'    => 'Display Options',
			'priority' => 40
		)
	);

	/* Show or Hide post excerpt */
	$wp_customize->add_setting(
		'ppt_post_excerpt',
		array(
			'default'           => 'hide',
			'sanitize_callback' => 'ppt_sanitize_input',
			'transport'         => 'refresh'
		)
	);
	$wp_customize->add_control(
		'ppt_post_excerpt',
		array(
			'section' => 'ppt_display_options',
			'label'   => 'Post Excerpts',
			'type'    => 'radio',
			'choices' => array(
				'hide' => 'Hide',
				'show' => 'Show'
			)
		)
	);

	/* Darken Header? */
	$wp_customize->add_setting(
		'ppt_darken_header',
		array(
			'default'           => 'no',
			'sanitize_callback' => 'ppt_sanitize_input',
			'transport'         => 'refresh'
		)
	);
	$wp_customize->add_control(
		'ppt_darken_header',
		array(
			'section' => 'ppt_display_options',
			'label'   => 'Darken Header?',
			'type'    => 'radio',
			'choices' => array(
				'no'  => 'No',
				'yes' => 'Yes'
			)
		)
	);

	/* Parallax Header? */
	$wp_customize->add_setting(
		'ppt_parallax_header',
		array(
			'default'           => 'no',
			'sanitize_callback' => 'ppt_sanitize_input',
			'transport'         => 'refresh'
		)
	);
	$wp_customize->add_control(
		'ppt_parallax_header',
		array(
			'section' => 'ppt_display_options',
			'label'   => 'Parallax Header?',
			'type'    => 'radio',
			'choices' => array(
				'no'  => 'No',
				'yes' => 'Yes'
			)
		)
	);

	/* Display Copyright */
	$wp_customize->add_setting(
		'ppt_footer_copyright_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'ppt_sanitize_copyright',
			'transport'         => 'refresh'
		)
	);
	$wp_customize->add_control(
		'ppt_footer_copyright_text',
		array(
			'section' => 'ppt_display_options',
			'label'   => 'Copyright Message',
			'type'    => 'text'
		)
	);

	/*-----------------------------------------------------------*
	 * Defining our own 'Home Intro' section
	 *-----------------------------------------------------------*/
	$wp_customize->add_section(
		'ppt_homeintro_options',
		array(
			'title'    => 'Home Intro',
			'priority' => 20
		)
	);

	/* Background Image */
	$wp_customize->add_setting(
		'ppt_homeintro_image',
		array(
		    'default'           => get_template_directory_uri() . '/img/home-bg.jpg',
				'sanitize_callback' => 'ppt_sanitize_input',
		    'transport'         => 'refresh'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'ppt_homeintro_image',
			array(
			    'label'    => 'Background Image',
			    'settings' => 'ppt_homeintro_image',
			    'section'  => 'ppt_homeintro_options'
			)
		)
	);

	/* Home Intro Title */
	$wp_customize->add_setting(
		'ppt_homeintro_title',
		array(
			'default'           => '',
			'sanitize_callback' => 'ppt_sanitize_input',
			'transport'         => 'refresh'
		)
	);
	$wp_customize->add_control(
		'ppt_homeintro_title',
		array(
			'section' => 'ppt_homeintro_options',
			'label'   => 'Title',
			'type'    => 'text'
		)
	);

	/* Home Intro Subtitle */
	$wp_customize->add_setting(
		'ppt_homeintro_subtitle',
		array(
			'default'           => '',
			'sanitize_callback' => 'ppt_sanitize_input',
			'transport'         => 'refresh'
		)
	);
	$wp_customize->add_control(
		'ppt_homeintro_subtitle',
		array(
			'section' => 'ppt_homeintro_options',
			'label'   => 'Subtitle',
			'type'    => 'text'
		)
	);

} // end ppt_register_theme_customizer

add_action( 'customize_register', 'ppt_register_theme_customizer' );
/**
 * Sanitizes the incoming input and returns it prior to serialization.
 *
 * @param      string    $input    The string to sanitize
 * @return     string              The sanitized string
 * @package    Pillar Press
 * @since      1.0.0
 * @version    1.0.0
 */
function ppt_sanitize_input( $input ) {
	return strip_tags( stripslashes( $input ) );
} // end ppt_sanitize_input

function ppt_sanitize_copyright( $input ) {
	$allowed = array(
		's'      => array(),
		'br'     => array(),
		'em'     => array(),
		'i'      => array(),
		'strong' => array(),
		'b'      => array(),
		'a'      => array(
			'href'  => array(),
			'title' => array(),
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'form' => array(
			'id'           => array(),
			'class'        => array(),
			'action'       => array(),
			'method'       => array(),
			'autocomplete' => array(),
			'style'        => array(),
		),
		'input' => array(
			'type'        => array(),
			'name'        => array(),
			'class'       => array(),
			'id'          => array(),
			'value'       => array(),
			'placeholder' => array(),
			'tabindex'    => array(),
			'style'       => array(),
		),
		'img' => array(
			'src'    => array(),
			'alt'    => array(),
			'class'  => array(),
			'id'     => array(),
			'style'  => array(),
			'height' => array(),
			'width'  => array(),
		),
		'span' => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'p' => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'div' => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'blockquote' => array(
			'cite'  => array(),
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
	);
    return wp_kses( $input, $allowed );
} // end ppt_sanitize_copyright

/**
 * Writes styles out the `<head>` element of the page based on the configuration options
 * saved in the Theme Customizer.
 *
 * @since      1.0.0
 * @version    1.0.0
 */
function ppt_customizer_css() {
?>
	<style type="text/css">
		-moz-selection,
		::selection{
			background: <?php echo get_theme_mod( 'ppt_link_color' ); ?>;
		}
		body{
			webkit-tap-highlight-color: <?php echo get_theme_mod( 'ppt_link_color' ); ?>;
		}
		a:hover {
			color: <?php echo get_theme_mod( 'ppt_link_color' ); ?>;
		}
		.pager li>a:hover, .pager li>a:focus {
			color: #fff;
			background-color: <?php echo get_theme_mod( 'ppt_link_color' ); ?>;
			border: 1px solid <?php echo get_theme_mod( 'ppt_link_color' ); ?>;
		}

		button:hover,
		input[type="button"]:hover,
		input[type="reset"]:hover,
		input[type="submit"]:hover {
			background: <?php echo get_theme_mod( 'ppt_link_color' ); ?>;
			border-color: <?php echo get_theme_mod( 'ppt_link_color' ); ?>;
		}

		button:focus,
		input[type="button"]:focus,
		input[type="reset"]:focus,
		input[type="submit"]:focus,
		button:active,
		input[type="button"]:active,
		input[type="reset"]:active,
		input[type="submit"]:active {
			background: <?php echo get_theme_mod( 'ppt_link_color' ); ?>;
			border-color: <?php echo get_theme_mod( 'ppt_link_color' ); ?>;
		}

		input[type="text"]:focus,
		input[type="email"]:focus,
		input[type="url"]:focus,
		input[type="password"]:focus,
		input[type="search"]:focus,
		textarea:focus {
			border: 1px solid <?php echo get_theme_mod( 'ppt_link_color' ); ?>;
		}

		.navbar-custom.is-fixed .nav li a:hover, .navbar-custom.is-fixed .nav li a:focus {
			color: <?php echo get_theme_mod( 'ppt_link_color' ); ?>;
		}

		<?php if ( get_theme_mod( 'ppt_darken_header' ) !== 'no' ) { ?>
		body.admin-bar .navbar-custom.is-fixed { top:-32px; }

		header.intro-header { position: relative; }

		header.intro-header .row {
		z-index: 3;
		position: relative;
		}

		header.intro-header .container:after {
		background: rgba(0,0,0,0.2);
		z-index: 2;
		content: '';
		width: 100%;
		height: 100%;
		display: block;
		position: absolute;
		top: 0;
		left: 0;
		}

		@media only screen and (min-width: 1170px)
		.navbar-custom {
		z-index: 9999;
		}
		<?php } ?>
		<?php if ( get_theme_mod( 'ppt_parallax_header' ) !== 'no' ) { ?>
		.intro-header {
			background-attachment: fixed;
		}
		<?php } ?>
	</style>
<?php
} // end ppt_customizer_css
add_action( 'wp_head', 'ppt_customizer_css' );

/**
 * Registers the Theme Customizer Preview with WordPress.
 *
 * @package    Pillar Press
 * @since      1.0.0
 * @version    1.0.0
 */
function ppt_customizer_live_preview() {
	wp_enqueue_script(
		'ppt-theme-customizer',
		get_template_directory_uri() . '/js/customizer.js',
		array( 'customize-preview' ),
		'1.0.0',
		true
	);
} // end ppt_customizer_live_preview
add_action( 'customize_preview_init', 'ppt_customizer_live_preview' );

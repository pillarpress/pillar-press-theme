<?php
/**
 * Pillar Press - Theme functions and definitions
 *
 * @package Pillar Press
 */

if ( ! function_exists( 'ppt_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ppt_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'pillar-press', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'pillar-press' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ppt_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Adds theme support for wide and full Gutenberg blocks.
	add_theme_support( 'align-wide' );

	// Add custom Gutenberg Editor color palette.
	add_theme_support( 'editor-color-palette',
		'#f9f9f9',
		'#555555',
		get_theme_mod( 'ppt_link_color' ),
		get_theme_mod( 'ppt_header_background_color' )
	);

}
endif; // ppt_setup
add_action( 'after_setup_theme', 'ppt_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ppt_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ppt_content_width', 750 );
}
add_action( 'after_setup_theme', 'ppt_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function ppt_scripts() {
	wp_enqueue_style( 'pillar-press-style', get_stylesheet_uri() );
	wp_enqueue_style( 'pillar-press-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'pillar-press-theme', get_template_directory_uri() . '/css/pp-theme.min.css' );
	wp_enqueue_style( 'pillar-press-google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,300,400,600,700,800|Vollkorn:400,600,900' );

	wp_enqueue_script( 'pillar-press-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20180517', true );
	wp_enqueue_script( 'pillar-press-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20180517', true );
	wp_enqueue_script( 'pillar-press-jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), '20180517', true );
	wp_enqueue_script( 'pillar-press-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '20180517', true );
	wp_enqueue_script( 'pillar-press-theme', get_template_directory_uri() . '/js/pp-theme.min.js', array(), '20180517', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ppt_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Remove container DIV from navigation menu in header.
 */
function ppt_wp_nav_menu_args( $args = '' ) {
	$args['container'] = false;
	return $args;
}
add_filter( 'wp_nav_menu_args', 'ppt_wp_nav_menu_args' );

/**
 * Customizing the excerpt
 */

// Customize the excerpt length.
function ppt_excerpt_length( $length ) {
	return 60;
}
add_filter( 'excerpt_length', 'ppt_excerpt_length', 999 );

// Add a Read More link to the end of the excerpt.
function ppt_excerpt_more_link( $more ) {
	return ' ... <a class="read-more" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Read More', 'pillar-press' ) . '</a>';
}
add_filter( 'excerpt_more', 'ppt_excerpt_more_link' );

// Add a class to the <p> wrap around the excerpt.
function ppt_add_class_to_excerpt( $excerpt ) {
    return str_replace( '<p', '<p class="excerpt"', $excerpt );
}
add_filter( "the_excerpt", "ppt_add_class_to_excerpt" );

/**
 * Add a `gutenberg-page` class to pages using Gutenberg.
 */
add_action(
  'body_class', function( $classes ) {
    if ( function_exists( 'the_gutenberg_project' ) && gutenberg_post_has_blocks( get_the_ID() ) ) {
      $classes[] = 'gutenberg-page';
    }
    return $classes;
  }
);

<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package Pillar Press
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function ppt_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'ppt_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function ppt_jetpack_setup
add_action( 'after_setup_theme', 'ppt_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function ppt_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function ppt_infinite_scroll_render

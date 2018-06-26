<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Pillar Press
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses ppt_header_style()
 * @uses ppt_admin_header_style()
 * @uses ppt_admin_header_image()
 */
function ppt_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'ppt_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => 'FFF',
		'width'                  => 1900,
		'height'                 => 872,
		'flex-height'            => true,
		'wp-head-callback'       => 'ppt_header_style',
		'admin-head-callback'    => 'ppt_admin_header_style',
		'admin-preview-callback' => 'ppt_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'ppt_custom_header_setup' );

if ( ! function_exists( 'ppt_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see ppt_custom_header_setup().
 */
function ppt_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1 {
		}
		#headimg h1 a {
		}
		#desc {
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // ppt_admin_header_style

if ( ! function_exists( 'ppt_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see ppt_custom_header_setup().
 */
function ppt_admin_header_image() {
?>
	<div id="headimg">
		<h1 class="displaying-header-text">
			<a id="name" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html( bloginfo( 'name' ) ); ?></a>
		</h1>
		<div class="displaying-header-text" id="desc" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>"><?php esc_html( bloginfo( 'description' ) ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php esc_url( header_image() ); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // ppt_admin_header_image

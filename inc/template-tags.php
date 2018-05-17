<?php
/**
 * Custom template tags for this theme.
 *
 * @package Pillar Press
 */

if ( ! function_exists( 'ppt_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function ppt_posts_navigation() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<ul class="pager">
		<?php if ( get_next_posts_link() ) : ?>
		<li class="next"><?php next_posts_link( esc_html__( 'Older posts', 'pillar-press' ) ); ?></li>
		<?php endif; ?>
		<?php if ( get_previous_posts_link() ) : ?>
		<li class="previous"><?php previous_posts_link( esc_html__( 'Newer posts', 'pillar-press' ) ); ?></li>
		<?php endif; ?>
	</ul>
	<?php
}
endif;

if ( ! function_exists( 'the_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'pillar-press' ); ?></h2>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
				next_post_link( '<div class="nav-next">%link</div>', '%title' );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'ppt_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function ppt_posted_on() {
	$author_id = '';
	if (is_singular()) {
		$author_id = get_queried_object()->post_author;
	}

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

	$posted_on = sprintf(
		esc_html_x( 'on %s', 'post date', 'pillar-press' ),
		$time_string
	);

	$byauthor = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author_id ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'pillar-press' ), get_the_author_meta( "display_name", $author_id ) ) ),
		get_the_author_meta( "display_name", $author_id )
	);

	$byline = sprintf(
		esc_html_x( 'Posted by %s', 'posted by', 'pillar-press' ),
		$byauthor
	);

	echo '<span class="byline"> ' . $byline . '</span> <span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'ppt_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function ppt_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'pillar-press' ) );
		if ( $categories_list && ppt_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s &nbsp;&middot;&nbsp; ', 'pillar-press' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'pillar-press' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'pillar-press' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'pillar-press' ), esc_html__( '1 Comment', 'pillar-press' ), esc_html__( '% Comments', 'pillar-press' ) );
		echo '</span>';
	}

	edit_post_link( esc_html__( 'Edit', 'pillar-press' ), '<span class="edit-link"> &nbsp;&middot;&nbsp; ', '</span>' );
}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( esc_html__( 'Category: %s', 'pillar-press' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( esc_html__( 'Tag: %s', 'pillar-press' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( esc_html__( 'Author: %s', 'pillar-press' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( esc_html__( 'Year: %s', 'pillar-press' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'pillar-press' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( esc_html__( 'Month: %s', 'pillar-press' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'pillar-press' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( esc_html__( 'Day: %s', 'pillar-press' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'pillar-press' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = esc_html_x( 'Asides', 'post format archive title', 'pillar-press' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = esc_html_x( 'Galleries', 'post format archive title', 'pillar-press' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = esc_html_x( 'Images', 'post format archive title', 'pillar-press' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = esc_html_x( 'Videos', 'post format archive title', 'pillar-press' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = esc_html_x( 'Quotes', 'post format archive title', 'pillar-press' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = esc_html_x( 'Links', 'post format archive title', 'pillar-press' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = esc_html_x( 'Statuses', 'post format archive title', 'pillar-press' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = esc_html_x( 'Audio', 'post format archive title', 'pillar-press' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = esc_html_x( 'Chats', 'post format archive title', 'pillar-press' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( esc_html__( 'Archives: %s', 'pillar-press' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( esc_html__( '%1$s: %2$s', 'pillar-press' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = esc_html__( 'Archives', 'pillar-press' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;  // WPCS: XSS OK.
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;  // WPCS: XSS OK.
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function ppt_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'ppt_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'ppt_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so ppt_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so ppt_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in ppt_categorized_blog.
 */
function ppt_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'ppt_categories' );
}
add_action( 'edit_category', 'ppt_category_transient_flusher' );
add_action( 'save_post',     'ppt_category_transient_flusher' );

if ( ! function_exists( 'ppt_header' ) ) :
/**
 * Custom header codes for the home page, single posts and pages
 */
function ppt_header() {
	global $post;
?>

	<?php if( is_single() ) { ?>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
	<?php
		$feat_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	?>
    <header class="intro-header" style="background-color: <?php echo get_theme_mod( 'ppt_header_background_color' ); ?>; background-image: url('<?php echo $feat_image; ?>')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1><?php single_post_title(); ?></h1>
												<?php if ( function_exists( 'the_subtitle' ) ) {
													the_subtitle( '<h2 class="subheading">', '</h2>' );
												} ?>
                        <span class="meta"><?php ppt_posted_on(); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

	<?php } elseif ( is_page_template( 'page-builder.php' ) ) { ?>

	<?php } elseif ( is_page() ) { ?>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
	<?php
		$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	?>
    <header class="intro-header" style="background-color: <?php echo get_theme_mod( 'ppt_header_background_color' ); ?>; background-image: url('<?php echo $feat_image; ?>')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1><?php single_post_title(); ?></h1>
                        <hr class="small">
												<?php if ( function_exists( 'the_subtitle' ) ) {
													the_subtitle( '<span class="subheading">', '</span>' );
												} ?>
                    </div>
										<!-- /.site-heading -->
                </div>
								<!-- /.col-lg-8.col-lg-offset-2.col-md-10.col-md-offset-1 -->
            </div>
						<!-- /.row -->
        </div>
				<!-- /.container -->
    </header>

	<?php } elseif( is_search() ) { ?>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-color: <?php echo get_theme_mod( 'ppt_header_background_color' ); ?>;')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1><?php esc_html_e( 'Search Results', 'pillar-press' ); ?></h1>
                        <hr class="small">
                        <span class="subheading"><?php printf( esc_html__( 'You searched for: "%s"', 'pillar-press' ), '<span>' . get_search_query() . '</span>' ); ?></span>
                    </div>
		    						<!-- /.site-heading -->
                </div>
								<!-- /.col-lg-8.col-lg-offset-2.col-md-10.col-md-offset-1 -->
            </div>
						<!-- /.row -->
        </div>
				<!-- /.container -->
    </header>

	<?php } else { ?>

	  <!-- Page Header -->
	  <!-- Set your background image for this header on the line below. -->
		<?php if ( get_theme_mod( 'ppt_homeintro_image' ) !='' ) { ?>
		<?php $headerimg = get_theme_mod( 'ppt_homeintro_image' ); ?>
		<?php } else { ?>
		<?php $headerimg = get_template_directory_uri() . '/img/home-bg.jpg'; ?>
		<?php } ?>
    <header class="intro-header" style="background-color: <?php echo get_theme_mod( 'ppt_header_background_color' ); ?>; background-image: url('<?php echo $headerimg; ?>')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
												<?php if ( get_theme_mod( 'ppt_homeintro_title' ) !='' ) { ?>
												<h1 class="homeintro"><?php echo get_theme_mod( 'ppt_homeintro_title' ); ?></h1>
												<?php } else { ?>
                        <h1><?php esc_html_e( 'Pillar Press', 'pillar-press' ); ?></h1>
												<?php } ?>
                        <hr class="small">
												<?php if (get_theme_mod( 'ppt_homeintro_subtitle' ) !='') { ?>
                        <span class="subheading"><?php echo get_theme_mod( 'ppt_homeintro_subtitle' ); ?></span>
												<?php } else { ?>
                        <span class="subheading"><?php esc_html_e( 'The Cornerstone of Content Creation.', 'pillar-press' ); ?></span>
												<?php } ?>
                    </div>
		    						<!-- /.site-heading -->
                </div>
								<!-- /.col-lg-8.col-lg-offset-2.col-md-10.col-md-offset-1 -->
            </div>
						<!-- /.row -->
        </div>
				<!-- /.container -->
    </header>

	<?php } ?>

<?php }
endif;

if ( ! function_exists( 'ppt_social' ) ) :
/**
 * Adds the social profile links into the theme's footer.php file
 */
function ppt_social() {
	$social_networks = array(
		'instagram',
		'twitter',
		'facebook',
		'snapchat',
		'google',
		'pinterest',
		'youtube',
		'linkedin',
		'flickr',
		'medium',
		'tumblr',
		'github',
	); ?>

	<ul class="list-inline text-center">
		<?php foreach ( $social_networks as $network ) {
			if ( get_theme_mod( 'ppt_social_'.$network ) !='' ) { ?>
				<li id="social-<?php echo $network; ?>">
					<div class="fa-2x">
						<a href="<?php echo get_theme_mod( 'ppt_social_'.$network ); ?>" target="_blank">
  						<i class="fab fa-<?php echo $network; ?>"></i>
						</a>
					</div>
				</li>
			<?php }
		} ?>
	</ul>
<?php }
endif;

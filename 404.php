<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Pillar Press
 */

get_header(); ?>

	<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

		<?php do_action( 'ppt_404_top' ); ?>

		<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'pillar-press' ); ?></h1>
		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'pillar-press' ); ?></p>

		<?php get_search_form(); ?>

		<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

		<?php if ( ppt_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
		<div class="widget widget_categories">
			<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'pillar-press' ); ?></h2>
			<ul>
			<?php
				wp_list_categories( array(
					'orderby'    => 'count',
					'order'      => 'DESC',
					'show_count' => 1,
					'title_li'   => '',
					'number'     => 10,
				) );
			?>
			</ul>
		</div><!-- .widget -->
		<?php endif; ?>

		<?php
			/* translators: %1$s: smiley */
			$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'pillar-press' ), convert_smilies( ':)' ) ) . '</p>';
			the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
		?>

		<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

		<?php do_action( 'ppt_404_bottom' ); ?>

	</div>
	<!-- /.col-lg-8.col-lg-offset-2.col-md-10.col-md-offset-1 -->

<?php get_footer(); ?>

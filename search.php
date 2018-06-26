<?php
/**
 * The template for displaying search results pages.
 *
 * @package Pillar Press
 */

get_header(); ?>

  <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

		<?php do_action( 'ppt_search_top' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', 'search' ); ?>

		<?php endwhile; ?>

			<?php the_posts_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		<?php do_action( 'ppt_search_bottom' ); ?>

	</div>
	<!-- /.col-lg-8.col-lg-offset-2.col-md-10.col-md-offset-1 -->

<?php get_footer(); ?>

<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Pillar Press
 */

?>

    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->

  <?php if ( ! is_page_template( 'page-builder.php' ) ) { ?>

  <hr class="footer">

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
  				<?php do_action( 'ppt_footer_top' ); ?>
  					<?php ppt_social(); ?>
  				<?php if ( '' !== get_theme_mod( 'ppt_footer_copyright_text' ) ) { ?>
  					<p class="copyright text-muted"><?php echo esc_html( get_theme_mod( 'ppt_footer_copyright_text' ) ); ?></p>
  				<?php } else { ?>
            <p class="copyright text-muted"><a href="<?php echo esc_url( __( 'https://wordpress.org/', 'pillar-press' ) ); ?>" target="_blank"><?php printf( esc_html__( 'Powered by %s', 'pillar-press' ), 'WordPress' ); ?></a> &middot; <?php printf( esc_html__( '%1$s by %2$s.', 'pillar-press' ), 'Theme', '<a href="http://pillar.press" rel="designer" target="_blank">Pillar Press</a>' ); ?></p>
  				<?php } ?>
  				<?php do_action( 'ppt_footer_bottom' ); ?>
        </div>
        <!-- /.col-lg-8.col-lg-offset-2.col-md-10.col-md-offset-1 -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
  </footer>
	<!-- /footer -->

<?php } // end is_page_template() check. ?>

<?php wp_footer(); ?>

</body>
</html>

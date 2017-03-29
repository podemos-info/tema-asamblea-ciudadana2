<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

$the_theme = wp_get_theme();
$container = get_theme_mod( 'understrap_container_type' );
?>


<footer class="wrapper" id="wrapper-footer">
  <div class="up-footer">
    <div class="<?php echo esc_html( $container ); ?>">
      <div class="row">
        <div class="col-md-8">
            <h5>Mapa web</h5>
            <?php dynamic_sidebar( 'footerupleft' ); ?>
        </div><!--col end -->
        <div class="col-md-4 footerupright">
            <?php dynamic_sidebar( 'footerupright' ); ?>
        </div><!--col end -->
      </div><!-- row end -->
    </div><!-- container end -->
  </div>
  <div class="down-footer">
    <div class="<?php echo esc_html( $container ); ?> down-footer">
      <div class="row">
        <div class="col-xs-12 col-lg-8">
          <?php wp_nav_menu(
                array(
                    'theme_location'  => 'top',
                    'container_class' => '',
                    'container_id'    => 'bottomNav',
                    'menu_class'      => 'nav justify-content-start',
                    'fallback_cb'     => '',
                    'menu_id'         => 'useful-links-bottom',
                    'walker'          => new WP_Bootstrap_Navwalker(),
          )); ?>     
        </div><!--col end -->
        <div class="col-xs-12 col-lg-4">
          <a href="/" >
            <img src="/wp-content/uploads/2017/01/logo-footer.png" class="img-responsive pull-right" alt="Logo Podemos">
          </a>
        </div><!--col end -->
      </div><!-- row end -->
    </div><!-- container end -->
  </div>
</footer><!-- wrapper end -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>

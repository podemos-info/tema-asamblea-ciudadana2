<?php
//define('DONOTCACHEPAGE', true);
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */
get_header();
?>

<?php
$container   = get_theme_mod( 'understrap_container_type' );
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
global $wp_query;
$args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => 250, 'meta_key' => 'opcion_organo', 'orderby' => ['meta_value' => 'ASC','rand' => 'DESC'] ) );
query_posts( $args );
?>

<div class="wrapper" id="archive-wrapper">

  <div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">
      <div class="row">

        <main class="site-main col-12" id="main">

          <?php if ( have_posts() ) : ?>
            <header class="page-header">
              <h1 class="entry-title"><?php echo _x( 'Candidaturas a representantes de los Círculos en el CCE', 'opcion', 'pgi-import' );?></h1>
              <p><?php echo _x( 'A continuación encontrarás el listado de las candidaturas a representantes de los Círculos en el CCE que hemos recibido. El orden en el que aparecen las candidaturas es aleatorio y cambia periódicamente.', 'opcion', 'pgi-import' );?></p>
              <p><strong><?php echo _x( 'Puedes enviar rectificaciones utilizando el <a href="/soporte">formulario de soporte</a>.', 'opcion', 'pgi-import' );?></strong>
            </header>
                <div class="acordion" id="opciones">
            <?php
                $prev_opcion_organo = "";
                while ( have_posts() ) : the_post();
                  $opcion_organo = get_post_meta(get_the_id(), "opcion_organo", true);
                  if ($prev_opcion_organo!=$opcion_organo) :
		    if (!empty($prev_opcion_organo)) echo "</div><hr>";?>
                  <div class="row"><div class="col-12"><h2><i></i>
		      <?php echo _x(str_replace('Representante ','Representantes ',$opcion_organo),'opcion','pgi-import'); ?>
          </h2></div></div>
        <div class="row">
                  <?php $prev_opcion_organo = $opcion_organo;
                  endif; ?>
                  <?php get_template_part( 'loop-templates/content-opcion' );?>
	  <?php endwhile; 
		if (!empty($prev_opcion_organo)) echo "</div>";?>
              </div>
          <?php else : ?>

            <header class="page-header">
              <h1><?php echo _x( 'Candidaturas a representantes de los Círculos en el CCE', 'opcion', 'pgi-import' );?></h1>
              <p><?php echo _x( 'No hay candidaturas.', 'opcion', 'pgi-import' );?></p>
            </header>


          <?php endif; ?>

        </main><!-- #main -->

        <!-- The pagination component -->
        <?php understrap_pagination(); ?>

    </div> <!-- .row -->
</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); 
// Reset Query
wp_reset_query();?>
<script> <?php echo _x('jQuery(".menu-item-125").addClass("active");', 'lista', 'pgi-import'); ?> </script>

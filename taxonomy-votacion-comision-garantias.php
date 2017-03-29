<?php

if(isset($_GET['resultados'])){
   include("taxonomy-votacion-comision-garantias_resultado.php");
   exit(0);
}

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
$args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => 150, 'post_type' => 'lista', 'orderby'=>'rand' ) );

query_posts( $args );
?>

<div class="wrapper" id="archive-wrapper">

  <div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">
    <div class="row">

      <main class="site-main col-12" id="main">

        <?php if ( have_posts() ) : ?>
        <header class="page-header">
          <h1 class="entry-title"><?php echo _x( 'Candidaturas a la Comisión de Garantías', 'lista', 'pgi-import' );?></h1>
          <p><?php echo _x( 'A continuación encontrarás el listado de las candidaturas a la Comisión de Garantías que hemos recibido. El orden en el que aparecen las candidaturas es aleatorio y cambia periódicamente.', 'lista', 'pgi-import' );?></p>
          <p><strong><?php echo _x( 'Puedes enviar rectificaciones al correo electrónico <a href="mailto://soportevistalegre2@podemos.info">soportevistalegre2@podemos.info</a>.', 'lista', 'pgi-import' );?></strong>
        </header>
        <div class="acordion" id="opciones">
          <hr/>
          <?php while ( have_posts() ) : the_post(); ?>
          <div class="row">
            <div class="col-12">
            	<?php get_template_part( 'loop-templates/content-lista-garantias' ); ?>
            </div>
          </div>
          <?php endwhile; ?>
        </div>
        
        <?php else: ?>
        
        <header class="page-header">
          <h1><?php echo _x( 'Candidaturas al CCE y a la Secretaría General Estatal', 'lista', 'pgi-import' );?></h1>
          <p><?php echo _x( 'No hay candidaturas.', 'lista', 'pgi-import' );?></p>
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

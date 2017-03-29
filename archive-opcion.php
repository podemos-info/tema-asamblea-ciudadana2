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
$args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => 100, 'orderby' => 'rand' ) );
query_posts( $args );
?>

<!-- temporal, hay que pasarlo a los estilos del tema -->
<style>
  .fotoimg img{
    height: 140px;
    width: 140px;
    object-fit: cover;
    border-radius: 50%;
  }
  .type{
    cursor: pointer;
  }
  .aportaciones-collapse{
    text-align: center;
  }
  .aportaciones-collapse div{
    display: inline-block;
    text-align: center;
    margin: 20px 0;
  }
</style>

<div class="wrapper" id="archive-wrapper">

  <div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">
      <div class="row">

        <main class="site-main col-12" id="main">

          <?php if ( have_posts() ) : ?>
            <header class="page-header">
              <h1><?php echo _x( 'Candidaturas a representantes de los Círculos en el CCE', 'Candidaturas a representantes de los Círculos en el CCE', 'pgi-import' );?></h1>
              <p><?php echo _x( 'A continuación encontrarás el listado de las candidaturas a representantes de los Círculos en el CCE que hemos recibido. El orden en el que aparecen las candidaturas es aleatorio y cambia periódicamente.', 'Texto candidaturas representantes círculos', 'pgi-import' );?></p>
            </header>
                <div class="acordion" id="opciones">
            <?php
                $prev_opcion_tipo = "";
                while ( have_posts() ) : the_post();
                  $opcion_tipo = get_post_meta(get_the_id(), "opcion_tipo", true);
                  if ($prev_opcion_tipo!=$opcion_tipo) :
		    if (!empty($prev_opcion_tipo)) echo "</div>";?>
		  <div class="type collapsed" data-toggle="collapse" data-target="#opciones-<?php echo md5($opcion_tipo); ?>" data-parent="#opciones" aria-expanded="true">
		    <h2>
		      <i class="fa fa-users"></i>
		      <?php echo _x( str_replace('Representante ','Representantes ',$opcion_tipo) ); ?>
		    </h2>
		  </div>
		  <div class="aportaciones-collapse collapse" id="opciones-<?php echo md5($opcion_tipo); ?>" aria-expanded="true">
                  <?php $prev_opcion_tipo = $opcion_tipo;
                  endif; ?>
                  <?php get_template_part( 'loop-templates/content-opcion' );?>
	  <?php endwhile; 
		if (!empty($prev_opcion_tipo)) echo "</div>";?>
              </div>
	    </div>
          <?php else : ?>

            <header class="page-header">
              <h1><?php echo _x( 'Candidaturas a representantes de los Círculos en el CCE', 'Candidaturas a representantes de los Círculos en el CCE', 'pgi-import' );?></h1>
              <p><?php echo _x( 'No hay candidaturas.', 'Texto candidaturas representantes círculos', 'pgi-import' );?></p>
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

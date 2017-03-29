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
$args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => 300, 'meta_key' => 'aportacion_tematica', 'orderby' => ['meta_value' => 'ASC','rand' => 'DESC']));
query_posts( $args );
?>

<div class="wrapper" id="archive-wrapper">

  <div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">
      <div class="row">

        <main class="site-main col-12" id="main">

          <?php if ( have_posts() ) : ?>

            <header class="page-header">
              <h1 class="entry-title"><?php echo _x('Aportaciones al Debate', 'Texto aportaciones', 'pgi-import' );?></h1>
              <p><?php echo _x( 'A continuación encontrarás el listado de las Aportaciones al Debate que hemos recibido hasta el momento agrupadas por temáticas, con un resumen de cada una de ellas, y los nombres de los autores y las autoras de las propuestas. El orden en el que aparecen los documentos dentro de cada temática es aleatorio y cambia periódicamente.', 'Texto aportaciones', 'pgi-import' );?></p>
            </header><!-- .page-header -->
          	<div class="acordion" id="aportaciones">
            <?php
                $prev_aportaciones_tematica = "";
                while ( have_posts() ) : the_post();
                  $aportaciones_tematica = get_post_meta(get_the_id(), "aportacion_tematica", true);
                  if ($prev_aportaciones_tematica!=$aportaciones_tematica) :
              			if (!empty($prev_aportaciones_tematica)) echo "</div>";?>
  <div class="topic collapsed" data-toggle="collapse" data-target="#aportaciones-<?php echo md5($aportaciones_tematica); ?>" data-parent="#aportaciones" aria-expanded="true"><h2><i></i> <?php echo _x($aportaciones_tematica,$aportaciones_tematica,'pgi-import'); ?></h2></div>
	<div class="aportaciones-collapse collapse" id="aportaciones-<?php echo md5($aportaciones_tematica); ?>" aria-expanded="true">
                  <?php $prev_aportaciones_tematica = $aportaciones_tematica;
                  endif; ?>
              	  <?php get_template_part( 'loop-templates/content-aportacion' );?>
            <?php endwhile; 
    							if (!empty($prev_aportaciones_tematica)) echo "</div>";?>
              </div>
          <?php else : ?>

              <h1>Aportaciones provisionales</h1>
          		<p>Aún no hay aportaciones.</p>


          <?php endif; ?>

        </main><!-- #main -->

        <!-- The pagination component -->
        <?php understrap_pagination(); ?>

      </div><!-- #primary -->

    </div> <!-- .row -->
</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); 

// Reset Query
wp_reset_query();?>
<script> <?php echo _x('jQuery(".menu-item-125").addClass("active");', 'lista', 'pgi-import'); ?> </script>

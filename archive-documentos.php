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

<div class="wrapper" id="archive-wrapper">

  <div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">
      <div class="row">

        <main class="site-main col-12" id="main">

          <?php if ( have_posts() ) : ?>

            <header class="page-header">
              <h1 class="entry-title"><?php echo _x( 'Documentos provisionales', 'Documentos provisionales', 'pgi-import' );?></h1>
              <p><?php echo _x( 'A continuación encontrarás el listado de los documentos que hemos recibido (agrupados en las siguientes categorías: político, igualdad, ético y organizativo), un resumen de cada uno de ellos, y los nombres de los autores y las autoras de las propuestas. El orden en el que aparecen los equipos es aleatorio y cambia periódicamente.', 'Texto documentos', 'pgi-import' );?></p>
            </header><!-- .page-header -->
            <div class="<?php echo esc_html( $container ); ?>">
              <div class="acordion" id="documentos">
            <?php while ( have_posts() ) : the_post(); ?>
              <?php

              /*
               * Include the Post-Format-specific template for the content.
               * If you want to override this in a child theme, then include a file
               * called content-___.php (where ___ is the Post Format name) and that will be used instead.
               */
              get_template_part( 'loop-templates/content-documentos' );
              ?>
            <?php endwhile; ?>
              </div></div>
          <?php else : ?>

              <h1><?php echo _x( 'Documentos provisionales', 'Documentos provisionales', 'pgi-import' );?></h1>
          <p><?php echo _x( 'Aún no hay documentos.', 'Documentos provisionales', 'pgi-import' );?></p>


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

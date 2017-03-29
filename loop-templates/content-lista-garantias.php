<?php
/**
 * Partial template for content in directo.php
 *
 * @package understrap
 */
$lista_blanca = get_post_meta($post->ID, 'lista_blanca', true);

//

$args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => 150, 'post_type' => 'lista', 'orderby'=>'rand' ) );
$opciones = get_posts([ 'posts_per_page' => 80, 'post_type' => 'opcion', 'orderby' => [ 'parte_votacion' => 'ASC', 'posicion' => 'ASC', 'rand'=>'ASC'], 
                       'meta_query' => ['parte_votacion' => ['key' => 'opcion_orden_parte_votacion', 'compare' => 'EXISTS'], 
                                        'posicion' => ['key' => 'opcion_posicion', 'compare' => 'EXISTS'],
                                        'lista' => ['key' => 'opcion_lista_id', 'compare'=>'=', 'value'=>$post->ID]
                                       ]
                      ]);
?>
<div class="acordion row" id="listas">
  <div class="lista col-12 col-sm-12 col-md-12 col-lg-12" data-toggle="collapse" data-target="#lista-<?php echo $post->ID;?>" data-parent="#listas" aria-expanded="true"><h2><i></i>&nbsp;<?php the_title(); ?></h2></div>
  <div class="lista-collapse collapse col-12 col-sm-12 col-md-12 col-lg-12" id="lista-<?php echo $post->ID;?>" aria-expanded="true">

    <div class="accordion-toggle accordion-heading milestone-heading-pointer col-12"	 data-target="#lista-<?php echo $post->ID;?>" data-parent="#listas" aria-expanded="true">

      <?php if( get_the_content() ){
?>
      <div class="lista-motivacion"><?php the_content()?></div>
      <?php }
?>
      <div class="row">
        <?php foreach ($opciones as $opcion):
        ?>
        <div class="col-6 col-sm-4 col-md-3 col-lg-2 text-center">
          <a class="opcion" title="<?php echo get_the_title($opcion->ID)?>" href="<?php echo get_the_permalink($opcion)?>">
            <span class="fotoimg">
            <?php
              $thumb = get_the_post_thumbnail($opcion->ID, 'miniatura150');
              if ($thumb == '') {
                $thumb = '<img src="' . get_stylesheet_directory_uri() . '/images/candidatura-150.jpg' . '" alt="Foto del candidato" class="attachment-thumbnail size-thumbnail wp-post-image" width="150" height="150" />';
              }
              echo $thumb;
            ?>
            </span>
            <br>
            <span class="nombre"><?php echo get_the_title($opcion->ID)?></span>
          </a>
        </div>
        <?php endforeach; ?>
      </div>

    </div>

  </div><!-- documento-collapse -->
</div>
<hr/>
<?php  ?>

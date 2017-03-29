<?php
/**
 * Partial template for content in directo.php
 *
 * @package understrap
 */
$lista_tipo = get_post_meta($post->ID, 'lista_tipo', true);

$opciones = [];
$listas = [];
if($lista_tipo=="blanca"){
  $args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => 150, 'post_type' => 'lista', 'orderby'=>'rand', 'meta_key' => 'lista_tipo', 'meta_value'=>'blanca_sg', 'meta_compare' => '=') );
  $listas_blancas_sg = get_posts($args);
  foreach($listas_blancas_sg as $lista_blanca_sg){
    $listas []= $lista_blanca_sg->ID;
  }
}
$listas []= $post->ID;
foreach ($listas as $lista) {
  $opciones += get_posts([ 'posts_per_page' => 80, 'post_type' => 'opcion', 'orderby' => [ 'parte_votacion' => 'ASC', 'posicion' => 'ASC', 'rand'=>'ASC'], 
                           'meta_query' => ['parte_votacion' => ['key' => 'opcion_orden_parte_votacion', 'compare' => 'EXISTS'], 
                                            'posicion' => ['key' => 'opcion_posicion', 'compare' => 'EXISTS', 'type'=>'NUMERIC'],
                                            'lista' => ['key' => 'opcion_lista_id', 'compare'=>'=', 'value'=>$lista]
                                           ]
                          ]);
}

?>
<div class="acordion row" id="listas">
  <div class="lista col-12 col-sm-12 col-md-12 col-lg-12" data-toggle="collapse" data-target="#lista-<?php echo $post->ID;?>" data-parent="#listas" aria-expanded="true"><h2><i></i>&nbsp;<?php the_title(); ?></h2></div>
  <div class="lista-collapse collapse col-12 col-sm-12 col-md-12 col-lg-12" id="lista-<?php echo $post->ID;?>" aria-expanded="true">

    <div class="accordion-toggle accordion-heading milestone-heading-pointer col-12"	 data-target="#lista-<?php echo $post->ID;?>" data-parent="#listas" aria-expanded="true">
      <?php if($lista_tipo!="blanca") { ?>
      <div class="row lista-motivacion">
        <p><?php the_content()?></p>
      </div>
      <?php } ?>
      <?php $prev_taxonomy_id = ""; ?>
      <?php foreach ($opciones as $opcion):
      $opcion_plantilla =  get_post_meta($opcion->ID, 'opcion_plantilla', true);
      $current_taxonomy = wp_get_object_terms( $opcion->ID, 'votacion' )[1];
      $current_taxonomy_name = $current_taxonomy->name;
      $current_taxonomy_id = get_term_meta($current_taxonomy->term_id, 'votacion_id', true);
      $title = "";
      if ($prev_taxonomy_id != $current_taxonomy_id) {
        if (empty($prev_taxonomy_id)) {
          if ($current_taxonomy_id=="SG-CCE-SG") {
            $title = "Secretaría General + Documentos";
          }
        	else {
          	$title = "Documentos";
          }
        } else {
          if ($current_taxonomy_id=="SG-CCE-CCE") {
            $title = $current_taxonomy_name;
          }
        }
      }
      ?>
      <?php if (!empty($title)): ?>
        <?php if (!empty($prev_taxonomy_id)): ?></div><hr/><?php endif;?>
        <div class="row">
          <div class="col-12"><h3 style="cursor:pointer;"><?php echo _x($title,'content-lista','pgi-import'); ?></h3></div>
        </div>
        <div class="row">
      <?php endif; ?>
        <?php if ($opcion_plantilla=="candidato"): ?>
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
        <?php else:
             $attachment_id = get_post_meta($opcion->ID, 'opcion_documento', true);
             $doc_name = $current_taxonomy_name;
             foreach(["Documento de Igualdad","Documento Político","Documento Organizativo","Documento Ético"] as $string_to_translate) 
               $doc_name = str_replace($string_to_translate, _x($string_to_translate,$string_to_translate,"pgi-import"), $doc_name);
             $megaequipo = get_post_meta($opcion->ID, 'opcion_megaequipo', true);
             if (!empty($megaequipo)) $doc_name .= " ($megaequipo)";
        ?>
      	<?php if ($current_taxonomy_id=="SG-CCE-DP"): ?><div class="col-12 col-sm-8" style="align-self: center;"><ul class="lista-docs"><?php endif;?>
        <li><a href="<?php echo wp_get_attachment_url( $attachment_id )?>"><?php echo $doc_name?></a></li> 
        <?php if ($current_taxonomy_id=="SG-CCE-DI"): ?></ul></div><?php endif;?>
        <?php endif;?>
      <?php 
      $prev_taxonomy_id = $current_taxonomy_id;
      endforeach; ?>
    	</div>
    </div>

  </div><!-- documento-collapse -->
</div><hr/>
<?php  ?>

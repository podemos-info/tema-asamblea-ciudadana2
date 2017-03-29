<?php
/**
 * Partial template for content in directo.php
 *
 * @package understrap
 */

global $parte_votacion, $votes_pos;


$listas = get_posts( ['posts_per_page' => 150, 'post_type' => 'lista'] );
$nombres_listas = [];
$tipos_listas = [];
foreach ($listas as $lista) {
  $tipos_listas[$lista->ID] = get_post_meta($lista->ID, 'lista_tipo', true);
  $nombres_listas[$lista->ID] = get_the_title($lista->ID);
}
$votacion_id = get_term_meta( $parte_votacion->term_id, 'votacion_id', true );
$num_winners = get_term_meta( $parte_votacion->term_id, 'votacion_numero_ganadores', true );
$blank_votes = get_term_meta( $parte_votacion->term_id, 'votacion_votos_blanco', true );
$null_votes = get_term_meta( $parte_votacion->term_id, 'votacion_votos_nulo', true );
$valid_votes = get_term_meta( $parte_votacion->term_id, 'votacion_votos_validos', true );
$item_class = $num_winners == 1 ? "col-12 col-sm-10" : "col-12 col-md-6 col-lg-8";
if ($votacion_id=="SG-CCE-CCE") {
  $nombre_puntos = "puntos";
	$total_votes = $valid_votes + $null_votes;
} else {
  $nombre_puntos = "votos";
	$total_votes = $valid_votes + $null_votes + $blank_votes;
}
$opciones = get_posts( [ 'posts_per_page' => 300, 'post_type' => 'opcion', 
                        'tax_query' => [ [ 'taxonomy' => 'votacion',
                                          'field' => 'id',
                                          'terms' => $parte_votacion->term_id ] ],
                        'orderby' => [ 'opcion_posicion_final' => 'ASC', 'megaequipo' => 'ASC' ],
                        'meta_query' => [ 'megaequipo' => [ 'relation' => 'OR', [ 'key' => 'opcion_megaequipo', 'compare' => 'EXISTS' ], [ 'key' => 'opcion_megaequipo', 'compare' => 'NOT EXISTS' ] ], 'opcion_posicion_final' => ['key' => '_sort_'.$parte_votacion->term_id, 'compare' => 'EXISTS', 'type'=>'NUMERIC' ]]
                       ] );
?>
<a name="<?php echo $parte_votacion->slug; ?>"></a>
<h2 class="entry-title"><?php echo _X($parte_votacion->name,'resultados','pgi-import'); ?></h2>
<div class="row">
  <div class="col-12">
    <?php if($total_votes!=""): echo _x('Votos totales:','resultados','pgi-import');?> 
    	<?php echo number_format($total_votes, 0, ',', '.');?><br />
    <?php endif; ?>
    <?php if($valid_votes!=""): echo _x('Votos válidos:','resultados','pgi-import');?> 
    	<?php echo number_format($valid_votes, 0, ',', '.');?> (<?php printf(_x("%s%%",'resultados','pgi-import'), number_format(floatval($valid_votes*100/$total_votes), 2, ',', '.'));?>)
      <br />
    <?php endif; ?>
    <?php if($blank_votes!=""): echo _x('Votos en blanco:','resultados','pgi-import');?> 
    	<?php echo number_format($blank_votes, 0, ',', '.');?> (<?php printf(_x("%s%%",'resultados','pgi-import'), number_format(floatval($blank_votes*100/$total_votes), 2, ',', '.'));?>)
      <br />
    <?php endif; ?>
    <?php if($null_votes!=""): echo _x('Votos nulos:','resultados','pgi-import');?> 
    	<?php echo number_format($null_votes, 0, ',', '.');?> (<?php printf(_x("%s%%",'resultados','pgi-import'), number_format(floatval($null_votes*100/$total_votes), 2, ',', '.'));?>)
    <?php endif; ?>
  </div>
  <?php 
  foreach ($opciones as $key => $opcion):
  	$puntos = get_post_meta($opcion->ID, 'opcion_puntos', true);
    $empate = $key > 0 && $puntos==$prev_puntos;
    $megaequipo = get_post_meta($opcion->ID, 'opcion_megaequipo', true);
  	$opcion_lista_id = get_post_meta($opcion->ID, 'opcion_lista_id', true);
  	$votes_pos = get_post_meta( $opcion->ID, 'opcion_votos_por_posicion', true );
    $plantilla = get_post_meta($opcion->ID, 'opcion_plantilla', true);
    $baja_mensaje = get_post_meta($opcion->ID, 'opcion_baja_mensaje', true);
    if (empty($megaequipo)) {
      $title = get_the_title($opcion->ID);
      $opcion_listas = [ $nombres_listas[$opcion_lista_id]];
    	if (!$empate) $pos = $key+1;
    } else {
      if (empty($opcion_listas)) $pos = $key+1;
      if ($tipos_listas[$opcion_lista_id]=="blanca_sg")
      	$opcion_listas []= get_the_title($opcion->ID);
     	else
        $opcion_listas []= $nombres_listas[$opcion_lista_id];
      if ($opciones[$key+1] && get_post_meta($opciones[$key+1]->ID, 'opcion_megaequipo', true)==$megaequipo) continue;
      $title = $megaequipo;
    }
    if ($num_winners<$pos && !$empate) break;
  
  	if ($plantilla=="documento") {
	    $thumb = get_the_post_thumbnail($opcion->ID);
  		$url = wp_get_attachment_url(get_post_meta($opcion->ID, 'opcion_documento', true));
  		$image_class = "col-sm-4 documento";
      $item_class = "col-sm-8";
  	} else {
    	$thumb = get_the_post_thumbnail($opcion->ID, 'miniatura150');
  		if (empty($thumb)) $thumb = '<img src="' . get_stylesheet_directory_uri() . '/images/candidatura-150.jpg' . '" alt="'.$title.'" class="attachment-thumbnail size-thumbnail wp-post-image" width="150" height="150" />';
  		$url = get_the_permalink($opcion);
  		$image_class = "col-md-6 col-lg-4";
  	}
    $inactive_class = "";
		if(!empty($baja_mensaje)){
			$inactive_class = " opcion_inactiva";
			$num_winners++;
		}
  ?>
  <div class="col-12 col-sm-12 col-md-6">
    <div class="row">

      <div class="col-12 <?php echo $image_class?> text-center">
        <a class="opcion <?php echo $inactive_class?>" title="<?php echo $title?>" href="<?php echo $url?>"><?php echo $thumb; ?></a>
      </div>
      <div class="<?php echo $item_class.$inactive_class?>">
        <p><br><strong><?php echo $pos?>. <a class="opcion" title="<?php $title?>" href="<?php echo $url?>"><?php echo $title.(!empty($baja_mensaje)?' <sup>*</sup>':'')?></a></strong><br>
          <?php foreach ($opcion_listas as $lista) { if (!empty($lista)) echo "<span class='resultado-lista'>$lista</span><br>"; }
              $opcion_listas = [];?>
          <?php printf(_x("%s $nombre_puntos",'resultados','pgi-import'), number_format($puntos, 0, ',', '.'));?><br>
          <?php printf(_x("%s%% de los $nombre_puntos",'resultados','pgi-import'), number_format(floatval(get_post_meta($opcion->ID, 'opcion_porcentaje', true)), 2, ',', '.'));?>
        <?php if(!empty($votes_pos)):?>
        <div class="grafico" data-votes="<?php echo $votes_pos; ?>"></div>
        <?php endif; ?></p>
  		</div>
      <?php if($baja_mensaje): ?>
        <div class="col-12 text-center"><span class="opcion_baja"><?php echo $baja_mensaje; ?></span></div>
      <?php endif; ?>
  	</div>
  </div>
  <?php 
  $prev_puntos = $puntos;
  endforeach; ?>
</div>
<br>
<?php  ?>

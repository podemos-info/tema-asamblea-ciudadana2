<?php
/**
 * Partial template for content in directo.php
 *
 * @package understrap
 */

$aid = get_the_id();
$aportaciones_titulo = mb_convert_case(get_post_meta($aid, "aportacion_titulo", true),MB_CASE_UPPER);
$aportaciones_resumen = get_post_meta($aid, "aportacion_resumen", true);
$aportaciones_tematica = get_post_meta($aid, "aportacion_tematica", true); /** FALTA POR AÑADIR AL HTML **/
$aportaciones_documento = get_post_meta($aid, "aportacion_documento", true);
$aportaciones_equipo = json_decode(get_post_meta($aid, "aportacion_equipo", true));
$aportaciones_email = get_post_meta($aid, "aportacion_email", true);
$aportaciones_gravity_entry_id = get_post_meta($aid, "gravity_entry_id",true);
?>
<article <?php post_class(); ?> id="post-<?php the_ID();?>">
  <div class="accordion-toggle accordion-heading milestone-heading-pointer collapsed" data-toggle="collapse" data-target="#desc-<?php the_ID(); ?>" data-parent="#aportaciones" aria-expanded="true">
    <div class="row">
      <div class="col-10 col-sm-11">
        <h3><?php echo $aportaciones_titulo;?></h3>
        <?php 
        $lista_autores = "";
        foreach($aportaciones_equipo as $key => $equipo_persona){
          $autor_nombre_apellidos = $equipo_persona->Nombre . " " . $equipo_persona->Apellidos;
          $autor_nombre_apellidos = html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $autor_nombre_apellidos));
          $lista_autores .= $autor_nombre_apellidos . ", ";
        }
        if (mb_convert_case($lista_autores,MB_CASE_UPPER)==$lista_autores || mb_convert_case($lista_autores,MB_CASE_LOWER)==$lista_autores) {
          $lista_autores = mb_convert_case($lista_autores,MB_CASE_TITLE);
        }
        $lista_autores = substr($lista_autores,0,-2);
        ?>
        <p><?php echo $lista_autores; ?></p>

      </div>
      <div class="col-2 col-sm-1">
        <i class="accordion-heading-fa-i fa fa-angle-up" aria-hidden="true"></i>
      </div>
    </div>
  </div>
	<div class="aportacion-collapse collapse" id="desc-<?php the_ID(); ?>" aria-expanded="true">
    <div class="row">
      <div class="col-12">
	<p><?php echo $aportaciones_resumen; ?></p>
          <?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-sm-12">
        <?php $aportaciones_documento_url=wp_get_attachment_url($aportaciones_documento); ?>
        <p><a class="button fa-file-pdf-o" style="margin:0 -10px;" href="<?php echo $aportaciones_documento_url; ?>"><?php echo _x('Ver documento de aportaciones', 'Ver documento de aportaciones', 'pgi-import' );?></a></p>
      </div>
      <!--<div class="col-12 col-sm-3">
        <p><a class="button" target="_blank" style="margin:0 -10px;" href="https://plaza.podemos.info/aportaciones/debates/<?php echo $aportaciones_gravity_entry_id; ?>"><?php/* echo _x("Votar en Plaza Podemos",'content-aportacion','pgi-import');*/?></a></p>
      </div>
      <div class="col-12 col-sm-6">
        <p><a class="button fa-envelope-open-o" style="margin:0 -10px;" href="mailto:<?php /*echo $aportaciones_email;*/?>"><?php echo $aportaciones_email;?></a></p>
      </div>-->
    </div>
  </div><!-- documento-collapse -->
<hr/>
</article><!-- #post-## -->

<?php
/**
 * Partial template for content in directo.php
 *
 * @package understrap
 */

$did = get_the_id();
$documentos_documento_politico = get_post_meta($did, "documentos_documento_politico", true);
$documentos_titulo_del_documento_25 = get_post_meta($did, "documentos_titulo_del_documento_25", true);
$documentos_resumen_del_documento_politico = get_post_meta($did, "documentos_resumen_del_documento_politico", true); ##### important
$documentos_subir_documento_en_pdf_26 = get_post_meta($did, "documentos_subir_documento_en_pdf_26", true);
$documentos_documento_organizativo = get_post_meta($did, "documentos_documento_organizativo", true);
$documentos_titulo_del_documento_28 = get_post_meta($did, "documentos_titulo_del_documento_28", true);
$documentos_resumen_del_documento_organizativo = get_post_meta($did, "documentos_resumen_del_documento_organizativo", true);
$documentos_subir_documento_en_pdf_29 = get_post_meta($did, "documentos_subir_documento_en_pdf_29", true);
$documentos_documento__tico = get_post_meta($did, "documentos_documento__tico", true);
$documentos_titulo_del_documento_30 = get_post_meta($did, "documentos_titulo_del_documento_30", true);
$documentos_resumen_del_documento__tico = get_post_meta($did, "documentos_resumen_del_documento__tico", true);
$documentos_subir_documento_en_pdf_31 = get_post_meta($did, "documentos_subir_documento_en_pdf_31", true);
$documentos_documento_de_igualdad = get_post_meta($did, "documentos_documento_de_igualdad", true);
$documentos_titulo_del_documento_32 = get_post_meta($did, "documentos_titulo_del_documento_32", true);
$documentos_resumen_del_documento_de_igualdad = get_post_meta($did, "documentos_resumen_del_documento_de_igualdad", true);
$documentos_subir_documento_en_pdf_33 = get_post_meta($did, "documentos_subir_documento_en_pdf_33", true);
$documentos_equipo = json_decode(get_post_meta($did, "documentos_equipo", true));
$documentos_logo_del_equipo__imagen_47 = get_post_meta($did, "documentos_logo_del_equipo__imagen_47", true);
$documentos_al_hacer_click_en_los_documentos__prefieres___ = get_post_meta($did, "documentos_al_hacer_click_en_los_documentos__prefieres___", true);
$documentos_web_de_la_candidatura = get_post_meta($did, "documentos_web_de_la_candidatura", true);
$documentos_correo_electronico_del_equipo = get_post_meta($did, "documentos_correo_electronico_del_equipo", true);

if($documentos_al_hacer_click_en_los_documentos__prefieres___){
  if($documentos_subir_documento_en_pdf_26) $documentos_subir_documento_en_pdf_26=$documentos_web_de_la_candidatura;
  if($documentos_subir_documento_en_pdf_29) $documentos_subir_documento_en_pdf_29=$documentos_web_de_la_candidatura;
  if($documentos_subir_documento_en_pdf_33) $documentos_subir_documento_en_pdf_33=$documentos_web_de_la_candidatura;
  if($documentos_subir_documento_en_pdf_31) $documentos_subir_documento_en_pdf_31=$documentos_web_de_la_candidatura;
}

if($documentos_subir_documento_en_pdf_26 || $documentos_subir_documento_en_pdf_29 || $documentos_subir_documento_en_pdf_33 || $documentos_subir_documento_en_pdf_31 ){
?>
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <div class="accordion-toggle accordion-heading milestone-heading-pointer collapsed" data-toggle="collapse" data-target="#desc-<?php the_ID(); ?>" data-parent="#documentos" aria-expanded="true">
      <div class="row">
        <div class="col-12 col-sm-4 col-md-3 col-lg-2">
          <?php /* IMAGEN **/ ?>
	<?php 
          if($documentos_logo_del_equipo__imagen_47)
            $attachment_src = wp_get_attachment_image_src($documentos_logo_del_equipo__imagen_47, 'medium')[0]; 
          else
            $attachment_src = "/wp-content/uploads/2017/01/standard_logo.jpg";
          ?>
          <div class="logo-equipo" style="background-image:url(<?php echo $attachment_src; ?>)" ></div>
        </div>
        <div class="col-10 col-sm-7 col-md-8 col-lg-9">
          <?php/*** AUTORES */ ?>
          <h2 class="h6"><?php echo _x('Autoría', 'Autoría', 'pgi-import' );?></h2>
	<strong>
          <?php 
          $html_autores = "";

          foreach($documentos_equipo as $key => $documento_equipo){
            $ne = html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $documento_equipo->Nombre));
            $ae = html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $documento_equipo->Apellidos));
            $html_autores .= $ne." ".$ae.", ";
          }
          if (mb_convert_case($html_autores,MB_CASE_UPPER)==$html_autores || mb_convert_case($html_autores,MB_CASE_LOWER)==$html_autores) {
            $html_autores = mb_convert_case($html_autores,MB_CASE_TITLE);
          }
          echo substr($html_autores,0,-2);
          ?></strong><p><a class="email" href="mailto:<?php echo $documentos_correo_electronico_del_equipo;?>"><?php echo $documentos_correo_electronico_del_equipo;?></a></p>
        </div>
        <div class="col-2 col-sm-1">
					<i class="accordion-heading-fa-i fa fa-angle-up" aria-hidden="true"></i>
        </div>
      </div>
  	</div>
	<div class="documento-collapse collapse" id="desc-<?php the_ID(); ?>" aria-expanded="true">
    <div class="row">
      <div class="col-7 offset-sm-2">
        <?php if($documentos_subir_documento_en_pdf_26){ ?>
        <div class="document-box">
          <h4 class="h6"><?php echo _x('Documento Político', 'Documento Político', 'pgi-import' );?></h2>
          <h3><?php echo $documentos_titulo_del_documento_25; ?></h3>
          <p><?php echo $documentos_resumen_del_documento_politico;?></p>
          <?php if(!$documentos_al_hacer_click_en_los_documentos__prefieres___) $documentos_subir_documento_en_pdf_26=wp_get_attachment_url($documentos_subir_documento_en_pdf_26); ?>
          <a class="button fa-file-pdf-o" href="<?php echo $documentos_subir_documento_en_pdf_26; ?>"><?php echo _x('Ver documento político', 'Ver documento político', 'pgi-import' );?></a>
        </div>
        <?php
          }
          if($documentos_subir_documento_en_pdf_33){
        ?>
        <div class="document-box">
        <h4 class="h6"><?php echo _x('Documento de Igualdad', 'Documento de Igualdad', 'pgi-import' );?></h2>
        <h3><?php echo $documentos_titulo_del_documento_32; ?></h3>
        <p><?php echo $documentos_resumen_del_documento_de_igualdad;?></p>
          <?php if(!$documentos_al_hacer_click_en_los_documentos__prefieres___) $documentos_subir_documento_en_pdf_33=wp_get_attachment_url($documentos_subir_documento_en_pdf_33); ?>
          <a class="button fa-file-pdf-o" href="<?php echo $documentos_subir_documento_en_pdf_33; ?>"><?php echo _x('Ver documento de igualdad', 'Ver documento de igualdad', 'pgi-import' );?></a>
        </div>
        <?php
          }
          if($documentos_subir_documento_en_pdf_31){
        ?>
        <div class="document-box">
        <h4 class="h6"><?php echo _x('Documento Ético', 'Documento Ético', 'pgi-import' );?></h2>
        <h3><?php echo $documentos_titulo_del_documento_30; ?></h3>
        <p><?php echo $documentos_resumen_del_documento__tico;?></p>
           <?php if(!$documentos_al_hacer_click_en_los_documentos__prefieres___) $documentos_subir_documento_en_pdf_31=wp_get_attachment_url($documentos_subir_documento_en_pdf_31); ?>
          <a class="button fa-file-pdf-o" href="<?php echo $documentos_subir_documento_en_pdf_31; ?>"><?php echo _x('Ver documento ético', 'Ver documento ético', 'pgi-import' );?></a>
        </div>
        <?php
          }
          if($documentos_subir_documento_en_pdf_29){
        ?>
        <div class="document-box">
        <h4 class="h6"><?php echo _x('Documento Organizativo', 'Documento Organizativo', 'pgi-import' );?></h2>
        <h3><?php echo $documentos_titulo_del_documento_28; ?></h3>
        <p><?php echo $documentos_resumen_del_documento_organizativo;?></p>
          <?php if(!$documentos_al_hacer_click_en_los_documentos__prefieres___) $documentos_subir_documento_en_pdf_29=wp_get_attachment_url($documentos_subir_documento_en_pdf_29); ?>
        <a class="button fa-file-pdf-o" href="<?php echo $documentos_subir_documento_en_pdf_29; ?>"><?php echo _x('Ver documento organizativo', 'Ver documento organizativo', 'pgi-import' );?></a>
        </div>
        <?php
          }
        ?>

      <div class="entry-content"></div>
      <footer class="entry-footer">
        <?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>
      </footer><!-- .entry-footer -->
     </div><!-- .col-12 -->
    </div>
 </div><!-- documento-collapse -->
<hr/>
</article><!-- #post-## -->
<?php } ?>

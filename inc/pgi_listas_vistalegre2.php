<?php
//Documentos y listas para vistalegre II
function pgi_listas_vistalegre2($forms) {
  $forms['285'] = 'lista';
  return $forms;
}
add_filter('pgi_forms', 'pgi_listas_vistalegre2');


function pgi_listas_vistalegre2_title($title, $entrada) {
  return $entrada["1"];
}
add_filter('pgi_title_285', 'pgi_listas_vistalegre2_title', 10, 2);
add_filter('pgi_title_285dp', 'pgi_listas_vistalegre2_title', 10, 2);
add_filter('pgi_title_285do', 'pgi_listas_vistalegre2_title', 10, 2);
add_filter('pgi_title_285de', 'pgi_listas_vistalegre2_title', 10, 2);
add_filter('pgi_title_285di', 'pgi_listas_vistalegre2_title', 10, 2);

function pgi_listas_vistalegre2_content($content, $entrada) {
  return $entrada["17"];
}
add_filter('pgi_content_285', 'pgi_listas_vistalegre2_content', 10, 2);


function pgi_listas_vistalegre2_title_doc_pol($title, $entrada) {
  $title = $entrada['1'];
  if (empty($entrada['50.1'])) {
    $title = $entrada['51'];
  }
  return $title;
}
add_filter('pgi_title_285dp', 'pgi_listas_vistalegre2_title_doc_pol', 10, 2);

function pgi_listas_vistalegre2_content_doc_pol($content, $entrada) {
  return $entrada['86'];
}
add_filter('pgi_content_285dp', 'pgi_listas_vistalegre2_content_doc_pol', 10, 2);

function pgi_listas_vistalegre2_title_doc_org($title, $entrada) {
  $title = $entrada['1'];
  if (empty($entrada['50.1'])) {
    $title = $entrada['52'];
  }
  return $title;
}
add_filter('pgi_title_285do', 'pgi_listas_vistalegre2_title_doc_org', 10, 2);

function pgi_listas_vistalegre2_content_doc_org($content, $entrada) {
  return $entrada['87'];
}
add_filter('pgi_content_285do', 'pgi_listas_vistalegre2_content_doc_org', 10, 2);


function pgi_listas_vistalegre2_title_doc_eti($title, $entrada) {
  $title = $entrada['1'];
  if (empty($entrada['50.1'])) {
    $title = $entrada['53'];
  }
  return $title;
}
add_filter('pgi_title_285de', 'pgi_listas_vistalegre2_title_doc_eti', 10, 2);

function pgi_listas_vistalegre2_content_doc_eti($content, $entrada) {
  return $entrada['88'];
}
add_filter('pgi_content_285de', 'pgi_listas_vistalegre2_content_doc_eti', 10, 2);


function pgi_listas_vistalegre2_title_doc_igu($title, $entrada) {
  $title = $entrada['1'];
  if (empty($entrada['50.1'])) {
    $title = $entrada['54'];
  }
  return $title;
}
add_filter('pgi_title_285di', 'pgi_listas_vistalegre2_title_doc_igu', 10, 2);

function pgi_listas_vistalegre2_content_doc_igu($content, $entrada) {
  return $entrada['89'];
}
add_filter('pgi_content_285di', 'pgi_listas_vistalegre2_content_doc_igu', 10, 2);


/* SEGURO QUE ESTO SE PUEDE REFACTORIZAR */
function pgi_listas_vistalegre2_mapper_pol($mapper){
  return [
      '44'  => array( 'name' => 'opcion_documento', 'type' => 'file'),
      'firmantes'  => array( 'name' => 'opcion_firmantes', 'type' => 'textarea'),
      '69'  => array( 'name' => 'opcion_megaequipo', 'type' => 'text'),
      'logo'  => array( 'name' => 'opcion_logo', 'type' => 'thumbnail'),
      'orden' => array( 'name' => 'opcion_orden_parte_votacion', 'type' => 'text'),
  ];
}
add_filter('pgi_mapper_285dp', 'pgi_listas_vistalegre2_mapper_pol', 10, 2);

function pgi_listas_vistalegre2_mapper_org($mapper){
  return [
      '45'  => array( 'name' => 'opcion_documento', 'type' => 'file'),
      'firmantes'  => array( 'name' => 'opcion_firmantes', 'type' => 'textarea'),
      '70'  => array( 'name' => 'opcion_megaequipo', 'type' => 'text'),
      'logo'  => array( 'name' => 'opcion_logo', 'type' => 'thumbnail'),
      'orden' => array( 'name' => 'opcion_orden_parte_votacion', 'type' => 'text'),
  ];
}
add_filter('pgi_mapper_285do', 'pgi_listas_vistalegre2_mapper_org', 10, 2);

function pgi_listas_vistalegre2_mapper_eti($mapper){
  return [
      '46'  => array( 'name' => 'opcion_documento', 'type' => 'file'),
      'firmantes'  => array( 'name' => 'opcion_firmantes', 'type' => 'textarea'),
      '71'  => array( 'name' => 'opcion_megaequipo', 'type' => 'text'),
      'logo'  => array( 'name' => 'opcion_logo', 'type' => 'thumbnail'),
      'orden' => array( 'name' => 'opcion_orden_parte_votacion', 'type' => 'text'),
  ];
}
add_filter('pgi_mapper_285de', 'pgi_listas_vistalegre2_mapper_eti', 10, 2);

function pgi_listas_vistalegre2_mapper_igu($mapper){
  return [
      '47'  => array( 'name' => 'opcion_documento', 'type' => 'file'),
      'firmantes'  => array( 'name' => 'opcion_firmantes', 'type' => 'textarea'),
      '72'  => array( 'name' => 'opcion_megaequipo', 'type' => 'text'),
      'logo'  => array( 'name' => 'opcion_logo', 'type' => 'thumbnail'),
      'orden' => array( 'name' => 'opcion_orden_parte_votacion', 'type' => 'text'),
  ];
}
add_filter('pgi_mapper_285di', 'pgi_listas_vistalegre2_mapper_igu', 10, 2);


function pgi_listas_vistalegre2_categorias() {
  pgi_votacion_formulario_listas('285');

  // crear o actualiza la lista blanca para esta votación, que sea fácilmente localizable
}
if (function_exists('pgi_votacion_formulario_listas'))
  add_filter('init', 'pgi_listas_vistalegre2_categorias');


function pgi_listas_vistalegre2_categoria($entradas) {
  $res = [];
  $opcion = $entradas[0];
  $opcion["votacion"] = ["SG-CCE"];
  
  if ($opcion['84'] == 'SGE'){
    $opcion["lista_tipo"] = "blanca_sg";
    $opcion['1'] = "Lista blanca"; // Todas las listas a sg se renombran a lista blanca
    $datos_sge = json_decode($entradas[0]['3']);
    $titulo_documentos = "Candidato a SGE {$datos_sge[0]->Nombre} {$datos_sge[0]->Apellidos}";
  } else {
    $opcion["lista_logo"] = $entradas[0]['49'];
    $opcion["lista_tipo"] = "normal";
    $titulo_documentos = "";
  }
  
  $res []= $opcion;

  
  $tipos = array(
      'dp' => 'Documento Político',
      'do' => 'Documento Organizativo',
      'de' => 'Documento Ético',
      'di' => 'Documento de Igualdad'
    );
  $i = 2; //orden parte de la votación opcion_orden_parte_votacion
  foreach ($tipos as $tipo => $nombre) {
    $opcion = $entradas[0];
    if (!empty($titulo_documentos)) {
      $opcion['1'] = "$titulo_documentos - $nombre";
    }
	  if (empty($opcion['50.2'])) {
      $opcion['firmantes'] = $opcion[strval(77+$i)];
    } else {
      $opcion['firmantes'] = $opcion['78'];
    }
    if (empty($opcion["75.".($i-1)]))
    {
      $opcion['logo'] = $opcion['49'];
    } else {
      $opcion['logo'] = $opcion[ ['dp'=>'64', 'do'=>'65', 'de'=>'68', 'di'=>'67'][$tipo] ];
    }
    $opcion['orden'] = $i;
    $opcion['post-type'] = "opcion";
    $opcion['form-id'] = "285".$tipo;
    $opcion['form-id-only-num'] = "285";
    $opcion['id'] .= $tipo;
    $opcion['votacion']= ["SG-CCE", "SG-CCE-".strtoupper($tipo)];
    $res []= $opcion;
    $i++;
  }
  return $res;
}

add_filter("pgi_pre_process_285", 'pgi_listas_vistalegre2_categoria');

function pgi_listas_vistalegre2_opciones($entrada, $id_post) {
  global $id_lista;
  $id_lista = $id_post;

  $dni = "DNI/NIE/Pasaporte";
  $hashes = [];
  if ($entrada['84'] != 'CCE') {
    $pos = 1;
    $personas = json_decode($entrada["3"]);
    foreach ($personas as $persona) {
      $hashes[md5("SG-CCE-SG-".$persona->$dni)] = $pos++;
    }
  }
  if ($entrada['84'] != 'SGE') {
    $pos = 1;
    $personas = json_decode($entrada["23"]);
    foreach ($personas as $persona) {
      $hashes[md5("SG-CCE-CCE-".$persona->$dni)] = $pos++;
    }
  }
  $candidatos = get_posts(['post_type' => 'opcion', 'posts_per_page' => 100, 'post_status' => array('any','trash'), 'meta_key' => 'opcion_dni_hash', 'meta_value' => array_keys($hashes)]);
  foreach ($candidatos as $candidato) {
    update_post_meta( $candidato->ID, 'opcion_lista_id', $id_lista );
    update_post_meta( $candidato->ID, 'opcion_posicion', $hashes[get_post_meta($candidato->ID, 'opcion_dni_hash', true)] );
  }
  
  // avisar de todos los que salgan en las listas y que no se encuentren
}
add_filter("pgi_post_process_285", 'pgi_listas_vistalegre2_opciones', 10, 2);

function pgi_listas_vistalegre2_documentos($entrada, $id_post) {
  global $id_lista;
  update_post_meta( $id_post, 'opcion_lista_id', $id_lista );
  update_post_meta( $id_post, 'opcion_posicion', 0 );
  pgi_votacion_lista_categoria($entrada, $id_post);
  update_post_meta( $id_post, 'opcion_plantilla', 'documento' );
}
add_filter("pgi_post_process_285dp", 'pgi_listas_vistalegre2_documentos', 10, 2);
add_filter("pgi_post_process_285do", 'pgi_listas_vistalegre2_documentos', 10, 2);
add_filter("pgi_post_process_285de", 'pgi_listas_vistalegre2_documentos', 10, 2);
add_filter("pgi_post_process_285di", 'pgi_listas_vistalegre2_documentos', 10, 2);




function opciones_documentos( $opciones, $votacion, $respuesta ){
  $opciones = new WP_Query( ['post_type' => 'opcion', 'meta_key' => 'opcion_megaequipo', 'meta_value' => $respuesta->text, 'posts_per_page' => 10000, 'tax_query'=> [['taxonomy'=>'votacion', 'field'=>'term_id', 'terms'=>$votacion->term_id]] ]);
  if ($opciones->have_posts())
    return $opciones;
  
  return NULL;
}

add_filter( 'pgi_process_results_opcion_SG-CCE-DP', 'opciones_documentos', 10, 3 );
add_filter( 'pgi_process_results_opcion_SG-CCE-DO', 'opciones_documentos', 10, 3 );
add_filter( 'pgi_process_results_opcion_SG-CCE-DE', 'opciones_documentos', 10, 3 );
add_filter( 'pgi_process_results_opcion_SG-CCE-DI', 'opciones_documentos', 10, 3 );


function maximo_puntos_candidaturas_cce() {
  return 80;
}
add_filter('pgi_process_results_voting_SG-CCE-CCE_max_points', 'maximo_puntos_candidaturas_cce', 10, 0);
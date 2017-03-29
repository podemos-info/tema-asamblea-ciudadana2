<?php
//Documentos y listas para vistalegre II
function pgi_listas_comision_garantias($forms) {
  $forms['288'] = 'lista';
  return $forms;
}
add_filter('pgi_forms', 'pgi_listas_comision_garantias');


function pgi_listas_comision_garantias_title($title, $entrada) {
  return $entrada["1"];
}
add_filter('pgi_title_288', 'pgi_listas_comision_garantias_title', 10, 2);

function pgi_listas_comision_garantias_content($content, $entrada) {
  return $entrada["17"];
}
add_filter('pgi_content_288', 'pgi_listas_comision_garantias_content', 10, 2);


function pgi_listas_comision_garantias_categorias() {
  pgi_votacion_formulario_listas('288');

  // crear o actualiza la lista blanca para esta votación, que sea fácilmente localizable
}
if (function_exists('pgi_votacion_formulario_listas'))
  add_filter('init', 'pgi_listas_comision_garantias_categorias');


function pgi_listas_comision_garantias_categoria($entradas) {
  $opcion = $entradas[0];
  $opcion["votacion"] = ["CdGD"];
  return [$opcion];
}

add_filter("pgi_pre_process_288", 'pgi_listas_comision_garantias_categoria');

function pgi_listas_comision_garantias_opciones($entrada, $id_post) {
  $dni = "DNI/NIE/Pasaporte";
  $pos = 1;
  $hashes = [];
  $personas = json_decode($entrada["35"]);
  foreach ($personas as $persona) {
    $hashes[md5("CdGD-".$persona->$dni)] = $pos++;
  }
 
  $candidatos = get_posts(['post_type' => 'opcion', 'posts_per_page' => 100, 'post_status' => array('any','trash'), 'meta_key' => 'opcion_dni_hash', 'meta_value' => array_keys($hashes)]);
  foreach ($candidatos as $candidato) {
    update_post_meta( $candidato->ID, 'opcion_lista_id', $id_post );
    update_post_meta( $candidato->ID, 'opcion_posicion', $hashes[get_post_meta($candidato->ID, 'opcion_dni_hash', true)] );
  }
}
add_filter("pgi_post_process_288", 'pgi_listas_comision_garantias_opciones', 10, 2);
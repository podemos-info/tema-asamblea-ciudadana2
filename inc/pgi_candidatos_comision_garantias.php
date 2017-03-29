<?php

// especificamos el cpt que se usará como lista de forma global ya que lo usamos en distintos ambitos de funciones.
global $id_lista_blanca;
//candidaturas vistalegre 2
function pgi_candidatos_comision_garantias($forms) {
  $forms['287'] = 'opcion';
  return $forms;
}
add_filter('pgi_forms', 'pgi_candidatos_comision_garantias');

function pgi_candidatos_comision_garantias_categorias_registradas($cat) {
  $cat['287'] = pgi_candidatos_cg_get_categorias();
  return $cat;
}
add_filter('pgi_cats', 'pgi_candidatos_comision_garantias_categorias_registradas');


function pgi_candidatos_comision_garantias_title($title, $entrada) {
  return mb_convert_case($entrada["1.3"]." ".$entrada["1.6"],MB_CASE_TITLE);
}
add_filter('pgi_title_287', 'pgi_candidatos_comision_garantias_title', 10, 2);

function pgi_candidatos_comision_garantias_content($content, $entrada) {
  return $entrada["25"];
}
add_filter('pgi_content_287', 'pgi_candidatos_comision_garantias_content', 10, 2);


function pgi_candidatos_comision_garantias_mapper($mapper){
  return [
    '60'      => array( 'name' => 'opcion_foto', 'type' => 'thumbnail'),
    '5'       => array( 'name' => 'opcion_video', 'type' => 'text'),
    '44'      => array( 'name' => 'opcion_motivacion', 'type' => 'textarea'),
    '62'      => array( 'name' => 'opcion_sexo', 'type' => 'radio'),
    'lista'   => array( 'name' => 'opcion_lista_id', 'type' => 'text'), //entity
    'posicion'=> array( 'name' => 'opcion_posicion', 'type' => 'text'), //entity
    'dni'     => array( 'name' => 'opcion_dni_hash', 'type' => 'text'),
    'orden'   => array( 'name' => 'opcion_orden_parte_votacion', 'type' => 'text' )
    //Orden parte de la votación
  ];
}
add_filter('pgi_mapper_287', 'pgi_candidatos_comision_garantias_mapper', 10, 2);

function pgi_candidaturas_comision_garantias_campo_radio_62($valor) {
    if ($valor == "Hombre") {
  return 0;
    }elseif($valor == "Mujer"){
  return 1;
    }
}
add_filter('pgi_campo_287_62', 'pgi_candidaturas_comision_garantias_campo_radio_62');

function pgi_candidatos_cg_get_categorias(){
  return array(
    'CdGD' => [
      'name' => 'Comisión de Garantías', 
      'slug' => 'comision-garantias', 
      'codigo' => '-', 
      'partes' => [
        'CdGD-E' => [
          'name' => 'Comisión de Garantías Estatal', 
          'slug' => 'comision-garantias-estatal' 
        ],
      ]
    ] 
  );
}


function pgi_candidatos_comision_garantias_categorias() {
  pgi_votacion_formulario_opciones('287');
}
if (function_exists('pgi_votacion_formulario_opciones')){ //Usamos la misma función definida en pgi_votaciones
  add_filter('init', 'pgi_candidatos_comision_garantias_categorias');
}


function pgi_candidatos_comision_garantias_candidaturas_a_opciones($entrada) {
  global $id_lista_blanca;
  $opcion = $entrada[0];
  $categorias = pgi_candidatos_cg_get_categorias();
  reset($categorias);
  $first_key = key($categorias);
  if (empty($id_lista_blanca)) { 
    $lista_blanca = get_posts(['post_type' => 'lista', 'post_status' => array('any','trash'), 'meta_key' => 'lista_blanca_votacion_id', 'meta_value' => $first_key, 'posts_per_page' => 1]);
    $id_lista_blanca = $lista_blanca[0]->ID;
  }
  $opcion['dni'] = md5("CdGD-".$opcion['2']);
  $opcion['votacion'] = [ 'CdGD', 'CdGD-E' ];
  $opcion["lista"] = $id_lista_blanca;
  $opcion["posicion"] = 0;

  return [$opcion];
}

add_filter("pgi_pre_process_287", 'pgi_candidatos_comision_garantias_candidaturas_a_opciones');

function pgi_lista_blanca_garantias($entradas){
  global $id_lista_blanca;
  //Comprobar que no exista la lista blanca ya
  $categorias = pgi_candidatos_cg_get_categorias();
  reset($categorias);
  $first_key = key($categorias);

  //Atención si la lista blanca esta en la papelerá no volvera a crearla.
  if (empty(get_posts(['post_type' => 'lista', 'post_status' => array('any','trash'), 'meta_key' => 'lista_blanca_votacion_id', 'meta_value' => $first_key, 'posts_per_page' => 1]))) {
    $title = "Lista blanca";
    $slug = sanitize_title($title);
    $author_id = 1;
    $postAttr = array(
      'comment_status'    =>  'closed',
      'post_author'       =>  $author_id,
      'post_name'         =>  $slug,
      'post_title'        =>  $title,
      'post_status'       =>  'publish',
      'post_type'         =>  'lista'
    );
    $id_lista_blanca = wp_insert_post($postAttr);
    if ($id_lista_blanca < 1) {
      $id_lista_blanca = wp_insert_post($postAttr, true);
      //Devuelvo un string para dar un feedback en el admin
      return "Hubo un problema creando la lista blanca: ".var_dump($id_lista_blanca)." \n<br>";
    } else {
      update_post_meta( $id_lista_blanca, 'lista_tipo', 'blanca' );
      update_post_meta( $id_lista_blanca, 'lista_blanca_votacion_id', $first_key );
      wp_set_object_terms( $id_lista_blanca, $categorias[$first_key]['slug'], 'votacion', false );
    }
  }
  
  //No hago nada con las entradas. Sólo uso el filter para crear una lista blanca por defecto si no se creó ya.
  return $entradas;
}
add_filter("pgi_pre_import_287", "pgi_lista_blanca_garantias");

function pgi_candidatos_comision_garantias_post_format($entrada, $post_id) {
  update_post_meta( $post_id ,'opcion_plantilla', 'candidato');
}
add_action("pgi_post_process_287", 'pgi_candidatos_comision_garantias_post_format', 10, 2);

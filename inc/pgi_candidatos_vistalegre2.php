<?php

global $id_lista_blanca;
function pgi_candidatos_vistalegre2($forms) {
  $forms['284'] = 'opcion';
  return $forms;
}
add_filter('pgi_forms', 'pgi_candidatos_vistalegre2');

function pgi_candidatos_vistalegre2_categorias_registradas($cat) {
  $cat['284'] = pgi_candidatos_get_categorias();
  return $cat;
}
add_filter('pgi_cats', 'pgi_candidatos_vistalegre2_categorias_registradas');

function pgi_candidatos_vistalegre2_title($title, $entrada) {
  return mb_convert_case($entrada["1.3"]." ".$entrada["1.6"],MB_CASE_TITLE);
}
add_filter('pgi_title_284', 'pgi_candidatos_vistalegre2_title', 10, 2);

function pgi_candidatos_vistalegre2_content($content, $entrada) {
  return $entrada["25"];
}
add_filter('pgi_content_284', 'pgi_candidatos_vistalegre2_content', 10, 2);


function pgi_candidatos_vistalegre2_mapper($mapper){
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
add_filter('pgi_mapper_284', 'pgi_candidatos_vistalegre2_mapper', 10, 2);

function pgi_candidaturas_campo_radio_62($valor) {
  if ($valor == "Hombre") {
    return "0";
  }elseif($valor == "Mujer"){
    return "1";
  }
}
add_filter('pgi_campo_284_62', 'pgi_candidaturas_campo_radio_62');

function pgi_candidatos_get_categorias(){
  return array(
    'SG-CCE' => [
    	'name' => 'Asamblea Ciudadana', 
    	'slug' => 'asamblea-ciudadana', 
    	'partes' => [
    		'SG-CCE-SG' => [
          'name' => 'Secretaría General', 
          'slug' => 'secretaria-general' 
        ],
          'SG-CCE-DP' => [
          'name' => 'Documento Político', 
          'slug' => 'documento-politico' 
        ],
          'SG-CCE-DI' => [
          'name' => 'Documento de Igualdad', 
          'slug' => 'documento-igualdad'
        ],
          'SG-CCE-DO' => [
          'name' => 'Documento Organizativo', 
          'slug' => 'documento-organizativo' 
        ],
          'SG-CCE-DE' => [
          'name' => 'Documento Ético', 
          'slug' => 'documento-etico' 
        ],
          'SG-CCE-CCE' => [  //comprobar que los nombres de las categorías son correctos, los he deducido.
          'name' => 'Consejo ciudadano estatal', 
          'slug' => 'consejo-ciudadano-estatal' 
        ],
      ]
    ] 
  );
}

function pgi_candidatos_vistalegre2_categorias() {
  pgi_votacion_formulario_opciones('284');
}
if (function_exists('pgi_votacion_formulario_opciones')){ //Usamos la misma función definida en pgi_votaciones
  add_filter('init', 'pgi_candidatos_vistalegre2_categorias');
}


function pgi_candidatos_vistalegre2_candidaturas_a_opciones($entrada) {
  global $id_lista_blanca;
  $res = [];
  $opcion = $entrada[0];
  //asignar referencia a lista blanca de la votacion a la opcion tendremos que crear una lista blanca inicialmente justo despues de definir el custom post type lista ?
  $categorias = pgi_candidatos_get_categorias();
  reset($categorias);
  $first_key = key($categorias);
  if (empty($id_lista_blanca)) { 
    // Si no hay id en la variable global recuperamos el id de la lista blanca. Así en teoría sólo se recupera una vez por cada ejecución.
    $lista_blanca = get_posts(['post_type' => 'lista', 'post_status' => array('any','trash'), 'meta_key' => 'lista_blanca_votacion_id', 'meta_value' => $first_key, 'posts_per_page' => 1]);
    $id_lista_blanca = $lista_blanca[0]->ID;
  }

  //se presenta a SG? -> duplicar opcion, cambiar id y asignar a votacion SG
  // Si 96.1 no está vacio
  if (!empty($opcion['96.1'])) {
    $opcion['orden'] = '1'; 
    $opcion['id'] .= 'sg';
    $opcion['dni'] = md5("SG-CCE-SG-".$opcion['2']);
    $opcion['votacion'] = [ 'SG-CCE', 'SG-CCE-SG' ];
    $opcion["lista"] = $id_lista_blanca;
    $opcion["posicion"] = 0;
    $res []= $opcion;
  }

  $opcion = $entrada[0]; //Reiniciamos la variable opción
  //se presenta al CCE? -> duplicar opcion, cambiar id y asignar a votacion CCE
  // Si 96.2 no está vacio
  if (!empty($opcion['96.2'])) {
    $opcion['orden'] = '6'; 
    $opcion['id'] .= 'cce';
    $opcion['dni'] = md5("SG-CCE-CCE-".$opcion['2']); // SUPONGO QUE EL DNI LO GUARDAMOS EN TODAS LAS ENTRADAS QUE CREAMOS
    $opcion['votacion'] = [ 'SG-CCE', 'SG-CCE-CCE' ];
    $opcion["lista"] = $id_lista_blanca;
    $opcion["posicion"] = 0;
    $res []= $opcion;
  } 
  return $res;
}

add_filter("pgi_pre_process_284", 'pgi_candidatos_vistalegre2_candidaturas_a_opciones');

function pgi_lista_blanca_genérica($entradas){
  global $id_lista_blanca;
  //Comprobar que no exista la lista blanca ya
  $categorias = pgi_candidatos_get_categorias();
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
add_filter("pgi_pre_import_284", "pgi_lista_blanca_genérica");

function pgi_candidatos_vistalegre2_post_format($entrada, $post_id) {
   update_post_meta( $post_id ,'opcion_plantilla', 'candidato');
}
add_action("pgi_post_process_284", 'pgi_candidatos_vistalegre2_post_format', 10, 2);

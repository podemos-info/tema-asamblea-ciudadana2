<?php
function pgi_circulos_cce($forms) {
  $forms['273'] = 'opcion';
  return $forms;
}
add_filter('pgi_forms', 'pgi_circulos_cce');

function pgi_circulos_cce_categorias_registradas($cat) {
  $cat['273'] = pgi_circulos_cce_get_categorias();
  return $cat;
}
add_filter('pgi_cats', 'pgi_circulos_cce_categorias_registradas');


function pgi_circulos_cce_title($title, $entrada) {
  return $entrada["1.3"]." ".$entrada["1.6"];
}
add_filter('pgi_title_273', 'pgi_circulos_cce_title', 10, 2);

function pgi_circulos_cce_content($content, $entrada) {
  return $entrada["25"];
}
add_filter('pgi_content_273', 'pgi_circulos_cce_content', 10, 2);


function pgi_circulos_cce_mapper($mapper){
        return [
            '60'  => array( 'name' => 'opcion_foto', 'type' => 'thumbnail'),
            '5'   => array( 'name' => 'opcion_video', 'type' => 'text'),
            '44'  => array( 'name' => 'opcion_propuestas', 'type' => 'textarea'),
            '62'  => array( 'name' => 'opcion_sexo', 'type' => 'radio'),
            '80'  => array( 'name' => 'opcion_circulo', 'type' => 'text' ),
            '93'  => array( 'name' => 'opcion_organo', 'type' => 'text' )
        ];
}
add_filter('pgi_mapper_273', 'pgi_circulos_cce_mapper', 10, 2);

function pgi_circulos_definicion_opciones($definiciones) {
	$definiciones[]= 
    [ 'id' => 273, 'nombre' => 'Circulos CCE', 'campos' => [
          [ 'key' => 'opcion_propuestas', 'label' => 'Propuestas', 'name' => 'opcion_propuestas', 'type' => 'textarea'] , 
      	  [ 'key' => 'opcion_circulo', 'label' => 'Circulo que avala', 'name' => 'opcion_circulo', 'type' => 'text' ]
	  ]];
	return $definiciones;
}
add_filter('definicion_opcion', 'pgi_circulos_definicion_opciones');

function pgi_opciones_campo_radio_62($valor) {
    if ($valor == "Hombre") {
  return 0;
    }elseif($valor == "Mujer"){
  return 1;
    }
}
add_filter('pgi_campo_273_62', 'pgi_opciones_campo_radio_62');

function pgi_circulos_cce_get_categorias(){
  return array(
    'REPR-CIRCULOS' => [
      'name' => 'Candidaturas a representantes de los Círculos en el CCE', 
      'slug' => 'representantes-circulos', 
      'codigo' => '-', 
      'partes' => ['REPR-CIRCULOS-SECTORIAL' => [
                    'name' => 'Círculos Sectoriales', 
                    'slug' => 'representantes-circulos-sectoriales' 
                  ], 
      'REPR-CIRCULOS-TERRITORIAL' => [
                    'name' => 'Círculos Territoriales', 
                    'slug' => 'representantes-circulos-territoriales' 
                  ]
      ]
    ] 
  );
}


function pgi_circulos_cce_categorias() {
	pgi_votacion_formulario_opciones('273');
}
if (function_exists('pgi_votacion_formulario_opciones')){
  add_filter('init', 'pgi_circulos_cce_categorias');
}


function pgi_circulos_cce_candidaturas_a_opciones($entradas) {
  if ($entradas[0]["93"]=="Representante en el CCE de los Círculos territoriales")
     $entradas[0]["votacion"] = ["REPR-CIRCULOS", "REPR-CIRCULOS-TERRITORIAL"];
  else
     $entradas[0]["votacion"] = ["REPR-CIRCULOS", "REPR-CIRCULOS-SECTORIAL"];
  return $entradas;
}

add_filter("pgi_pre_process_273", 'pgi_circulos_cce_candidaturas_a_opciones');


function pgi_circulos_cce_post_format($entrada, $post_id) {
   update_post_meta( $post_id ,'opcion_plantilla', 'candidato-circulo');
}
add_action("pgi_post_process_273", 'pgi_circulos_cce_post_format', 10, 2);

<?php
function pgi_registrar_aportaciones($forms) {
	$forms['272'] = 'aportacion';
	return $forms;
}
add_filter('pgi_forms', 'pgi_registrar_aportaciones');

function pgi_aportaciones_mapper($mapper){
        return [ '25' => [ 'name' => 'aportacion_titulo', 'type' => 'text' ],
                 '48' => [ 'name' => 'aportacion_resumen', 'type' => 'textarea' ],
                 '49' => [ 'name' => 'aportacion_tematica', 'type' => 'text' ],
                 '26' => [ 'name' => 'aportacion_documento', 'type' => 'file' ],
                 '27' => [ 'name' => 'aportacion_equipo', 'type' => 'textarea' ],
                 '12' => [ 'name' => 'aportacion_email', 'type' => 'email' ] ];
}
add_filter('pgi_mapper_272', 'pgi_aportaciones_mapper');

function pgi_aportaciones_title($titulo, $entrada) {
	return $entrada['25'];
}
add_filter('pgi_title_272', 'pgi_aportaciones_title', 10, 2);

function add_aportaciones_provisionales() {
  $supports = [ 'title' ];
  if(function_exists("register_field_group"))
  {
    register_field_group( [
      'id' => 'pgi_aportaciones_provisionales_para_vistalegre_ii',
      'title' => 'Aportaciones provisionales para Vistalegre II',
      'fields' => [
          [ 'key' => 'aportacion_titulo', 'label' => 'Título', 'name' => 'aportacion_titulo', 'type' => 'text' ] ,
          [ 'key' => 'aportacion_resumen', 'label' => 'Resumen', 'name' => 'aportacion_resumen', 'type' => 'textarea' ] ,
          [ 'key' => 'aportacion_tematica', 'label' => 'Temática', 'name' => 'aportacion_tematica', 'type' => 'textarea' ] ,
          [ 'key' => 'aportacion_documento', 'label' => 'Documento', 'name' => 'aportacion_documento', 'type' => 'file' ] ,
          [ 'key' => 'aportacion_equipo', 'label' => 'Equipo', 'name' => 'aportacion_equipo', 'type' => 'textarea' ] ,
          [ 'key' => 'aportacion_email', 'label' => 'Email', 'name' => 'aportacion_email', 'type' => 'email' ] ,
        ],
      'location' => [[[ 'param' => 'post_type', 'operator' => '==', 'value' => 'aportacion', 'order_no' => 2, 'group_no' => 2 ]]],
      'options' => [ 'position' => 'normal', 'layout' => 'no_box', 'hide_on_screen' => []],
      'menu_order' => 2,
    ]);
  } else {
    $supports []= "custom-fields";
  }

  register_post_type('aportacion', [
    'labels' => [
        'name' => __('Aportaciones', 'pgi-import'),
        'singular_name' => __('Aportacion', 'pgi-import'),
        'add_new' => __('Añadir nueva', 'pgi-import'),
        'add_new_item' => __('Añadir nueva aportación', 'pgi-import'),
        'edit' => __('Editar', 'pgi-import'),
        'edit_item' => __('Editar aportación', 'pgi-import'),
        'new_item' => __('Nuevo aportación', 'pgi-import'),
        'view' => __('Ver', 'pgi-import'),
        'view_item' => __('Ver aportación', 'pgi-import'),
        'search_items' => __('Buscar aportación', 'pgi-import'),
        'not_found' => __('No se han encontrado aportaciones', 'pgi-import'),
        'not_found_in_trash' => __('No se han encontrado aportaciones en la papelera', 'pgi-import')
    ],
    'public' => true,
    'hierarchical' => false,
    'has_archive' => true,
    'supports' => $supports,
    'can_export' => true,
    'taxonomies' => [  ], 
    'rewrite' => [ 'slug' => _x( 'aportaciones', 'URL slug', 'pgi-import' ), 'with_front' => false ],
    'menu_icon' => 'dashicons-format-aside',
    'menu_position' => 10
  ]);
}
add_action( 'init' , 'add_aportaciones_provisionales' );


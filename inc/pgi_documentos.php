<?php
function pgi_registrar_formularios($forms) {
	$forms['271'] = 'documentos';
	return $forms;
}
add_filter('pgi_forms', 'pgi_registrar_formularios');

function pgi_documentos_mapper($mapper){
        return [
            '2.1' => array( 'name' => 'documentos_obligatorio_2', 'type' => 'checkbox'),
            '3.1' => array( 'name' => 'documentos_obligatorio_3', 'type' => 'checkbox'),
            '5'   => array( 'name' => 'documentos_participa_user_id', 'type' => 'text'),
            '14'  => array( 'name' => 'documentos_documento_politico', 'type' => 'checkbox'),
            '25'  => array( 'name' => 'documentos_titulo_del_documento_25', 'type' => 'text'),
            '48'  => array( 'name' => 'documentos_resumen_del_documento_politico', 'type' => 'textarea'),
            '26'  => array( 'name' => 'documentos_subir_documento_en_pdf_26', 'type' => 'file'),
            '15'  => array( 'name' => 'documentos_documento_organizativo', 'type' => 'checkbox'),
            '28'  => array( 'name' => 'documentos_titulo_del_documento_28', 'type' => 'text'),
            '49'  => array( 'name' => 'documentos_resumen_del_documento_organizativo', 'type' => 'textarea'),
            '29'  => array( 'name' => 'documentos_subir_documento_en_pdf_29', 'type' => 'file'),
            '16'  => array( 'name' => 'documentos_documento__tico', 'type' => 'checkbox'),
            '30'  => array( 'name' => 'documentos_titulo_del_documento_30', 'type' => 'text'),
            '50'  => array( 'name' => 'documentos_resumen_del_documento__tico', 'type' => 'textarea'),
            '31'  => array( 'name' => 'documentos_subir_documento_en_pdf_31', 'type' => 'file'),
            '17'  => array( 'name' => 'documentos_documento_de_igualdad', 'type' => 'checkbox'),
            '32'  => array( 'name' => 'documentos_titulo_del_documento_32', 'type' => 'text'),
            '51'  => array( 'name' => 'documentos_resumen_del_documento_de_igualdad', 'type' => 'textarea'),
            '33'  => array( 'name' => 'documentos_subir_documento_en_pdf_33', 'type' => 'file'),
            '27'  => array( 'name' => 'documentos_equipo', 'type' => 'textarea'),
            '47'  => array( 'name' => 'documentos_logo_del_equipo__imagen_47', 'type' => 'file'),
            '52'  => array( 'name' => 'documentos_al_hacer_click_en_los_documentos__prefieres___', 'type' => 'radio'),
            '53'  => array( 'name' => 'documentos_web_de_la_candidatura', 'type' => 'text'),
            '12'  => array( 'name' => 'documentos_correo_electronico_del_equipo', 'type' => 'email'),
            '46'  => array( 'name' => 'documentos_obligatorio_46', 'type' => 'checkbox')           
	];
}
add_filter('pgi_mapper_271', 'pgi_documentos_mapper');

function pgi_documentos_title($title, $entrada) {
        $title = "";
        if (isset($entrada['25']) AND !empty($entrada['25'])) {
            $title .= $entrada['25'];
        } elseif (isset($entrada['28']) AND !empty($entrada['28'])) {
            $title .= $entrada['28'];
        } elseif (isset($entrada['30']) AND !empty($entrada['30'])) {
	    $title .= $entrada['30'];
	} elseif (isset($entrada['32']) AND !empty($entrada['32'])) {
	    $title .= $entrada['32'];
	}
	return $title;
}
add_filter('pgi_title_271', 'pgi_documentos_title', 10, 2);

function pgi_documentos_campo_radio($valor) {
    if ($valor == "Que se abran los documentos para que se puedan leer") {
	return "0";
    }elseif($valor == "Que se redirija a la página web de la candidatura"){
	return "1";
    }
}
add_filter('pgi_campo_271_52', 'pgi_documentos_campo_radio');

function add_documentos_provisionales() {
  $supports = [ 'title' ];
  if(function_exists("register_field_group"))
  {
    register_field_group( [
      'id' => 'pgi_documentos_provisionales_para_vistalegre_ii',
      'title' => 'Documentos provisionales para Vistalegre II',
      'fields' => [
        [ 'key' => 'pgi_271_2', 'label' => 'Obligatorio', 'name' => 'documentos_obligatorio_2', 'type' => 'checkbox', 'choices' => array('0' => 'Entiendo y acepto el contenido del Aviso anterior'), ] , 
          [ 'key' => 'pgi_271_3', 'label' => 'Obligatorio', 'name' => 'documentos_obligatorio_3', 'type' => 'checkbox', 'choices' => array('0' => 'He leído y acepto el contenido de las Consideraciones generales para la elaboración de documentos'), ] , 
          [ 'key' => 'pgi_271_5', 'label' => 'participa_user_id', 'name' => 'documentos_participa_user_id', 'type' => 'text' ] , 
          [ 'key' => 'pgi_271_14', 'label' => 'Documento Político', 'name' => 'documentos_documento_politico', 'type' => 'checkbox', 'choices' => array('0' => 'Documento Político'), ] , 
          [ 'key' => 'pgi_271_25', 'label' => 'Título del documento político', 'name' => 'documentos_titulo_del_documento_25', 'type' => 'text' ] , 
          [ 'key' => 'pgi_271_48', 'label' => 'Resumen del Documento Político', 'name' => 'documentos_resumen_del_documento_politico', 'type' => 'textarea' ] , 
          [ 'key' => 'pgi_271_26', 'label' => 'Subir documento en PDF', 'name' => 'documentos_subir_documento_en_pdf_26', 'type' => 'file' ] , 
          [ 'key' => 'pgi_271_15', 'label' => 'Documento Organizativo', 'name' => 'documentos_documento_organizativo', 'type' => 'checkbox', 'choices' => array('0' => 'Documento Organizativo'), ] , 
          [ 'key' => 'pgi_271_28', 'label' => 'Título del documento Organizativo', 'name' => 'documentos_titulo_del_documento_28', 'type' => 'text' ] , 
          [ 'key' => 'pgi_271_49', 'label' => 'Resumen del Documento Organizativo', 'name' => 'documentos_resumen_del_documento_organizativo', 'type' => 'textarea' ] , 
          [ 'key' => 'pgi_271_29', 'label' => 'Subir documento en PDF', 'name' => 'documentos_subir_documento_en_pdf_29', 'type' => 'file' ] , 
          [ 'key' => 'pgi_271_16', 'label' => 'Documento Ético', 'name' => 'documentos_documento__tico', 'type' => 'checkbox', 'choices' => array('0' => 'Documento Ético'), ] , 
          [ 'key' => 'pgi_271_30', 'label' => 'Título del documento ético', 'name' => 'documentos_titulo_del_documento_30', 'type' => 'text' ] , 
          [ 'key' => 'pgi_271_50', 'label' => 'Resumen del Documento Ético', 'name' => 'documentos_resumen_del_documento__tico', 'type' => 'textarea' ] , 
          [ 'key' => 'pgi_271_31', 'label' => 'Subir documento en PDF', 'name' => 'documentos_subir_documento_en_pdf_31', 'type' => 'file' ] ,
          [ 'key' => 'pgi_271_17', 'label' => 'Documento de Igualdad', 'name' => 'documentos_documento_de_igualdad', 'type' => 'checkbox', 'choices' => array('0' => 'Documento de Igualdad'), ] , 
          [ 'key' => 'pgi_271_32', 'label' => 'Título del documento de igualdad', 'name' => 'documentos_titulo_del_documento_32', 'type' => 'text' ] , 
          [ 'key' => 'pgi_271_51', 'label' => 'Resumen del Documento de Igualdad', 'name' => 'documentos_resumen_del_documento_de_igualdad', 'type' => 'textarea' ] , 
          [ 'key' => 'pgi_271_33', 'label' => 'Subir documento en PDF', 'name' => 'documentos_subir_documento_en_pdf_33', 'type' => 'file' ] ,
          [ 'key' => 'pgi_271_27', 'label' => 'Equipo de personas que firman el/los documento(s)', 'name' => 'documentos_equipo', 'type' => 'textarea' ] , 
          [ 'key' => 'pgi_271_47', 'label' => 'Logo del equipo (imagen)', 'name' => 'documentos_logo_del_equipo__imagen_47', 'type' => 'file' ] ,
          [ 'key' => 'pgi_271_52', 'label' => 'Al hacer click en los documentos, prefieres...', 'name' => 'documentos_al_hacer_click_en_los_documentos__prefieres___', 'type' => 'radio', 'choices' => array('0' => 'Que se abran los documentos para que se puedan leer','1' => 'Que se redirija a la página web de la candidatura',), ] , 
          [ 'key' => 'pgi_271_53', 'label' => 'Web de la candidatura', 'name' => 'documentos_web_de_la_candidatura', 'type' => 'text' ] , 
          [ 'key' => 'pgi_271_12', 'label' => 'Correo electrónico del equipo', 'name' => 'documentos_correo_electronico_del_equipo', 'type' => 'email' ] , 
          [ 'key' => 'pgi_271_46', 'label' => 'Obligatorio', 'name' => 'documentos_obligatorio_46', 'type' => 'checkbox', 'choices' => array('0' => 'Acepto la Política de Privacidad'), ] , 
        ],
      'location' => [[[ 'param' => 'post_type', 'operator' => '==', 'value' => 'documentos', 'order_no' => 2, 'group_no' => 2 ]]],
      'options' => [ 'position' => 'normal', 'layout' => 'no_box', 'hide_on_screen' => []],
      'menu_order' => 2,
    ]);
  } else {
    $supports []= "custom-fields";
  }
  
  register_post_type('documentos', [
    'labels' => [
        'name' => __('Documentos', 'pgi-import'),
        'singular_name' => __('Documento', 'pgi-import'),
        'add_new' => __('Añadir nuevo', 'pgi-import'),
        'add_new_item' => __('Añadir nuevo documento', 'pgi-import'),
        'edit' => __('Editar', 'pgi-import'),
        'edit_item' => __('Editar documento', 'pgi-import'),
        'new_item' => __('Nuevo documento', 'pgi-import'),
        'view' => __('Ver', 'pgi-import'),
        'view_item' => __('Ver documento', 'pgi-import'),
        'search_items' => __('Buscar documento', 'pgi-import'),
        'not_found' => __('No se han encontrado documentos', 'pgi-import'),
        'not_found_in_trash' => __('No se han encontrado documentos en la papelera', 'pgi-import')
    ],
    'public' => true,
    'hierarchical' => false,
    'has_archive' => true,
    'supports' => $supports,
    'can_export' => true,
    'taxonomies' => [  ], 
    'rewrite' => [ 'slug' => _x( 'documentos', 'URL slug', 'pgi-import' ), 'with_front' => false ],
    'menu_icon' => 'dashicons-format-aside',
    'menu_position' => 10
  ]);
}
add_action( 'init' , 'add_documentos_provisionales' );


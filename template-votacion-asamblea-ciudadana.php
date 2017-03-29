<?php /* Template Name: Votación SG-CCE */
$out = fopen('php://output', 'w');

$megaequipos = [];

the_post();

$listado_genero = [];
$post_id = get_the_ID();
$title = get_post_meta($post_id, 'title', true);
$election_id = get_post_meta($post_id, 'election_id', true);
$start_date = get_post_meta($post_id, 'start_date', true);
$duration = get_post_meta($post_id, 'duration', true);
$description = get_post_meta($post_id, 'description', true);
$share_text = get_post_meta($post_id, 'share_text', true);
?>
#Election
Title	<?php echo $title?>	
Id	<?php echo $election_id?>	
Layout	
Description	<?php echo $description?>	
Start date time	<?php echo $start_date?>	
Duration in hours	<?php echo $duration?>	
Share Text	<?php echo $share_text?>	
Theme	podemos	
<?php
$documentos = ["documento-politico" => "Documento Político",
               "documento-organizativo" => "Documento Organizativo",
               "documento-etico" => "Documento Ético",
               "documento-igualdad" => "Documento de Igualdad"];
foreach($documentos as $slug => $name): ?>

#Question
Title	<?php echo $name;?>	
Description	Elige un documento de la siguiente lista
Voting system	plurality-at-large	
Layout	accordion	
Number of winners	1	
Minimum choices	0	
Maximum choices	1	
Totals	over-total-valid-votes	
extra: shuffle_categories	TRUE	
extra: shuffle_all_options	TRUE	

@Options
Id	Text	Category	Image URL	URL	Description
<?php
$i = 0;
$opciones = get_posts(['posts_per_page'=>'200', 'post_type' => 'opcion', 'tax_query' => [[ 'taxonomy' => 'votacion', 'field'=>'slug', 'terms' => $slug ]]]);
foreach ($opciones as $opcion){
  $data = [];
  $megaequipo = get_post_meta($opcion->ID, 'opcion_megaequipo', true);
  $lista_id = get_post_meta($opcion->ID, 'opcion_lista_id', true);
  $documento_id = get_post_meta($opcion->ID, 'opcion_documento', true);
  $firmantes = get_post_meta($opcion->ID, 'opcion_firmantes', true);
  $lista = get_post($lista_id);
  $lista_nombre = $lista->post_title;
  $title = $opcion->post_title;
  $logo = get_the_post_thumbnail_url($lista_id, 'thumbnail');
  if (!empty($megaequipo)) {
    if (array_key_exists("$slug-$megaequipo", $megaequipos)) continue;
    $megaequipos["$slug-$megaequipo"] = 1;
    $lista_nombre = $title = $megaequipo;
    $logo_tmp = get_the_post_thumbnail_url($opcion->ID, 'thumbnail');
    if (!empty($logo_tmp)){
      $logo = $logo_tmp;
    }
  }

  $data []= $i++;
  $data []= $title;
  $data []= $lista_nombre;
  $data []= $logo;
  $data []= wp_get_attachment_url( $documento_id);
  $data []= $firmantes;
  
  fputcsv($out, $data, "\t");
}?>

<?php endforeach;?>
          
#Question
Title	Consejo Ciudadano Estatal	
Description	Elige hasta 62 personas	
Voting system	desborda	
Layout	accordion	
Number of winners	62	
Minimum choices	0	
Maximum choices	62	
Randomize options order	FALSE	
Totals	over-total-valid-votes	
extra: shuffle_category_list	Lista blanca	
extra: shuffle_categories	TRUE	

@Options
Id	Text	Category	Image URL	URL	
<?php
$i = 0;
$opciones = get_posts(['posts_per_page'=>'500', 'post_type' => 'opcion', 'tax_query' => [[ 'taxonomy' => 'votacion', 'field'=>'slug', 'terms' => 'consejo-ciudadano-estatal' ]], 'orderby' => [ 'lista' => 'ASC', 'posicion' => 'ASC' ], 'meta_query' => [ 'posicion' => [ 'key' => 'opcion_posicion', 'type'=>'NUMERIC'], 'lista' => ['key'=>'opcion_lista_id'] ]]);
foreach ($opciones as $opcion){
  $lista_id = get_post_meta($opcion->ID, 'opcion_lista_id', true);
  $lista = get_post($lista_id);

  $data = [];
  $data []= $i++;
  $data []= $opcion->post_title;
  $data []= $lista->post_title;
  $data []= get_the_post_thumbnail_url($opcion,'miniatura150');
  $data []= get_permalink( $opcion);

  $listado_genero []= [ $election_id, $opcion->post_title, get_post_meta($opcion->ID, 'opcion_sexo', true) == "0" ? "H" : "M" ];
  fputcsv($out, $data, "\t");
}?>

  
#Question	
Title	Secretaría General	
Description	Elige a 1 persona	
Voting system	plurality-at-large	
Layout	accordion	
Number of winners	1	
Minimum choices	0	
Maximum choices	1	
Randomize options order	TRUE	
Totals	over-total-valid-votes	
extra: shuffle_categories	TRUE	
extra: shuffle_all_options	TRUE	

@Options
Id	Text	Category	Image URL	URL	
<?php
$i = 0;
$opciones = get_posts(['posts_per_page'=>'200', 'post_type' => 'opcion', 'tax_query' => [[ 'taxonomy' => 'votacion', 'field'=>'slug', 'terms' =>  'secretaria-general' ]]]);
foreach ($opciones as $opcion){
  $lista_id = get_post_meta($opcion->ID, 'opcion_lista_id', true);
  $lista = get_post($lista_id);

  $data = [];
  $data []= $i++;
  $data []= $opcion->post_title;
  $data []= $lista->post_title;
  $data []= get_the_post_thumbnail_url($opcion,'miniatura150');
  $data []= get_permalink( $opcion);
  
  $listado_genero []= [ $election_id, $opcion->post_title, get_post_meta($opcion->ID, 'opcion_sexo', true) == "0" ? "H" : "M" ];
  fputcsv($out, $data, "\t");
}?>





-----
<?php foreach ($listado_genero as $data) {
  fputcsv($out, $data, "\t");
}?>

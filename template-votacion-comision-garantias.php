<?php /* Template Name: Votación CdGD */
$out = fopen('php://output', 'w');

$listado_genero = [];
$megaequipos = [];

the_post();
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
          
#Question
Title	Comisión de Garantías Estatal	
Description	Elige hasta 5 personas	
Voting system	plurality-at-large			
Layout	accordion	
Number of winners	5	
Minimum choices	0	
Maximum choices	5	
Randomize options order	TRUE	
Totals	over-total-valid-votes	
extra: shuffle_category_list	Lista blanca	
extra: shuffle_categories	TRUE	

@Options
Id	Text	Category	Image URL	URL	
<?php
$i = 0;
$opciones = get_posts(['posts_per_page'=>'500', 'post_type' => 'opcion', 'tax_query' => [[ 'taxonomy' => 'votacion', 'field'=>'slug', 'terms' => 'comision-garantias' ]], 'orderby' => [ 'lista' => 'ASC', 'posicion' => 'ASC' ], 'meta_query' => [ 'posicion' => [ 'key' => 'opcion_posicion', 'type'=>'NUMERIC'], 'lista' => ['key'=>'opcion_lista_id'] ] ]);
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
<?php

$opcion_video = get_post_meta($post->ID, 'opcion_video', true);
$opcion_biografia = get_the_content();
$opcion_motivacion = get_post_meta($post->ID, 'opcion_motivacion', true);
$opcion_organo = get_post_meta($post->ID, 'opcion_organo', true);
$opcion_circulo = get_post_meta($post->ID, 'opcion_circulo', true);
$opcion_lista = get_post_meta($post->ID, 'opcion_lista_id', true);


// process full name
$opcion_nombre_completo = get_the_title();
if(mb_convert_case($opcion_nombre_completo, MB_CASE_UPPER)==$opcion_nombre_completo || mb_convert_case($opcion_nombre_completo, MB_CASE_LOWER)==$opcion_nombre_completo)
  $opcion_nombre_completo = mb_convert_case($opcion_nombre_completo, MB_CASE_TITLE);

// replace line breaks with p tags
$opcion_biografia = str_replace( "\n", '</p><p>', $opcion_biografia );
$opcion_motivacion = str_replace( "\n", '</p><p>', $opcion_motivacion );

// convert urls to links
$opcion_biografia = linkify($opcion_biografia);
$opcion_motivacion = linkify($opcion_motivacion);

// get youtube embed
if($opcion_video){
  $res = preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $opcion_video, $matches);
  $yt_id = $res ? $matches[1] : '';
  $opcion_youtube_embed = $yt_id ? '<div class="embed-responsive embed-responsive-16by9"><iframe src="https://www.youtube.com/embed/'.$yt_id.'" frameborder="0" allowfullscreen></iframe></div>' : '';
}
if($opcion_lista)
$nombre_lista = get_the_title( $opcion_lista );

$opciones = get_posts([ 'posts_per_page' => 80, 'post_type' => 'opcion', 'orderby' => [ 'parte_votacion' => 'ASC', 'posicion' => 'ASC', 'rand'=>'ASC'], 
                        'meta_query' => ['parte_votacion' => ['key' => 'opcion_orden_parte_votacion', 'compare' => 'EXISTS'], 
                                        'posicion' => ['key' => 'opcion_posicion', 'compare' => 'EXISTS'],
                                        'lista' => ['key' => 'opcion_lista_id', 'compare'=>'=', 'value'=>$post->ID]
                                       ]
                      ]);

// image attributes
$thumb_attrs = [ "title" => $opcion_nombre_completo, "alt" => $opcion_nombre_completo, "class" => "opcion-image" ];
?>
         <div class="row">
            <!-- imagen -->
            <div class="col-12">
              <div class="row">
              <div class="col-12 col-sm-4"></div>
              <div class="col-12 col-sm-8"><h1 class="entry-title"><?php echo $opcion_nombre_completo; ?></h1></div>
              </div>
              <hr />
            </div>

            <div class="col-12 col-sm-4">
              <div><?php the_post_thumbnail( 'small', $thumb_attrs ); ?></div>
              <br>
	            <h3 class="h6"><?php echo _x('Lista','opcion','pgi-import'); ?></h2>
	            <p><?php echo $nombre_lista; ?></p>

            </div>

            <div class="col-12 col-sm-8">
              <h2><?php echo _x('Biografía','opcion','pgi-import'); ?></h2>
              <p><?php echo $opcion_biografia; ?></p>

              <?php if($opcion_motivacion){ ?>
              <hr />
              <h2><?php echo _x('Motivación','opcion','pgi-import'); ?></h2>
              <p><?php echo $opcion_motivacion; ?></p>
              <?php } ?>
              <?php if($opcion_youtube_embed){ ?>
              <hr />
              <h2><?php echo _x('Vídeo presentación','opcion','pgi-import'); ?></h2>
              <p><?php echo $opcion_youtube_embed; ?></p>
              <?php } ?>

	    </div>
            <div class="col-12">
                <hr />
		<a class="button btn2 back text-center" href="<?php echo _x('/votacion/asamblea-ciudadana/','opcion','pgi-import'); ?>"><?php echo _x('Candidaturas al CCE y a la Secretaría General Estatal','opcion','pgi-import'); ?></a>
		<a class="button btn2 back text-center" href="<?php echo _x('/votacion/comision-garantias/','opcion','pgi-import'); ?>"><?php echo _x('Candidaturas a la Comisión de Garantías Democráticas','opcion','pgi-import'); ?></a>
	    </div>
	  </div>
	</div>

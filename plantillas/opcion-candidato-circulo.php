<?php

$opcion_video = get_post_meta($post->ID, 'opcion_video', true);
$opcion_propuesta = get_post_meta($post->ID, 'opcion_propuestas', true);
$opcion_organo = get_post_meta($post->ID, 'opcion_organo', true);
$opcion_circulo = get_post_meta($post->ID, 'opcion_circulo', true);

// process full name
$opcion_nombre_completo = get_the_title();
if(mb_convert_case($opcion_nombre_completo, MB_CASE_UPPER)==$opcion_nombre_completo || mb_convert_case($opcion_nombre_completo, MB_CASE_LOWER)==$opcion_nombre_completo)
  $opcion_nombre_completo = mb_convert_case($opcion_nombre_completo, MB_CASE_TITLE);

// replace line breaks with p tags
$opcion_biografia = str_replace( "\n", '</p><p>', $opcion_biografia );
$opcion_propuesta = str_replace( "\n", '</p><p>', $opcion_propuesta );

// convert urls to links
$opcion_biografia = linkify($opcion_biografia);
$opcion_propuesta = linkify($opcion_propuesta);

// get youtube embed
if($opcion_video){
  $res = preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $opcion_video, $matches);
  $yt_id = $res ? $matches[1] : '';
  $opcion_youtube_embed = $yt_id ? '<div class="embed-responsive embed-responsive-16by9"><iframe src="https://www.youtube.com/embed/'.$yt_id.'" frameborder="0" allowfullscreen></iframe></div>' : '';
}

// image attributes
$thumb_attrs = [ "title" => $opcion_nombre_completo, "alt" => $opcion_nombre_completo, "class" => "opcion-image" ];
?>
<div class=row>
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-sm-4"></div>
      <div class="col-12 col-sm-8"><h1 class="entry-title"><?php echo $opcion_nombre_completo; ?></h1></div>
    </div>
    <hr />
  </div>
</div>

<div class=row>
  <div class="col-12 col-sm-4">
    <div><?php the_post_thumbnail( 'small', $thumb_attrs ); ?></div>
    <br>
    <h3 class="h6"><?php echo _x('Se presenta a:','opcion','pgi-import'); ?></h2>
    <p><?php echo $opcion_organo; ?></p>
    <h3 class="h6"><?php echo _x('Círculo que avala su candidatura:','opcion','pgi-import'); ?></h2>
    <p><?php echo $opcion_circulo; ?></p>
  </div>

  <div class="col-12 col-sm-8">
    <h2><?php echo _x('Biografía','opcion','pgi-import'); ?></h2>
    <p><?php the_content() ?></p>

    <?php if($opcion_propuesta){ ?>
    <hr />
    <h2><?php echo _x('Propuesta de actuación','opcion','pgi-import'); ?></h2>
    <p><?php echo $opcion_propuesta; ?></p>
    <?php } ?>
    <?php if($opcion_youtube_embed){ ?>
    <hr />
    <h2><?php echo _x('Vídeo presentación','opcion','pgi-import'); ?></h2>
    <p><?php echo $opcion_youtube_embed; ?></p>
    <?php } ?>
  </div>
</div>
<div class="col-12">
  <a class="button btn2 back text-center" href="<?php echo _x( '/votacion/representantes-circulos/', 'opcion', 'pgi-import' );?>"><?php echo _x( 'Candidaturas a representantes de los Círculos en el CCE', 'opcion', 'pgi-import' );?></a>
</div>


<?php

  /**
  * Turn all URLs in clickable links.
  * 
  * @param string $value
  * @param array  $protocols  http/https, ftp, mail, twitter
  * @param array  $attributes
  * @param string $mode       normal or all
  * @return string
  */
  function linkify($value, $protocols = array('http', 'mail', 'twitter'), array $attributes = array())
  {
      // Link attributes
      $attr = '';
      foreach ($attributes as $key => $val) {
	  $attr = ' ' . $key . '="' . htmlentities($val) . '"';
      }
      
      $links = array();
      
      // Extract existing links and tags
      $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);
      
      // Extract text links for each protocol
      foreach ((array)$protocols as $protocol) {
	  switch ($protocol) {
	      case 'http':
	      case 'https':   $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { if ($match[1]) $protocol = $match[1]; $link = $match[2] ?: $match[3]; return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">$protocol://$link</a>") . '>'; }, $value); break;
	      case 'mail':    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
	      case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\">{$match[0]}</a>") . '>'; }, $value); break;
	      default:        $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
	  }
      }
      
      // Insert all link
      return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);
  }



  $have_posts = have_posts();
  if ($have_posts) {
    the_post();
    $opcion_video = get_post_meta($post->ID, 'opcion_video', true);
    $opcion_biografia = get_the_content();
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

  }
  get_header(); ?>

  <div class="wrapper">
    <main role="main">
    <section>
    <?php if ($have_posts): ?>
      <article id="post-<?php the_ID(); ?>">
        <div class="container opcion-template">
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
	      <h3 class="h6"><?php echo _x('Se presenta a:','opcion','pgi-import'); ?></h2>
	      <p><?php echo $opcion_organo; ?></p>
	      <h3 class="h6"><?php echo _x('Círculo que avala su candidatura:','opcion','pgi-import'); ?></h2>
	      <p><?php echo $opcion_circulo; ?></p>
            </div>

            <div class="col-12 col-sm-8">
              <h2><?php echo _x('Biografía','opcion','pgi-import'); ?></h2>
              <p><?php echo $opcion_biografia; ?></p>

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
            <div class="col-12">
		<a class="button btn2 back text-center" href="/votacion/representantes-circulos/">Candidaturas a representantes de los Círculos en el CCE</a>
	    </div>
	  </div>
	</div>
      </div>

      </article>
    <?php else: ?>
      <article>
        <h1><?php _x( 'Nada que mostrar.', 'asamblea-ciudadana-2' ); ?></h1>
      </article>
    <?php endif; ?>
    </section>
    </main>
  </div>
<?php get_footer(); ?>

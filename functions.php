<?php

require get_stylesheet_directory() . '/inc/widgets.php';
require get_stylesheet_directory() . '/inc/pgi_documentos.php';
require get_stylesheet_directory() . '/inc/pgi_aportaciones.php';
require get_stylesheet_directory() . '/inc/pgi_circulos_cce.php';
require get_stylesheet_directory() . '/inc/pgi_candidatos_vistalegre2.php';
require get_stylesheet_directory() . '/inc/pgi_listas_vistalegre2.php';
require get_stylesheet_directory() . '/inc/pgi_candidatos_comision_garantias.php';
require get_stylesheet_directory() . '/inc/pgi_listas_comision_garantias.php';

function my_myme_types( $mime_types ) {
  $mime_types['json'] = 'application/json'; // Adding .json extension
  return $mime_types;
}
add_filter( 'upload_mimes', 'my_myme_types', 1, 1 );

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	$the_theme = wp_get_theme();

    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
}



// Añade nuevos menus
function parent_theme_fixes() {
  register_nav_menus( [ 'top' => 'Links útiles' ]);
}
add_action( 'init' , 'parent_theme_fixes', 0 );

// Selector de estilos en la página
function understrap_styles( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter( 'mce_buttons_2', 'understrap_styles' );
add_editor_style();

// Estilos añadidos para vistalegre2
function vistalegre2_styles( $init_array ) {
	$style_formats = array(
		array(
			'title' => 'Intro',
			'block' => 'div',
			'classes' => 'lead',
			'wrapper' => true,
		),
		array(
			'title' => 'Equipo técnico',
			'block' => 'div',
			'classes' => 'equipo',
			'wrapper' => true,
			'exact' => true,
		),
	);
	$init_array['style_formats'] = json_encode( $style_formats );
	return $init_array;
}
add_filter( 'tiny_mce_before_init', 'vistalegre2_styles' );

// Reordena salida de los posts en la portada para que salga la fecha por encima
function posts_portada( $output, $atts, $image, $title, $date, $excerpt, $inner_wrapper, $content, $class ) {
	$output = '<' . $inner_wrapper . ' class="' . implode( ' ', $class ) . '">' . $image . $date . $title  . $excerpt . $content . '</' . $inner_wrapper . '>';
	return $output;
}
add_filter( 'display_posts_shortcode_output', 'posts_portada', 10, 9 );

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

// generar miniaturas a 150x150
function add_image_size_150() {
  if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'miniatura150', 150, 150, true ); // el último parametro es para recortar
  }
}
add_action('after_setup_theme', 'add_image_size_150');

if(is_admin()){
  add_editor_style('css/child-theme.min.css' );
}

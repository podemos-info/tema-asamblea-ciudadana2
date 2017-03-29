<?php
/**
	 * Partial template for content in directo.php
 *
 * @package understrap
 */

$opcion_nombre = get_post_meta($post->ID, 'opcion_nombre', true);
$opcion_apellidos = get_post_meta($post->ID, 'opcion_apellidos', true);
$opcion_organo = get_post_meta($post->ID, 'opcion_organo', true);

// process full name
$opcion_nombre_completo = "$opcion_nombre $opcion_apellidos";
// EL NOMBRE IGUAL DEBERÍA SER EL TÍTULO PARA QUE ASÍ SEA EL <title> DE LA PÁGINA TAMBIÉN
$opcion_nombre_completo = get_the_title();
if(mb_convert_case($opcion_nombre_completo, MB_CASE_UPPER)==$opcion_nombre_completo || mb_convert_case($opcion_nombre_completo, MB_CASE_LOWER)==$opcion_nombre_completo)
  $opcion_nombre_completo = mb_convert_case($opcion_nombre_completo, MB_CASE_TITLE);
?>
  <div class="col-6 col-sm-4 col-md-3 col-lg-2 text-center">
	<a class="opcion" title="<?php echo $opcion_nombre_completo; ?>" href="<?php the_permalink(); ?>">
		<span class="fotoimg">
			<?php the_post_thumbnail('miniatura150'); ?>
		</span>
		<br />
		<span class="nombre"><?php echo $opcion_nombre_completo; ?></span>
	</a>
  </div>




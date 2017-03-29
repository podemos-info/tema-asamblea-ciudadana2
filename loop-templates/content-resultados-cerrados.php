<?php
/**
 * Partial template for content in page.php
 *
 * @package understrap
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
    <div class="row">
      <div class="col-12">
        <p>Los resultados se publicarán en esta página durante el domingo 12 de febrero.</p> 
      </div>
      <div class="col-12">
      	<h2>Contadores</h2>
      </div>
      <div class="col-12 col-sm-8 text-center">
        <p>Documentos, Consejo Ciudadano Estatal y Secretaría General</p>
        <iframe frameborder="0"="0" src="https://participa.podemos.info/es/votos/79/24955/SSJFMFA+dXtVxD%2F4u" width="100%" height="80"></iframe>
      </div>
      <div class="col-12 col-sm-4 text-center">
        <p>Comisión de Garantías Democráticas</p>
        <iframe frameborder="0"="0" src="https://participa.podemos.info/es/votos/80/24956/hZkSXmm9nkJ+G3lvY" width="100%" height="80"></iframe>
      </div>
    </div>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

<?php get_header(); ?>
  <div class="wrapper">
    <main role="main">
    <section>
  	<?php if (have_posts()): the_post();?>
      <article id="post-<?php the_ID(); ?>">
        <div class="container opcion-template">
          <?php get_template_part('plantillas/opcion', get_post_meta(get_the_ID(), 'opcion_plantilla', true));?>
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
<script> <?php echo _x('jQuery(".menu-item-125").addClass("active");', 'lista', 'pgi-import'); ?> </script>

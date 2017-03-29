<?php

$have_posts = have_posts();
if ($have_posts) {
  $current_ids = pm_get_current_streaming_id();
  if(count($current_ids)){
    $current_id = $current_ids[0];
    $current_title = get_the_title($current_id);
    $ps_video = get_post_meta($current_id, "youtube_url", true);
    // get youtube embed
    if($ps_video){
      $res = preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $ps_video, $matches);
      $yt_id = $res ? $matches[1] : '';
      $youtube_embed = $yt_id ? '<div class="embed-responsive embed-responsive-16by9"><iframe src="https://www.youtube.com/embed/'.$yt_id.'?autoplay=true" frameborder="0" allowfullscreen></iframe></div>' : '';
    }
  }
  else
    $current_title = _x("Ahora mismo no hay emisiones en directo. Te avisaremos cuando las haya.", "podemos-streamings", "podemos-streamings");
}

get_header();
?>

<?php
$container   = get_theme_mod( 'understrap_container_type' );
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
wp_register_script( 'podemos-streamings', plugins_url( 'podemos-streamings/ps.js' ) );
wp_enqueue_script( 'podemos-streamings' );
?>

<div class="wrapper" id="archive-wrapper">
  <div class="ps-content <?php echo esc_html( $container ); ?>" id="content" tabindex="-1">
    <div class="row">

      <div id="primary" class="col-md-8 col-large content-area">
        <div class="row">
          <header class="page-header">
            <h1 class="entry-title"><?php echo _x('Directo','podemos-streamings','podemos-streamings');?></h1>
          </header><!-- .page-header -->
          <?php if ( $have_posts ) : ?>
          <div class="col-md-12 ps-directo-player">
            <?php echo $youtube_embed; ?>
            <p><h2 class="h6" id="ps-player-title"><?php echo $current_title; ?></h2></p>
          </div><!-- col -->
          <div class="col-12"><h2><?php echo _x('Todos los directos','podemos-streamings','podemos-streamings');?></h2></div>
          <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'loop-templates/content-directo' ); ?>
          <?php endwhile; ?>
          <?php else : ?>
            <div class="col-md-12">
              <p><?php echo _x('Aún no hay emisiones en directo. Te avisaremos cuando las haya.','podemos-streamings','podemos-streamings');?></p>
            </div>
          <?php endif; ?>
          <!-- <div class="col-md-12"><?php understrap_pagination(); ?></div> -->
        </div><!-- row -->
        <!-- The pagination component -->
      </div><!-- #primary -->

      <!-- Do the right sidebar check -->
      <?php if ( 'right' === $sidebar_pos || 'both' === $sidebar_pos ) : ?>
        <?php get_sidebar( 'right' ); ?>
      <?php endif; ?>

    </div><!-- row -->

  </div><!-- Container end -->
</div><!-- Wrapper end -->
<?php get_footer(); ?>

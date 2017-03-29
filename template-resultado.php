<?php /* Template Name: Resultados */
/**
 * The template for displaying results.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package understrap
 */

get_header();
$resultados_ocultar = !current_user_can('administrator') && empty(get_post_meta(get_the_ID(), 'resultados_mostrar', true));
$resultados_categorias = get_post_meta(get_the_ID(), 'resultados_categorias', true);

$resultados_pdf = get_post_meta(get_the_ID(), 'resultados_pdf', true);
$resultados_verificables = get_post_meta(get_the_ID(), 'resultados_verificables', true);
$resultados_tratables = get_post_meta(get_the_ID(), 'resultados_tratables', true);

$container   = get_theme_mod( 'understrap_container_type' );
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
?>

<script type="text/javascript" src="/wp-content/themes/asamblea-ciudadana-2/js/d3-tip.js"></script>

<script type="text/javascript">
var resize = function() {
  jQuery(".grafico").each(function() {
  		var container = jQuery(this);
		  var width = container.width();
  		var height = 32;
  		var pos = container.data("votes");
      var data =[];
      var x = d3.scale.linear().range([0, width]);
      var y = d3.scale.linear().range([height, 0]);
  		var svg = d3.select(this).html("").append("svg")
  			.attr("width", "100%")
        .attr("height", height+3)
  		var g = svg.append("g");
      var tip = d3.tip()
        .attr('class', 'd3-tip')
        .offset([-10, 0])
        .html(function(d) {
          return "<strong>"+d.value+" votos en la posición " + d.position + "</strong>";
        });
  		var color_bar = d3.scale.ordinal().range(["#683064", "#6B478E", "#B052A9", "#C4A0D8"]);
  
  		for(var i=0; i < pos.length; i++) {
        data.push({position: i+1, value: pos[i]});                              
      };
      x.domain([0,pos.length]);
      y.domain([0,d3.max(pos)]);
			g.call(tip);
      g.selectAll(".bar")
        .data(data)
        .enter().append("rect")
        .attr("class", "bar")
        .attr("x",function(d){ return x(d.position-1);})                        
        .attr("width", Math.floor(width/(pos.length+2)))
        .attr("y",function(d){ return y(d.value);} )
        .attr("height",function(d){ return height - y(d.value) +3;})
        .style("fill", function(d, i) {
            return color_bar(i%4);
          })                        
        .on('mouseover', tip.show)
        .on('mouseout', tip.hide);
    });
 };
jQuery(window).on("load", resize).on("resize", resize);
</script>
  
<div class="wrapper" id="page-wrapper">

  <div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">
    <?php if ( has_post_thumbnail() ): ?>
    <div class="row post-thumbnail">
      <div class="col-12">
        <?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
      </div>
    </div>
    <?php endif; ?>

    <div class="row">
      <did id="primary" class="col-md-12 content-area">
        <main class="site-main" id="main">
          <?php while ( have_posts() ) : the_post(); ?>
          <?php if ($resultados_ocultar) {
  get_template_part( 'loop-templates/content', 'resultados-cerrados' );
} else {
  get_template_part( 'loop-templates/content', 'page' );

  if (!empty($resultados_categorias)) {
    $partes_votacion = get_terms('votacion', ['include' => explode(",",$resultados_categorias), 'orderby'=>'meta_value_num', 'meta_key'=>'votacion_orden' ]);
          ?>
          <?php foreach($partes_votacion as $parte_votacion) : ?>
          <div class="row">
            <div class="col-12">
              <?php get_template_part( 'loop-templates/content-resultado' ); ?>
            </div>
          </div>
          <?php endforeach; ?>
          <?php
    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
    comments_template();
    endif;
  }
	if (!empty($resultados_pdf)){
  	echo "<a class='button btn1' href='".wp_get_attachment_url( $resultados_pdf )."'>"._x('Ver resultados completos','resultados','pgi-import')."</a>";
  }
	if (!empty($resultados_verificables)){
  	echo "<a class='button btn2' href='$resultados_verificables'>"._x('Resultados verificables','resultados','pgi-import')."</a>";
  }
	if (!empty($resultados_tratables)){
  	echo "<a class='button btn3' href='".$resultados_tratables."'>"._x('Resultados en bruto (formato JSON)','resultados','pgi-import')."</a>";
  }
  
}
          ?>

          <?php endwhile; // end of the loop. ?>

        </main><!-- #main -->
      </div>

    </div><!-- .row -->

  </div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>


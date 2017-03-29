<?php
/**
 * Declaring widgets
 *
 * @package asamblea ciudadana 2
 */

/**
 * Initializes themes widgets.
 */
function asamblea_ciudadana_2_widgets_init() {

	register_sidebar( array(
		'name'		=> __( 'Footer Up Left', 'understrap' ),
		'id'            => 'footerupleft',
		'description'   => 'Widget a la izquierda del footer superior',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => ''
	) );
	register_sidebar( array(
		'name'		=> __( 'Footer Up Right', 'understrap' ),
		'id'            => 'footerupright',
		'description'   => 'Widget a la derecha del footer superior',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => ''
	) );
	unregister_sidebar("footerfull");
	unregister_sidebar("hero");
	unregister_sidebar("statichero");
}

add_action( 'widgets_init', 'asamblea_ciudadana_2_widgets_init' );

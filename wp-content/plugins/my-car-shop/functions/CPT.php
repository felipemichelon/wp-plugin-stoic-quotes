<?php

function cpt_cars() {
	$labels = array(
		'name'                  => _x( 'Cars', 'Post type general name', 'cars' ),
		'singular_name'         => _x( 'Car', 'Post type singular name', 'cars' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'menu_icon'			 => 'dashicons-car',
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'car' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail'),
	);

	register_post_type( 'cars', $args );
}

add_filter( 'post_row_actions', 'remove_row_actions', 10, 2 );
function remove_row_actions( $actions, $post )
{
  global $current_screen;
    if( $current_screen->post_type != 'cars' ) return $actions;
    // unset( $actions['edit'] );
    // unset( $actions['view'] );
    // unset( $actions['trash'] );
    unset( $actions['inline hide-if-no-js'] );
    //$actions['inline hide-if-no-js'] .= __( 'Quick&nbsp;Edit' );

    return $actions;
}
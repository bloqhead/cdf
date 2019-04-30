<?php
/**
 * Custom post types
 *
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 *
 * @package  Big_Sea
 */

add_action( 'init', 'bsd_custom_post_types' );
function bsd_custom_post_types() {

	/** FAQs - NO ARCHIVE */
	register_post_type( 'faq',
		array(
			'labels' => array(
				'name' => __( 'FAQs' ),
				'singular_name' => __( 'FAQ' ),
				'add_new' => __( 'Add FAQ' ),
				'add_new_item' => __( 'Add a FAQ' )
			),
			/** Select an icon: https://developer.wordpress.org/resource/dashicons/ */
			'menu_icon' => 'dashicons-sos',
			'public' => true,
			'has_archive' => false,
			'supports' => array ( 'title', 'editor' ),
			'hierarchical' => true // for proper reordering
		)
	);

	/** Dreams */
	register_post_type( 'dreams',
	array(
		'rewrite' => array(
			'slug' => 'dreams'
		),
		'labels' => array(
			'name' => __( 'Dreams' ),
			'singular_name' => __( 'Dream' ),
			'add_new' => __( 'Add Dream' ),
			'add_new_item' => __( 'Add a Dream' )
		),
		/** Select an icon: https://developer.wordpress.org/resource/dashicons/ */
		'menu_icon' => 'dashicons-smiley',
		'public' => true,
		'has_archive' => true,
		'supports' => array ( 'title', 'editor', 'thumbnail' ),
		'hierarchical' => true // for proper reordering
	)
);

}

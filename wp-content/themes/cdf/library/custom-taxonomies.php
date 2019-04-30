<?php

/**
 * Custom taxonomies
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 *
 * @package Big_Sea
 */

add_action( 'init', 'bsd_custom_taxonomies' );
function bsd_custom_taxonomies() {

	/** Dream types taxonomy */
	register_taxonomy(
		'dream-types', 'dreams',
		array(
			'label' => __( 'Types' ),
			'rewrite' => array( 'slug' => 'dream-types' ),
			'hierarchical' => false,
			'labels' => array(
				'name'                       => _x( 'Dream Types', 'taxonomy general name', 'textdomain' ),
				'singular_name'              => _x( 'Dream Type', 'taxonomy singular name', 'textdomain' ),
				'search_items'               => __( 'Search Dream Types', 'textdomain' ),
				'popular_items'              => __( 'Popular Dream Types', 'textdomain' ),
				'all_items'                  => __( 'All Dream Types', 'textdomain' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Dream Type', 'textdomain' ),
				'update_item'                => __( 'Update Dream Type', 'textdomain' ),
				'add_new_item'               => __( 'Add New Dream Type', 'textdomain' ),
				'new_item_name'              => __( 'New Dream Type Name', 'textdomain' ),
				'separate_items_with_commas' => __( 'Separate Dream Types with commas', 'textdomain' ),
				'add_or_remove_items'        => __( 'Add or remove Dream Types', 'textdomain' ),
				'choose_from_most_used'      => __( 'Choose from the most used types', 'textdomain' ),
				'not_found'                  => __( 'No types found.', 'textdomain' ),
				'menu_name'                  => __( 'Types', 'textdomain' ),
			)
		)
	);

}

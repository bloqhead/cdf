<?php
/**
 * The front page template
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$context = Timber::get_context();
$context['post'] = new TimberPost();

/**
 * Dreams CPT query arguments
 */
$dreams_query_args = array (
  'post_type' => 'dreams',
  'posts_per_page' => 3,
);

/**
 * Events calendar query arguments
 * Reference: https://gist.github.com/jo-snips/5112025
 */
$events_query_args = array (
  'post_status'     => 'publish',
  'post_type'       => array ( TribeEvents::POSTTYPE ),
  'posts_per_page'  => 4,
  'meta_key'        => '_tribe_featured',
  'orderby'         => '_EventStartDate',
  'order'           => 'DESC',
  'eventDisplay'    => 'upcoming'
  // 'eventDisplay'    => 'custom'
);

/** posts */
$context['posts'] = Timber::get_posts();

/** dreams */
$context['dreams'] = Timber::get_posts( $dreams_query_args );

/** events */
$context['events'] = Timber::get_posts( $events_query_args );

/** pagination */
$context['pagination'] = Timber::get_pagination();

$templates = array( 'views/pages/page-home.twig' );
Timber::render( $templates, $context );

<?php
/**
 * The Template for displaying the sidebar
 *
 * @package  WordPress
 * @subpackage  Timber
 */

$context = Timber::get_context();
$context['sidebarContent'] = Timber::get_widgets( 'dynamic_sidebar' );
Timber::render( 'views/partials/sidebar.twig', $context );

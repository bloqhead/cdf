<?php
/**
 * The Template for displaying the blog sidebar
 *
 * @package  WordPress
 * @subpackage  Timber
 */

$context = Timber::get_context();
$context['sidebarContent'] = Timber::get_widgets( 'blog_sidebar' );
Timber::render( 'views/partials/sidebar-blog.twig', $context );

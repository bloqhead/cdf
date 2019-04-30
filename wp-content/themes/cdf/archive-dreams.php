<?php
/**
 * The template for displaying the Dreams archive.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Big_Sea
 */

$context = Timber::get_context();
$templates = array( 'views/archives/archive-dreams.twig', 'views/index.twig' );
$context['title'] = post_type_archive_title( '', false );
$context['pagination'] = Timber::get_pagination();
$context['posts'] = Timber::get_posts();

/* This is required for creating the filters list in `archive-dreams.twig` */
$context['dream_types'] = Timber::get_terms('dream-types');

Timber::render( $templates, $context );

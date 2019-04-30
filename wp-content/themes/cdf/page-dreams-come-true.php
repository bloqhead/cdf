<?php
/**
 * Template Name: How Dreams Come True
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
Timber::render( array( 'views/pages/page-dreams-come-true.twig' ), $context );

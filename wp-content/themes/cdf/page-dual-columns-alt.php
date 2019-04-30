<?php
/**
 * Template Name: Dual Columns - Alt
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
Timber::render( array( 'views/pages/page-dual-columns-alt.twig' ), $context );

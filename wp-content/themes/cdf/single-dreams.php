<?php
/**
 * The Template for displaying all single posts
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;
$context['dynamic_sidebar'] = Timber::get_sidebar( 'sidebar.php' );

/**
 * Alternative method for next and previous links
 * because the default ones don't currently work
 * with Timber.
*/
$next_post = get_previous_post();
if ( is_a( $next_post , 'WP_Post' ) ) {
	$next = get_permalink( $next_post->ID );
	$context['nextpost'] = '<li class="post-nav__link post-nav__link--next"><a href="' . $next . '">' . '<span>Next Dream</span> <i class="fa fa-angle-right"></i>' . '</a></li>';
}

$prev_post = get_next_post();
if ( is_a( $prev_post , 'WP_Post' ) ) {
	$prev = get_permalink( $prev_post->ID );
	$context['prevpost'] = '<li class="post-nav__link post-nav__link--prev"><a href="' . $prev . '">' . '<i class="fa fa-angle-left"></i> <span>Previous Dreams</span>' . '</a>';
}

if ( post_password_required( $post->ID ) ) {
	/** load the password-protected template if needed */
	Timber::render( 'views/singles/single-password.twig', $context );
}
else {
	Timber::render(
		array(
			/** look for an ID-specific template first... */
			'views/singles/single-' . $post->ID . '.twig',
			/** if there isn't one, look for a post type-specific one... */
			'views/singles/single-' . $post->post_type . '.twig',
			/** if none of the above match, fall back to the default template */
			'views/singles/single.twig'
		), $context
	);
}

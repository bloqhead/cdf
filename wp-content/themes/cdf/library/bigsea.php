<?php

/**
 * Big Sea theme setup
 */

add_action( 'after_setup_theme', 'bsd_theme_init_setup' );
function bsd_theme_init_setup() {
	/**
	 * Basic clean up
	 */

	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from RSS
	add_filter( 'the_generator', 'bsd_rss_version' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'bsd_remove_wp_ver_css_js', 9999 );
	// remove WP version from scripts
	add_filter( 'script_loader_src', 'bsd_remove_wp_ver_css_js', 9999 );
	// clean up gallery output
	add_filter( 'gallery_style', 'bsd_gallery_style' );
	// clean up comment styles in the head
	add_action( 'wp_head', 'bsd_remove_recent_comments_style' );

	// TypeKit
	add_action( 'wp_head', 'bsd_typekit' );

	// clean out all of the emoji stuff
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	add_filter( 'tiny_mce_plugins', 'bsd_disable_emojicons_tinymce' );
	// the DNS prefetch is related to emoji, so let's ditch that also
	remove_action( 'wp_head', 'wp_resource_hints', 2 );

	/**
	 * Theme setup
	 */

	// add language support
	load_theme_textdomain( 'big-sea', get_template_directory() . '/languages' );

	// add basic theme support
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats' );
	add_theme_support( 'menus' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );

	// enable HTML5 output
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	));

	/**
	 * Widgets, menus, styles and scripts
	 */

	// enable shortcodes in text widgets
	add_filter( 'widget_text','do_shortcode' );
	// setup widgets
	add_action( 'widgets_init', 'bsd_widgets_init' );
	// setup scripts and styles
	add_action( 'wp_enqueue_scripts', 'bsd_scripts' );

	/**
	 * Setup menus
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary', 'big-sea' ),
		'secondary' => __( 'Secondary', 'big-sea' ),
		'footer' => __( 'Footer', 'big-sea' ),
	));

	/**
	 * Custom image sizes
	 */
	add_image_size( 'big-sea-lrg', 1024, 99999 );
	add_image_size( 'big-sea-med', 768, 99999 );
	add_image_size( 'big-sea-sm', 320, 99999 );
	add_image_size( 'big-sea-masthead', 1810, 731 );
	add_image_size( 'big-sea-dreams-profile', 290, 290, true );
	add_image_size( 'big-sea-dreams-featured', 800, 800, array ( 'center', 'top' ) );
	add_image_size( 'big-sea-dreams-tile', 800, 800, array ( 'center', 'center' ) );
	add_image_size( 'big-sea-dreams-carousel-full', 1148, 720, true );
	add_image_size( 'big-sea-dreams-carousel-thumb', 392, 268, array ( 'center', 'top' ) );
	add_image_size( 'big-sea-post-featured', 1858, 1118, array ( 'center', 'top' ) );
	add_image_size( 'big-sea-event-featured', 746, 554, true );


	/**
	 * Let's make sure we can properly use `file_get_contents`
	 */
	ini_set( 'allow_url_fopen', 1 );
}

/**
 * Cleanup
 */

// remove WP version from RSS
function bsd_rss_version() {
	return '';
}

// remove WP version from scripts
function bsd_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS from recent comments widget
function bsd_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

// remove injected CSS from gallery
function bsd_gallery_style( $css ) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

// disable emojis in TinyMCE
function bsd_disable_emojicons_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	}
	else {
		return array();
	}
}

/**
 * Theme setup
 */

function bsd_scripts() {
	// styles
	wp_enqueue_style( 'big-sea-style', get_template_directory_uri() . '/style.css' );
	// wp_enqueue_style( 'big-sea-style-min', get_template_directory_uri() . '/style.min.css' );

	// scripts
	wp_enqueue_script( 'big-sea-js', get_template_directory_uri() . '/assets/js/build.js', array( 'jquery' ), '', true );
	// wp_enqueue_script( 'big-sea-js-min', get_template_directory_uri() . '/assets/js/build.min.js', array( 'jquery' ), '', true );

	// font awesome
	wp_enqueue_script( 'big-sea-fa', 'https://use.fontawesome.com/01825bcaac.js', array(), '', true );

	// comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

// setup widgets
function bsd_widgets_init() {

	// main sidebar
	register_sidebar( array(
		'name' 					=> esc_html__( 'Main Sidebar', 'big-sea' ),
		'id' 						=> 'dynamic_sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'big-sea' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	// blog sidebar
	register_sidebar( array(
		'name' 					=> esc_html__( 'Blog Sidebar', 'big-sea' ),
		'id' 						=> 'blog_sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'big-sea' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
}

// TypeKit
function bsd_typekit() { ?>
	<!-- TypeKit -->
	<script src="https://use.typekit.net/oct5yqh.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>
<?php }

/**
 * BrowserSync
 */
// add_action( 'wp_head', 'bsd_browser_sync' );
function bsd_browser_sync() { ?>
	<script id="__bs_script__">//<![CDATA[
	    document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.18.8'><\/script>".replace("HOST", location.hostname));
	//]]></script>
<?php }

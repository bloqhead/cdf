<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Big_Sea
 */

/**
 * Less shitty way of outputting theme-relative paths
 *
 * @param  mixed $string
 * @access public
 * @return void
 */
function get_theme_path($string) {
  return get_stylesheet_directory_uri() . $string;
}
function theme_path($string)
{
	echo get_theme_path($string);
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
add_filter( 'body_class', 'bsd_body_classes' );
function bsd_body_classes( $classes ) {
	// Add class to all internal pages
	if ( !is_home() && !is_front_page() ) {
		$classes[] = 'internal-page';
	}

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// add a class if there is a sidebar present.
	if( is_active_sidebar( 'dynamic_sidebar' ) ) {
		$classes[] = "has-sidebar";
	}

	return $classes;
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
add_action( 'wp_head', 'bsd_pingback_header' );
function bsd_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}

/**
 * Make the ACF options accessible globally
 */
add_filter( 'timber_context', 'timber_acf_options_context'  );
function timber_acf_options_context( $context ) {
	$context['options'] = get_fields('option');
	return $context;
}

/**
 * Favicons and app icons
 */
add_action( 'wp_head', 'bsd_icons' );
function bsd_icons() {
	$iconPath = get_theme_path("/assets/images/favicons");
	$msColor = "#003988";
	?>
	<!-- Apple touch icons -->
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $iconPath ?>/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $iconPath ?>/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $iconPath ?>/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $iconPath ?>/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $iconPath ?>/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $iconPath ?>/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $iconPath ?>/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $iconPath ?>/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $iconPath ?>/apple-icon-180x180.png">
	<!-- Favicons -->
	<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $iconPath ?>/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $iconPath ?>/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $iconPath ?>/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $iconPath ?>/favicon-16x16.png">
	<!-- MS application icon and theme color -->
	<meta name="msapplication-TileColor" content="<?php echo $msColor ?>">
	<meta name="msapplication-TileImage" content="<?php echo $iconPath ?>/ms-icon-144x144.png">
	<meta name="theme-color" content="<?php echo $msColor ?>">
<?php }

/**
 * FAQs
 *
 * @author Daryn St. Pierre <daryn@bigseadesign.com>
 */

function bsd_faq() {
	ob_start();

	/** setup the FAQ query */
	global $wp_query;
	$args = array(
		'post_type' 	=> 'faq',
		'showposts' 	=> -1,
		'orderby' 		=> 'menu_order',
		'order' 		=> 'ASC'
	);
	$post_query = new WP_Query( $args );
	?>

	<?php if( $post_query->have_posts() ) : ?>
	<div class="faq">
	<?php while ( $post_query->have_posts() ) : $post_query->the_post(); ?>
		<div class="faq__item" id="faq-item-<?php the_ID(); ?>">
			<header class="faq__header">
				<h2 class="faq__item-title"><?php the_title(); ?></h2>
			</header>
			<div class="faq__content">
				<?php the_content(); ?>
			</div>
		</div>
	<?php endwhile; wp_reset_query(); ?>
    	</div> <!-- .faq -->
	<?php endif; ?>

	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode( 'faq','bsd_faq' );

/**
 * Checks to see if the content is truly empty
 * Source: http://blog.room34.com/archives/5360
 */
function empty_content($str) {
	return trim( str_replace( '&nbsp;','', strip_tags($str) ) ) == '';
}

/**
 * Social icons
 */
function bsd_social_buttons() {
	$path = get_stylesheet_directory();
	$facebook = "http://www.facebook.com/pages/The-Childrens-Dream-Fund/353384478777";
	$twitter = "https://twitter.com/ChildDreamFund";
	$instagram = "https://www.instagram.com/childrensdreamfund/";
	ob_start();
	?>

	<ul class="social-buttons social-buttons--inline">
		<li class="social-buttons__facebook">
			<a href="<?php echo $facebook ?>" rel="external" target="_blank">
				<?php echo file_get_contents($path . "/assets/images/social/facebook.svg"); ?>
				<span class="sr-only">Keep up to date with us on Facebook</span>
			</a>
		</li>
		<li class="social-buttons__twitter">
			<a href="<?php echo $twitter ?>" rel="external" target="_blank">
				<?php echo file_get_contents($path . "/assets/images/social/twitter.svg"); ?>
				<span class="sr-only">Follow us on Twitter</span>
			</a>
		</li>
		<li class="social-buttons__instagram">
			<a href="<?php echo $instagram ?>" rel="external" target="_blank">
				<?php echo file_get_contents($path . "/assets/images/social/instagram.svg"); ?>
				<span class="sr-only">See our videos and photos on Instagram</span>
			</a>
		</li>
	</ul> <!-- .social-buttons -->

	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode( 'social-buttons','bsd_social_buttons' );

/**
 * eTapestry form embeds
 */
function bigsea_etapestry_form( $atts, $content = NULL ) {

	/** shortcode attributes */
	extract( shortcode_atts( array(
		'provider' => NULL
	), $atts ));

	ob_start();
	?>

<?php if( $provider === 'etapestry' ) : ?>

	<!-- [start] eTapestry donation form -->
	<script type="text/JavaScript" src="//app.etapestry.com/hosted/eTapestry.com/etapEmbedResponsiveResizing.js"></script>
	<iframe id="etapIframe" style="border:none;width:100%;" src="https://app.etapestry.com/onlineforms/SuncoastChildrensDreamFund/OnlineDonation.html"></iframe>
	<!-- [end] eTapestry donation form -->

<?php elseif( $provider === 'paypal' ) : ?>

	<!-- [start] PayPal donation form -->
	<form method="post" action="https://www.paypal.com/cgi-bin/webscr">
		<input type="hidden" value="N9UPY3VETGF2S" name="business">
		<input type="hidden" value="_donations" name="cmd">
		<input type="hidden" value="Children's Dream Fund Donation" name="item_name">
		<input type="hidden" value="DONATION" name="item_number">
		<input type="hidden" value="USD" name="currency_code">
		<input type="hidden" value="http://childrensdreamfund.aosoft.com/index.php/get-involved/donate/" name="return">
		<button class="btn btn--large btn--paypal" name="submit" type="submit">
			<i class="fa fa-paypal" aria-hidden="true"></i> <span>Donate via PayPal</span>
		</button>
	</form>
	<!-- [end] PayPal donation form -->

<?php else : ?>

	<p>
		<strong>You must specify a donation form provider. The options are &quot;paypal&quot; or &quot;etapestry&quot;</strong>
	</p>

<?php endif; ?>

	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode( 'donation-form','bigsea_etapestry_form' );

/**
 * Horizontal rule shortcode
 */
function bsd_horizontal_rule() {
	ob_start(); ?>

	<hr class="rule">

	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode( 'rule','bsd_horizontal_rule' );

/**
* Skip Pages on Multi-Page Form
*
* This is stricly for developer purposes.
*/
add_filter('gform_pre_render', 'bsd_gform_skip_page');
function bsd_gform_skip_page($form) {
	if( !rgpost("is_submit_{$form['id']}") && rgget('form_page') && is_user_logged_in() ) {
		GFFormDisplay::$submission[$form['id']]["page_number"] = rgget('form_page');
	}
	return $form;
}

/**
 * Output the posts page title from settings
 */
function post_page_title() {
	$title = get_the_title( get_option('page_for_posts', true) );
	return $title;
}

/**
 * Output the posts page URL
 */
 function post_page_url() {
	$url = get_permalink( get_option( 'page_for_posts' ) );
	return $url;
}

/**
 * Modify the Dreams archive prior to querying
 *
 * This forces the Dreams post archive to display
 * all posts without.
 */
add_action( 'pre_get_posts', 'filter_dreams_args' );
function filter_dreams_args( $query ) {
	if( ! is_admin() && $query->is_main_query() ) {
		if( is_post_type_archive( 'dreams' ) ) {
			$query->set( 'posts_per_page', -1 );
		}
	}
}

/**
 * Get the page title outside of the loop
 */
function loopless_page_title() {
	global $post;
	return get_the_title($post->ID);
}

/**
 * Featured event
 *
 * This is pulled and setup from the post selected
 * on the ACF options page.
 */
function homepage_featured_event() {
	$post_id = get_field( 'options_featured_event', 'option' );
	$event = get_post( $post_id );
	$image = tribe_event_featured_image( $event->ID, 'big-sea-event-featured', true );
	$date_template = "Y/m/d H:i:s";
	$start_date = date_format( $event->_EventStartDate, $date_template );
	$end_date = date_format( $event->_EventEndDate, $date_template );

	/** another check just to ensure nothing displays */
	if( $event->ID != null || $event->ID != "" ) : ?>

		<article class="homepage-events__featured">
			<header class="homepage-events__header">
				<h3><?php echo $event->post_title ?></h3>
				<p class="post-meta">
					<span class="post-meta__start-date"><?php echo $start_date ?></span>
				<?php if( $end_date ) : ?>
					- <span class="post-meta__end-date"><?php echo $end_date ?></span>
				<?php endif; ?>
				</p>
			</header>
			<div class="homepage-events__content">
			<?php if( $image ) : ?>
				<div class="homepage-events__featured-image">
					<?php echo $image ?>
				</div>
			<?php endif; ?>
				<div class="homepage-events__excerpt">
					<p><?php echo wp_trim_words( $event->post_content, 36, ' ...' ) ?></p>
					<p><a href="<?php echo get_permalink( $event->ID ) ?>" class="btn btn--inverse">View Event</a></p>
				</div>
			</div>
		</article>

	<?php endif; ?>

<?php }

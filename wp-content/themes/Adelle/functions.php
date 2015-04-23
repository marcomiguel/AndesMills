<?php

// ==================================================================
// Theme stylesheets
// ==================================================================
function adelle_theme_styles() { 

  wp_enqueue_script('jquery');

  wp_enqueue_script('jquery-ui-widget');

  wp_enqueue_style( 'adelle-style', get_template_directory_uri() . '/style.css', date('l jS \of F Y h:i:s A'), array(), 'all' );

  wp_enqueue_style( 'adelle-stylesheet', get_template_directory_uri() . '/stylesheet.css', date('l jS \of F Y h:i:s A'), array(), 'all' );

  wp_enqueue_style( 'adelle-google-webfont', 'http://fonts.googleapis.com/css?family=Lora:400,400italic|Muli:400,400italic|Montserrat', '', 'all' );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );

}
add_action('wp_enqueue_scripts', 'adelle_theme_styles');

// ==================================================================
// Theme scripts
// ==================================================================
function adelle_theme_scripts(){

  wp_enqueue_script( 'adelle-respond', get_template_directory_uri() . '/js/respond.min.js', array( 'jquery' ), '1.0.1', true );

  wp_enqueue_script( 'adelle-fitvids', get_template_directory_uri() . '/js/fitvids.min.js', array( 'jquery' ), '1.0', true );

  wp_enqueue_script( 'adelle-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), null, true );

}
add_action('wp_footer', 'adelle_theme_scripts');


// ==================================================================
// Custom header
// ==================================================================
if( function_exists('get_custom_header') ) {

  add_theme_support( 'custom-header', array(
	'default-image'          => '',
	'random-default'         => false,
	'width'                  => 400,
	'height'                 => 100,
	'flex-height'            => true,
	'flex-width'             => true,
	'default-text-color'     => '',
	'header-text'            => false,
	'uploads'                => true,
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
  ));

}

// ==================================================================
// Heading
// ==================================================================
function adelle_theme_heading() {

  if( get_header_image() == true ) { ?>
    <a href="<?php echo esc_url( home_url() ); ?>">
      <img src="<?php header_image(); ?>" class="header-title" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" />
    </a>
  <?php } elseif( is_home() || is_front_page() ) { ?>
      <h1><a href="<?php echo esc_url( home_url() ); ?>" class="header-title"><?php bloginfo('name'); ?></a></h1>
      <p class="header-desc"><?php bloginfo('description'); ?></p>
  <?php } else { ?>
      <h5><a href="<?php echo esc_url( home_url() ); ?>" class="header-title"><?php bloginfo('name'); ?></a></h5>
      <p class="header-desc"><?php bloginfo('description'); ?></p>
  <?php }

}

// ==================================================================
// Content width
// ==================================================================
if ( ! isset( $content_width ) ) $content_width = 640;








// ==================================================================
// Innit
// ==================================================================
function adelle_setup() {

// ==================================================================
// Language
// ==================================================================
load_theme_textdomain('adelle-theme', get_template_directory() . '/languages');

// ==================================================================
// Add default posts and comments RSS feed links to head
// ==================================================================
add_theme_support( 'automatic-feed-links' );

// ==================================================================
// Post thumbnail
// ==================================================================
add_theme_support('post-thumbnails');

if ( function_exists( 'add_image_size' ) ) {
  add_image_size( 'post_thumb', 300, 200, true );
}

// ==================================================================
// Menu location
// ==================================================================
register_nav_menu( 'top_menu', __('Top Menu','adelle-theme') );

// ==================================================================
// Custom background
// ==================================================================
if( function_exists('get_custom_header') ) {
  add_theme_support( 'custom-background', array('default-color' => 'ffffff',) );
}

// ==================================================================
// Visual editor stylesheet
// ==================================================================
add_editor_style('editor.css');

// ==================================================================
// Shortcode in excerpt
// ==================================================================
add_filter('the_excerpt', 'do_shortcode');

// ==================================================================
// Shortcode in widget
// ==================================================================
add_filter('widget_text', 'do_shortcode');

// ==================================================================
// Clickable link in content
// ==================================================================
add_filter('the_content', 'make_clickable');

// ==================================================================
// Add "Home" in menu
// ==================================================================
function adelle_theme_home_page_menu( $args ) {
  $args['show_home'] = true;
  return $args;
}
add_filter( 'wp_page_menu_args', 'adelle_theme_home_page_menu' );

// ==================================================================
// Innit
// ==================================================================
}
add_action( 'after_setup_theme', 'adelle_setup' );

// ==================================================================
// Comment spam, prevention
// ==================================================================
function adelle_theme_check_referrer() {
  if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == "") {
    wp_die( __('Please enable referrers in your browser.','adelle-theme') );
  }
}
add_action('check_comment_flood', 'adelle_theme_check_referrer');

// ==================================================================
// Comment time
// ==================================================================
function adelle_theme_time_ago( $type = 'comment' ) {
  $d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';
  return human_time_diff($d('U'), current_time('timestamp')) . " " . __('ago','adelle-theme');
}

// ==================================================================
// Custom comment style
// ==================================================================
function adelle_theme_comment_style($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?>>
  <article class="comment-content" id="comment-<?php comment_ID(); ?>">
    <div class="comment-meta">
    <?php echo get_avatar($comment, $size = '32'); ?>
    <?php printf(__('<h6>%s</h6>','adelle-theme'), get_comment_author_link()) ?>
    <small><?php printf( __('%1$s at %2$s','adelle-theme'), get_comment_date(), get_comment_time()) ?> (<?php printf( __('%s','adelle-theme'), adelle_theme_time_ago() ) ?>)</small>
    </div>
  <?php if ($comment->comment_approved == '0') : ?><em><?php _e('Your comment is awaiting moderation.','adelle-theme') ?></em><br /><?php endif; ?>
  <?php comment_text() ?>
  <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
  </article>
<?php }

// ==================================================================
// Header title
// ==================================================================
function adelle_theme_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'adelle' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'adelle_theme_wp_title', 10, 2 );

// ==================================================================
// Add internal lightbox
// ==================================================================
function ace_add_themescript(){

  if( !is_admin() ){
    wp_enqueue_script('jquery');
    wp_enqueue_script('thickbox',null,array('jquery'));
  }

}

function ace_wp_thickbox_script() {

  ?>
  <script type="text/javascript">
  if ( typeof tb_pathToImage != 'string' )
    {
      var tb_pathToImage = "<?php echo home_url().'/wp-includes/js/thickbox'; ?>/loadingAnimation.gif";
    }
  if ( typeof tb_closeImage != 'string' )
    {
      var tb_closeImage = "<?php echo home_url().'/wp-includes/js/thickbox'; ?>/tb-close.png";
    }
  </script>
  <?php
  wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');

}
add_action('init','ace_add_themescript');
add_action('wp_head', 'ace_wp_thickbox_script');

// ==================================================================
// Add colorbox
// ==================================================================
define( "IMAGE_FILETYPE", "(bmp|gif|jpeg|jpg|png)", true );

function ace_colorbox_replace($string) {

  $pattern = '/(<a(.*?)href="([^"]*.)'.IMAGE_FILETYPE.'"(.*?)><img)/ie';
  $replacement = 'stripslashes(strstr("\2\5","rel=\class=") ? "\1" : "<a\2href=\"\3\4\"\5 rel=\"colorbox\" class=\"colorbox\"><img")';
  return preg_replace($pattern, $replacement, $string);

}
add_filter('the_content', 'ace_colorbox_replace');

function ace_add_colorbox_rel( $attachment_link ) {
  $attachment_link = str_replace( 'a href' , 'a rel="colorbox-cats" class="colorbox-cats" href' , $attachment_link );
  return $attachment_link;
}
add_filter('wp_get_attachment_link' , 'ace_add_colorbox_rel');


function ace_colorbox_script(){
  wp_register_script('colorbox', get_template_directory_uri() . '/js/colorbox/jquery.colorbox-min.js');
  wp_enqueue_script('colorbox');
}
add_action('wp_footer', 'ace_colorbox_script');


function ace_colorbox_css(){
  wp_register_style('colorbox', get_template_directory_uri() . '/js/colorbox/colorbox.css');
  wp_enqueue_style('colorbox');
}
add_action('wp_head', 'ace_colorbox_css');

function ace_colorbox_javascript() {
  ?>
  <script type="text/javascript">
  /* <![CDATA[ */
  jQuery(document).ready(function($){ // START
    $(".colorbox-cats").colorbox({rel:"colorbox-cats", maxWidth:"100%", maxHeight:"100%"});
    $(".colorbox").colorbox({rel:"colorbox", maxWidth:"100%", maxHeight:"100%"});
    $(".colorbox-video").colorbox({iframe:true, innerWidth:"80%", innerHeight:"80%"});
    $(".colorbox-iframe").colorbox({iframe:true, width:"80%", height:"80%"});
  }); // END
  /* ]]> */
  </script>
  <?php
}
add_action('wp_head', 'ace_colorbox_javascript');

// ==================================================================
// Post/page pagination
// ==================================================================
function adelle_theme_get_link_pages() {

  wp_link_pages(
    array(
    'before'           => '<p class="page-pagination"><span class="page-pagination-title">' . __('Pages:','adelle-theme') . '</span>',
    'after'            => '</p>',
    'link_before'      => '<span class="page-pagination-number">',
    'link_after'       => '</span>',
    'next_or_number'   => 'number',
    'nextpagelink'     => __('Next page','adelle-theme'),
    'previouspagelink' => __('Previous page','adelle-theme'),
    'pagelink'         => '%',
    'echo'             => 1
    )
  );

}

// ==================================================================
// Pagination (WordPress)
// ==================================================================
function adelle_theme_pagination_links() {
  global $wp_query;
  $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
  $big = 999999999;
  return paginate_links( array(
    'base' => @add_query_arg('paged','%#%'),
    'format' => '?paged=%#%',
    'current' => $current,
    'total' => $wp_query->max_num_pages,
    'prev_next'    => true,
    'prev_text'    => __('Previous','adelle-theme'),
    'next_text'    => __('Next','adelle-theme'),
  ) );
}

// ==================================================================
// NextGen conflict
// ==================================================================
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if (is_plugin_active('nextgen-gallery/nggallery.php')) {

  remove_action( 'admin_print_scripts', 'add_quicktag' );

}

// ==================================================================
// Widget - Sidebar
// ==================================================================
function adelle_widgets_init() {
  register_sidebar(array(
    'name' => __('Right Widget 1','adelle-theme'),
    'id' => 'right-widget',
    'description' => 'Right side widget area',
    'before_widget' => '<article id="%1$s" class="side-widget %2$s">',
    'after_widget' => '</article>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
}


add_action( 'widgets_init', 'adelle_widgets_init' );
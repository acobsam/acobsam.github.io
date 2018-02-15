<?php
require_once get_template_directory() . '/framework/Custom-Metaboxes/metabox-functions.php';
require_once get_template_directory() . '/framework/Custom-Metaboxes/init.php';
require_once get_template_directory() . '/framework/BFI_Thumb.php';
require_once get_template_directory() . '/framework/theme-configs.php';
require_once get_template_directory() . '/framework/widget/featured.php';
require_once get_template_directory() . '/framework/wp_bootstrap_navwalker.php';
if(function_exists('vc_add_param')){
require_once get_template_directory() . '/vc_functions.php';
}

if ( ! isset( $content_width ) )
	$content_width = 604;
add_filter('show_admin_bar', '__return_true');
function myhouse_setup() {
	/*
	 * Makes myhouse available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on myhouse, use a find and
	 * replace to change 'myhouse' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'myhouse', get_template_directory() . '/languages' );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-header');
	add_theme_support( 'custom-background');

	/*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		 'video'
	) );

	add_theme_support( 'woocommerce' );

	// This theme uses wp_nav_menu() in one location.
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary'   => esc_html__( 'Subpage Menu', 'myhouse' ),
        'one_page'   => esc_html__( 'One Page Menu', 'myhouse' ),
	) );
	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'myhouse_setup' );

function myhouse_scripts_styles() {
    global $myhouse_options;
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Adds Masonry to handle vertical alignment of footer widgets.
	if ( is_active_sidebar( 'sidebar-1' ) )
		wp_enqueue_script( 'jquery-masonry' );

	//Fonts
	$protocol = is_ssl() ? 'https' : 'http';

	wp_enqueue_script("myhouse-bootstrap", get_template_directory_uri()."/assets/js/bootstrap.min.js",array(),false,true);
	wp_enqueue_script("myhouse-plugins", get_template_directory_uri()."/assets/js/plugins.js",array(),false,true);
	//wp_enqueue_script("myhouse-map", get_template_directory_uri()."/assets/js/map.js",array(),false,true);
	wp_enqueue_script("myhouse-main", get_template_directory_uri()."/assets/js/main.js",array(),false,true);

	// Add Source Sans Pro and Bitter fonts, used in the main stylesheet.
    if( $myhouse_options['body_style'] ){
        wp_enqueue_style( 'myhouse-theme', get_template_directory_uri()."/assets/css/master-v{$myhouse_options['body_style']}.css");
    }else{
        wp_enqueue_style( 'myhouse-theme', get_template_directory_uri().'/assets/css/master.css');
    }
	// Loads our main stylesheet.
	wp_enqueue_style( 'myhouse-style', get_stylesheet_uri(), array(), '2015-07-15' );
}
add_action( 'wp_enqueue_scripts', 'myhouse_scripts_styles' );

function myhouse_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Main Widget Area', 'myhouse' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Appears in main sidebar of the site.', 'myhouse' ),
		'before_widget' => '<aside id="%1$s" class="widget  hoverUl %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="heading">
			<h5>',
		'after_title'   => '<div class="line">
				<span></span>
			</div>
		</div>',
	) );
}
add_action( 'widgets_init', 'myhouse_widgets_init' );

//pagination
function myhouse_pagination($prev = 'Prev', $next = 'Next', $pages='') {
    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    if($pages==''){
        global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
    }
    $pagination = array(
		'base' 			=> str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
		'format' 		=> '',
		'current' 		=> max( 1, get_query_var('paged') ),
		'total' 		=> $pages,
		'prev_text' => $prev,
        'next_text' => $next,
		'type'			=> 'list',
		'end_size'		=> 3,
		'mid_size'		=> 3
);
    $return =  paginate_links( $pagination );
	echo str_replace( "<ul class='page-numbers'>", '<ul class="pagination-list padd-left">', esc_url($return) );
}

// get image src
function myhouse_get_img($img, $w, $h, $alt=null){
  if( empty( $img )){
    $img = 'http://dummyimage.com/'. $w .'x'. $h .'/F1F1F1/ddb8b8&text='. $alt;
  }else{
    $img = wp_get_attachment_url($img);
    if( function_exists('bfi_thumb') ){
      $img = bfi_thumb( $img, array('width'=> $w, 'height'=>$h) );
    }
  }
  return $img;
}

// number views
function myhouse_get_views($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return '0';
    }
    return $count.'';
}

// function to count views.
function myhouse_set_views() {
  if(is_single()){
    global $post;
    $postID = $post->ID;
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
  }
}
add_action('wp_head', 'myhouse_set_views' );

function myhouse_add_editor_styles() {
    //for custom editor style set
	//add_editor_style( 'custom-editor-style.css' ); custom editor css
}
add_action( 'admin_init', 'myhouse_add_editor_styles' );

//Custom comment List:
function myhouse_theme_comment($comment, $args, $depth) {
     $GLOBALS['comment'] = $comment; ?>
	 <li <?php comment_class('clearfix'); ?> id="comment-<?php comment_ID() ?>">
		<div class="comment depth-1">
			<div class="left-section">
				<?php echo get_avatar($comment,$size='75', $default= esc_url('http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=75') ); ?>
			</div>

			<div class="right-section">
				<h1>
					<?php echo get_comment_author_link(); ?> <?php esc_html_e('says', 'myhouse'); ?>
				</h1>

                <p class="time-comment">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/blog/clock.png" alt="clock img">
					<?php echo esc_attr(get_comment_date()) . esc_html_e(' at ','myhouse'). esc_attr(get_comment_time()); ?>
                </p>

                <div class="comment-text">
					<?php comment_text() ?>
					<?php if ($comment->comment_approved == '0') : ?>
						 <em><?php esc_html_e('Your comment is awaiting moderation.','myhouse') ?></em>
						 <br />
					 <?php endif; ?>
					 <?php esc_url(comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'])))); ?>
				</div>
			</div>
		</div>
    </li>
<?php }

function myhouse_excerpt($limit = 30) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
    	array_pop($excerpt);
    	$excerpt = implode(" ",$excerpt).'...';
  	} else {
    	$excerpt = implode(" ",$excerpt);
  	}
  	$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  	return $excerpt;
}

function myhouse_thumbnail_url($size) {
    global $post;
    if($size==''){
        $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
         return $url;
    }else{
        $url = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $size);
         return $url[0];
    }
}

if(function_exists('vc_add_param')) {
	vc_add_param('vc_row',array(
				  "type" => "textfield",
				  "heading" => esc_html__('Section ID', 'myhouse'),
				  "param_name" => "el_id",
				  "value" => "",
				  "description" => esc_html__("Set ID section", 'myhouse'),
    ));
}

/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.4.0
 * @author     Thomas Griffin <thomasgriffinmedia.com>
 * @author     Gary Jones <gamajo.com>
 * @copyright  Copyright (c) 2014, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */
/**
 * Include the TGM_Plugin_Activation class.
 */
require_once esc_url(get_template_directory()) . '/framework/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'myhouse_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function myhouse_register_required_plugins() {
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
             // This is an example of how to include a plugin from a private repo in your theme.

		array(
            'name'               => esc_html__('WPBakery Visual Composer', 'myhouse'), // The plugin name.
            'slug'               => 'js_composer', // The plugin slug (typically the folder name).
            'source'             => get_template_directory_uri().'/framework/plugins/js_composer.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ),
		array(
            'name'               => esc_html__('Revolution Slider', 'myhouse'), // The plugin name.
            'slug'               => 'revslider', // The plugin slug (typically the folder name).
            'source'             => esc_url('http://demo.newskythemes.com/plugins/revslider.zip'), // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ),
		array(
            'name'               => esc_html__('NK Register Post Type', 'myhouse'), // The plugin name.
            'slug'               => 'nk-post_type', // The plugin slug (typically the folder name).
            'source'             => esc_url(get_template_directory_uri().'/framework/plugins/nk-post_type.zip'), // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ),
        // This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
            'name'      => esc_html__('Contact Form 7', 'myhouse'),
            'slug'      => 'contact-form-7',
            'required'  => true,
        ),
        array(
            'name'      => esc_html__('Redux Framework', 'myhouse'),
            'slug'      => 'redux-framework',
            'required'  => true,
        ),
		array(
            'name'      => esc_html__('Widget Importer & Exporter', 'myhouse'),
            'slug'      => 'widget-importer-exporter',
            'required'  => false,
        ),


    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.

    );
    tgmpa( $plugins, $config );
}

/* Custom Functions */

// add slug or page name as class on body
add_filter('body_class', 'my_body_class');
function my_body_class($classes) {
    if (is_page()) {
        $classes[] = sanitize_title_with_dashes(get_the_title());
    }
    return $classes;
}

?>

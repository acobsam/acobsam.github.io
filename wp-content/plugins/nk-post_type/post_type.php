<?php 
/**
 * Plugin Name: NK Register Post Type
 * Description: This plugin register all post type come with theme.
 * Version: 1.0
 * Author: Newskythemes
 * Author URI: http://newskythemes.com
 */
?>
<?php

//Gallery

add_action( 'init', 'codex_gallery_init' );
/**
 * Register a Gallery post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_gallery_init() {
	
	
	$labels = array(
		'name'               => __( 'Gallerys', 'post type general name', 'vibermusic' ),
		'singular_name'      => __( 'Gallery', 'post type singular name', 'vibermusic' ),
		'menu_name'          => __( 'Gallerys', 'admin menu', 'vibermusic' ),
		'name_admin_bar'     => __( 'Gallery', 'add new on admin bar', 'vibermusic' ),
		'add_new'            => __( 'Add New', 'Gallery', 'vibermusic' ),
		'add_new_item'       => __( 'Add New Gallery', 'vibermusic' ),
		'new_item'           => __( 'New Gallery', 'vibermusic' ),
		'edit_item'          => __( 'Edit Gallery', 'vibermusic' ),
		'view_item'          => __( 'View Gallery', 'vibermusic' ),
		'all_items'          => __( 'All Gallerys', 'vibermusic' ),
		'search_items'       => __( 'Search Gallerys', 'vibermusic' ),
		'parent_item_colon'  => __( 'Parent Gallerys:', 'vibermusic' ),
		'not_found'          => __( 'No Gallerys found.', 'vibermusic' ),
		'not_found_in_trash' => __( 'No Gallerys found in Trash.', 'vibermusic' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'menu_icon' 		 => 'dashicons-media-audio',
		'publicly_queryable' => true,
		'menu_position' 	 => 2,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'gallery' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'thumbnail')
	);

	register_post_type( 'gallery', $args );
}

// create two taxonomies, genres and writers for the post type "book"
function create_gallery_taxonomies() {
  
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name'              => __( 'Gallery Types', '' ),
    'singular_name'     => __( 'Gallery Type', '' ),
    'search_items'      => __( 'Search Gallery Types','' ),
    'all_items'         => __( 'All Gallery Typees','' ),
    'parent_item'       => __( 'Parent Gallery Type','' ),
    'parent_item_colon' => __( 'Parent Gallery Type:','' ),
    'edit_item'         => __( 'Edit Gallery Type','' ),
    'update_item'       => __( 'Update Gallery Type','' ),
    'add_new_item'      => __( 'Add New Gallery Type','' ),
    'new_item_name'     => __( 'New Gallery Type Name','' ),
    'menu_name'         => __( 'Gallery Type' ,''),
  );

  $args = array(
    'hierarchical'      => true,//tag->false, tag false
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'gallery-type' ),
  );

  register_taxonomy( 'gallery_type', array( 'gallery' ), $args );
}
add_action( 'init', 'create_gallery_taxonomies' );


//Testimonials

add_action( 'init', 'codex_testimonial_init' );
/**
 * Register a Testimonials post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_testimonial_init() {
	
	
	$labels = array(
		'name'               => __( 'Testimonials', 'post type general name', 'teachmusic' ),
		'singular_name'      => __( 'Testimonial', 'post type singular name', 'teachmusic' ),
		'menu_name'          => __( 'Testimonials', 'admin menu', 'teachmusic' ),
		'name_admin_bar'     => __( 'Testimonial', 'add new on admin bar', 'teachmusic' ),
		'add_new'            => __( 'Add New', 'Testimonial', 'teachmusic' ),
		'add_new_item'       => __( 'Add New Testimonial', 'teachmusic' ),
		'new_item'           => __( 'New Testimonial', 'teachmusic' ),
		'edit_item'          => __( 'Edit Testimonial', 'teachmusic' ),
		'view_item'          => __( 'View Testimonial', 'teachmusic' ),
		'all_items'          => __( 'All Testimonials', 'teachmusic' ),
		'search_items'       => __( 'Search Testimonials', 'teachmusic' ),
		'parent_item_colon'  => __( 'Parent Testimonials:', 'teachmusic' ),
		'not_found'          => __( 'No Testimonials found.', 'teachmusic' ),
		'not_found_in_trash' => __( 'No Testimonials found in Trash.', 'teachmusic' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'menu_icon' 		 => 'dashicons-format-status',
		'publicly_queryable' => true,
		'menu_position' 	 => 2,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'excerpt')
	);

	register_post_type( 'testimonial', $args );
}
?>
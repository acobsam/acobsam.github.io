<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'myhouse_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function myhouse_sample_metaboxes( array $meta_boxes ) {
    global $textdomain;

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_cmb_';

	$meta_boxes[] = array(
		'id'         => 'album_options',
		'title'      => esc_html__('Gallery Options', 'myhouse'),
		'pages'      => array('gallery'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(

			array(
				'name' => esc_html__('Image zoom:', 'myhouse' ),
				'desc' => '',
				'id'   => esc_attr($prefix . 'gallery_zoom'),
				'type' => 'file',
				// 'repeatable' => true,
			)
		),
	);

	$meta_boxes[] = array(
		'id'         => 'blog_options',
		'title'      => esc_html__('Section Options', 'myhouse'),
		'pages'      => array('post','page'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(

			array(
				'name' => esc_html__('Section title:', 'myhouse' ),
				'desc' => '',
				'id'   => esc_attr($prefix . 'title'),
				'type' => 'text',
				'default'=>'Blog Section'
				// 'repeatable' => true,
			),
			array(
				'name' => esc_html__('Section description:', 'myhouse' ),
				'desc' => '',
				'id'   => esc_attr($prefix . 'desc'),
				'type' => 'textarea_small',
				// 'repeatable' => true,
			)
		),
	);

	$meta_boxes[] = array(
		'id'         => 'author_testimonial',
		'title'      => esc_html__('Testimonial author', 'myhouse' ),
		'pages'      => array( 'testimonial' ), // Tells CMB to use user_meta vs post_meta
		'show_names' => true,
		'cmb_styles' => false, // Show cmb bundled styles.. not needed on user profile page
		'fields'     => array(
			array(
				'name'    => esc_html__('Name', 'myhouse' ),
				'desc'    => esc_html__('Name (optional)', 'myhouse' ),
				'id'      => $prefix . 'name',
				'type'    => 'text_medium'
			),
			array(
				'name'     => esc_html__('Job', 'myhouse' ),
				'desc'     => esc_html__('Your Job (optional)', 'myhouse' ),
				'id'       => $prefix . 'job',
				'type'     => 'textarea_small'
			),
			array(
				'name'     => esc_html__('Avatar', 'myhouse' ),
				'desc'     => esc_html__('Avatar (optional)', 'myhouse' ),
				'id'       => $prefix . 'avatar',
				'type'     => 'file'
			),
		)
	);
	// Add other metaboxes as needed
	$meta_boxes['user_edit'] = array(
		'id'         => 'user_edit',
		'title'      => esc_html__('User Profile Metabox', 'myhouse' ),
		'pages'      => array( 'user' ), // Tells CMB to use user_meta vs post_meta
		'show_names' => true,
		'cmb_styles' => false, // Show cmb bundled styles.. not needed on user profile page
		'fields'     => array(
			array(
				'name'    => esc_html__('Avatar', 'myhouse' ),
				'desc'    => esc_html__('field description (optional)', 'myhouse' ),
				'id'      => esc_attr($prefix . 'avatar'),
				'type'    => 'file',
				'save_id' => true,
			),

			array(
				'name'     => esc_html__('Job', 'myhouse' ),
				'desc'     => esc_html__('Your Job (optional)', 'myhouse' ),
				'id'       => esc_attr($prefix . 'user_Job'),
				'type'     => 'text',
				'on_front' => false,
			),
		)
	);
	return $meta_boxes;
}


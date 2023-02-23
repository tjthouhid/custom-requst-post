<?php
/*
Plugin Name: Request with Custom Fields
*/
if ( ! defined( '_GD_REQUEST_VERSION' ) ) {
	// Replace the version number of the plugin on each release.
	define( '_GD_REQUEST_VERSION', '1.0.1' );
}

function create_gd_request_post_type() {
  $labels = array(
    'name' => 'Requests',
    'singular_name' => 'Request',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Request',
    'edit_item' => 'Edit Request',
    'new_item' => 'New Request',
    'view_item' => 'View Request',
    'search_items' => 'Search Requests',
    'not_found' => 'No Requests found',
    'not_found_in_trash' => 'No Requests found in Trash'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'has_archive' => true,
    'menu_position' => 5,
    'supports' => array('title', 'editor'),
    'taxonomies' => array(),
    'menu_icon' => 'dashicons-admin-post',
    'rewrite' => array('slug' => 'gd_request_post')
  );

  register_post_type('gd_request_post', $args);
}
add_action('init', 'create_gd_request_post_type');

include 'views/admin.php';
include 'views/shortcode.php';
include 'includes/save.php';


// function save_custom_post() {
//   $post_data = array(
//     'post_title' => $_POST['post_title'],
//     'post_content' => $_POST['post_content'],
//     'post_type' => 'custom_post',
//     'post_status' => 'publish'
//   );
  
//   $post_id = wp_insert_post($post_data);
  
//   update_post_meta($post_id, 'name', $_POST['name']);
//   update_post_meta($post_id, 'email', $_POST['email']);
//   update_post_meta($post_id, 'phone', $_POST['phone']);
// }
// add_action('init', 'save_custom_post');

function gd_request_scripts() {
  wp_register_script( 'gd_reques_js', plugins_url( '/assets/js/gd-request.js', __FILE__ ), array('jquery'),_GD_REQUEST_VERSION, true);
  wp_localize_script( 'gd_reques_js', 'gdAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));  
 
  wp_enqueue_script('gd_reques_js');

  wp_enqueue_style( 'gd_reques_css', plugins_url('/assets/css/style.css', __FILE__ ), array(), _GD_REQUEST_VERSION );
}
add_action( 'wp_enqueue_scripts', 'gd_request_scripts', 20, 1);

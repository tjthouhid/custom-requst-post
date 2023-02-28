<?php
/*
Plugin Name: Request with Custom Fields
Description:  Custom Product Request from user.
Version:      3.1.5
Author:       Tj Thouhid
Author URI:   https://www.tjthouhid.com/
*/

require 'includes/email.php';
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
    'supports' => array('title'),
    'taxonomies' => array(),
    'menu_icon' => 'dashicons-admin-post',
    'rewrite' => array('slug' => 'gd_request_post'),
    'register_meta_box_cb' => 'request_information_box'
  );

  register_post_type('gd_request_post', $args);
}
add_action('init', 'create_gd_request_post_type');


function request_information_box() {

  add_meta_box(
      'request-information',
      __( 'Reqest Info', 'sitepoint' ),
      'request_information_box_callback'
  );

}



function request_information_box_callback( $post ) {

  // Add a nonce field so we can check for it later.
  


  $name = get_post_meta($post->ID, 'name', true);
  $email = get_post_meta($post->ID, 'email', true);
  $phone = get_post_meta($post->ID, 'phone', true);
  $type = get_post_meta($post->ID, 'type', true);
  $color = get_post_meta($post->ID, 'color', true);
  $width = get_post_meta($post->ID, 'width', true);
  $min_width = get_post_meta($post->ID, 'min_width', true);
  $max_width = get_post_meta($post->ID, 'max_width', true);
  $height = get_post_meta($post->ID, 'height', true);
  $min_height = get_post_meta($post->ID, 'min_height', true);
  $max_height = get_post_meta($post->ID, 'max_height', true);
  $emailed = get_post_meta($post->ID, 'emailed', true);
?>
<style>
  .request_table{
    width : 100%;
  }
</style>
<table class="request_table" border="1">
  <tbody>
    <tr>
      <th>Name</th>
      <td><?php echo $name;?></td>
    </tr>
    <tr>
      <th>Email</th>
      <td><?php echo $email;?></td>
    </tr>
    <tr>
      <th>Phone</th>
      <td><?php echo $phone;?></td>
    </tr>
    <tr>
      <th>Type</th>
      <td><?php echo $type;?></td>
    </tr>
    <tr>
      <th>Color</th>
      <td><?php echo $color;?></td>
    </tr>
    <tr>
      <th>Width</th>
      <td><?php echo $width;?>cm</td>
    </tr>
    <tr>
      <th>Min width</th>
      <td><?php echo $min_width;?>cm</td>
    </tr>
    <tr>
      <th>Max width</th>
      <td><?php echo $max_width;?>cm</td>
    </tr>
    <tr>
      <th>Height</th>
      <td><?php echo $height;?>cm</td>
    </tr>
    <tr>
      <th>Min Height</th>
      <td><?php echo $min_height;?>cm</td>
    </tr>
    <tr>
      <th>Max Height</th>
      <td><?php echo $max_height;?>cm</td>
    </tr>
    <tr>
      <th>Emailed</th>
      <td>
      <input type="radio" name="emailed" value ="1" <?php if($emailed){ echo "checked";}?>> Yes
      <input type="radio" name="emailed" value ="0" <?php if(!$emailed){ echo "checked";}?>> No
    </tr>
  </tbody>
</table>
<?php
}

function save_request_information_meta_box_data( $post_id ) {
  

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }

  // Check the user's permissions.
  if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) ) {
        return;
    }

  }
  else {

      if ( ! current_user_can( 'edit_post', $post_id ) ) {
          return;
      }
  }
  
  // Make sure that it is set.
  if ( ! isset( $_POST['emailed'] ) ) {
    return;
  }
  $emailed = sanitize_text_field( $_POST['emailed'] );
  

    // Update the meta field in the database.
    update_post_meta( $post_id, 'emailed', $emailed );
}

add_action( 'save_post', 'save_request_information_meta_box_data' );

include 'views/admin.php';
include 'views/shortcode.php';
include 'includes/save.php';
include 'includes/search_request.php';
include 'includes/corn.php';




function gd_request_scripts() {
  wp_register_script( 'gd_reques_js', plugins_url( '/assets/js/gd-request.js', __FILE__ ), array('jquery'),_GD_REQUEST_VERSION, true);
  wp_localize_script( 'gd_reques_js', 'gdAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));  
 
  wp_enqueue_script('gd_reques_js');

  wp_enqueue_style( 'gd_reques_css', plugins_url('/assets/css/style.css', __FILE__ ), array(), _GD_REQUEST_VERSION );
}
add_action( 'wp_enqueue_scripts', 'gd_request_scripts', 20, 1);


 // Admin script
 function gd_req_admin_scripts() {
  wp_register_script( 'gd_admin_reques_js', plugins_url( '/assets/js/gd-admin.js', __FILE__ ), array('jquery'),_GD_REQUEST_VERSION, true);
  wp_localize_script( 'gd_admin_reques_js', 'gdAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));  
 
  wp_enqueue_script('gd_admin_reques_js');

}
add_action('admin_enqueue_scripts', 'gd_req_admin_scripts', 20, 1);

function unsubscribe(){
?>
<div class="modal fade" id="remove_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h3 class="bg-success text-white p-3">We have removed you from our product search</h3>
            </div>
        </div>
    </div>
</div>
<?php  }

  add_action('wp_footer', 'unsubscribe');


 
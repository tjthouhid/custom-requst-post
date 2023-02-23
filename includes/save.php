<?php 
// function process_custom_form() {
//     if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone'])) {
//       $post_data = array(
//         'post_title' => $_POST['name'],
//         'post_type' => 'gd_request_post',
//         'post_status' => 'publish'
//       );
    
//       $post_id = wp_insert_post($post_data);
    
//       update_post_meta($post_id, 'name', $_POST['name']);
//       update_post_meta($post_id, 'email', $_POST['email']);
//       update_post_meta($post_id, 'phone', $_POST['phone']);
      
//       echo '<p>Form submitted successfully!</p>';
//     }
//   }
  
//   add_action('wp_head', 'process_custom_form');

  

add_action("wp_ajax_gd_add_request_post", "gd_add_request_post");
add_action("wp_ajax_nopriv_gd_add_request_post", "gd_add_request_post");

function gd_add_request_post(){

    //tj($_POST);exit;
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$type = $_POST['type'];
	$color = $_POST['color'];
	$width = $_POST['width'];
	$min_width = $_POST['min_width'];
	$max_width = $_POST['max_width'];
	$height = $_POST['height'];
	$min_height = $_POST['min_height'];
	$max_height = $_POST['max_height'];

    $post_data = array(
        'post_title' => "Request",
        'post_type' => 'gd_request_post',
        'post_status' => 'publish'
    );

    $post_id = wp_insert_post($post_data);
    //tj($post_id);
    
    update_post_meta($post_id, 'name', $name);
    update_post_meta($post_id, 'email', $email);
    update_post_meta($post_id, 'phone', $phone);
    update_post_meta($post_id, 'type', $type);
    update_post_meta($post_id, 'color', $color);
    update_post_meta($post_id, 'width', $width);
    update_post_meta($post_id, 'max_width', $max_width);
    update_post_meta($post_id, 'height', $height);
    update_post_meta($post_id, 'min_height', $min_height);
    update_post_meta($post_id, 'max_height', $max_height);
  
	
	$data = json_encode(array("result"=>true));
    echo $data;
    die();

    
}
  
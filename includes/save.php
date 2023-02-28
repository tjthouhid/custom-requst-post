<?php 
  

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
    update_post_meta($post_id, 'min_width', $min_width);
    update_post_meta($post_id, 'max_width', $max_width);
    update_post_meta($post_id, 'height', $height);
    update_post_meta($post_id, 'min_height', $min_height);
    update_post_meta($post_id, 'max_height', $max_height);
    update_post_meta($post_id, 'emailed', 1);
    update_post_meta($post_id, 'found', 0);
    update_post_meta($post_id, 'products', "");
  
	
	$data = json_encode(array("result"=>true));
    echo $data;
    die();

    
}
add_action("wp_ajax_gd_product_request_remove_email", "do_product_request_remove_email");
add_action("wp_ajax_nopriv_gd_product_request_remove_email", "do_product_request_remove_email");
function do_product_request_remove_email(){
    global $wpdb; 

    $id = $_POST['id'];
    update_post_meta($id, 'emailed', 0);
    die();
}

add_action("wp_ajax_gd_product_request_check", "gd_product_request_check");
add_action("wp_ajax_nopriv_gd_product_request_check", "gd_product_request_check");
function gd_product_request_check(){
    
    global $wpdb; 
    $id = $_POST['id'];

    $customer['id'] = $id;
    $customer['name'] = get_post_meta($id, 'name', true);
    $customer['email'] = get_post_meta($id, 'email', true);
    $customer['phone'] = get_post_meta($id, 'phone', true);
    $customer['type'] = get_post_meta($id, 'type', true);
    $customer['color'] = get_post_meta($id, 'color', true);
    $customer['width'] = get_post_meta($id, 'width', true);
    $customer['min_width'] = get_post_meta($id, 'min_width', true);
    $customer['max_width'] = get_post_meta($id, 'max_width', true);
    $customer['height'] = get_post_meta($id, 'height', true);
    $customer['min_height'] = get_post_meta($id, 'min_height', true);
    $customer['max_height'] = get_post_meta($id, 'max_height', true);
    $customer['emailed'] = get_post_meta($id, 'emailed', true);
    $customer['products'] = get_post_meta($id, 'products', true);
    $customer['found'] = get_post_meta($id, 'found', true);
    $customer['date_override'] = 'all';

    (new gdSearchRequest)->check_for_products($customer);
    //gdSearchRequest::check_for_products($customer);
    echo "success";
    die();
}
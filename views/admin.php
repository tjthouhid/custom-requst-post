<?php 

function add_gd_request_columns_to_admin($columns) {
    $columns['name'] = __('Name');
    $columns['email'] = __('Email');
    $columns['phone'] = __('Phone');
   // $columns['type'] = __('Type');
   // $columns['color'] = __('Color');
    $columns['width'] = __('Width');
   // $columns['min_width'] = __('Min Width');
   // $columns['max_width'] = __('Max Width');

    $columns['height'] = __('Height');
    //$columns['min_height'] = __('Min Height');
   // $columns['max_height'] = __('Max Height');
    $columns['emailed'] = __('Emailed');
    $columns['found'] = __('Found');
    $columns['products'] = __('Products');
    $columns['notes'] = __('Notes');
    $columns['check'] = __('Check');
    return $columns;
  }
  add_filter('manage_gd_request_post_posts_columns', 'add_gd_request_columns_to_admin');
  
  function populate_gd_request_columns($column_name, $post_id) {
    if ($column_name === 'name') {
      echo get_post_meta($post_id, 'name', true);
    } elseif ($column_name === 'email') {
      echo get_post_meta($post_id, 'email', true);
    } elseif ($column_name === 'phone') {
      echo get_post_meta($post_id, 'phone', true);
    } elseif ($column_name === 'type') {
        echo get_post_meta($post_id, 'type', true);
    } elseif ($column_name === 'color') {
        echo get_post_meta($post_id, 'color', true);
    } elseif ($column_name === 'width') {
        echo get_post_meta($post_id, 'width', true);
    } elseif ($column_name === 'min_width') {
        echo get_post_meta($post_id, 'min_width', true);
    } elseif ($column_name === 'max_width') {
        echo get_post_meta($post_id, 'max_width', true);

    } elseif ($column_name === 'height') {
        echo get_post_meta($post_id, 'height', true);
    } elseif ($column_name === 'min_height') {
        echo get_post_meta($post_id, 'min_height', true);
    } elseif ($column_name === 'max_height') {
        echo get_post_meta($post_id, 'max_height', true);
    } 
    elseif ($column_name === 'emailed') {
        echo get_post_meta($post_id, 'emailed', true);
    } 
    elseif ($column_name === 'found') {
        echo get_post_meta($post_id, 'found', true);
    } 

    elseif ($column_name === 'products') {
        echo get_post_meta($post_id, 'products', true);
    } 
    elseif ($column_name === 'check') {
        echo '<a class="do-check" href="#" data-id="'.$post_id.'">Check</a>';
    } 
    elseif ($column_name === 'notes') {
        echo get_post_meta($post_id, 'notes', true);
    } 
  }
  add_action('manage_gd_request_post_posts_custom_column', 'populate_gd_request_columns', 10, 2);


  add_filter('bulk_actions-edit-gd_request_post', function($bulk_actions) {
	$bulk_actions['check'] = __('Check', '');
	return $bulk_actions;
});

add_filter('handle_bulk_actions-edit-gd_request_post', function($redirect_url, $action, $post_ids) {
    // print_r($action);//exit;
    
	if ($action == 'check') {
       
		foreach ($post_ids as $post_id) {
            global $wpdb; 
            $id = $post_id;
        
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
		}
		$redirect_url = add_query_arg('check', count($post_ids), $redirect_url);
	}
	return $redirect_url;
}, 10, 3);
add_action('admin_notices', function() {
	if (!empty($_REQUEST['check'])) {
		$num_changed = (int) $_REQUEST['check'];
		printf('<div id="message" class="updated notice is-dismissable"><p>' . __('Updated %d Request.', 'txtdomain') . '</p></div>', $num_changed);
	}
});
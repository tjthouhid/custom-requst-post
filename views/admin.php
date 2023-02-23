<?php 

function add_gd_request_columns_to_admin($columns) {
    $columns['name'] = __('Name');
    $columns['email'] = __('Email');
    $columns['phone'] = __('Phone');
    $columns['type'] = __('Type');
    $columns['color'] = __('Color');
    $columns['width'] = __('Width');
    $columns['min_width'] = __('Min Width');
    $columns['max_width'] = __('Max Width');
    $columns['min_width'] = __('Min Width');
    $columns['min_width'] = __('Min Width');
    $columns['height'] = __('Height');
    $columns['min_height'] = __('Min Height');
    $columns['max_height'] = __('Max Height');
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
  }
  add_action('manage_gd_request_post_posts_custom_column', 'populate_gd_request_columns', 10, 2);
<?php 
define('CUSTOM_REQUEST_PLUGIN_DIR', plugin_dir_path(dirname( __FILE__ )));

global $wpdb; 

class gdSearchRequest {
    public function __construct()
    {
    }

    function check_for_products($customer){

        
        $id = $customer['id'];
        $type = ($customer['type'] != '') ? $customer['type'] : '';
        $color = $customer['color'];
        $email = $customer['email'];

        // $min_width = array_key_exists('min_width', $_POST) ? $_POST['min_width'] : '';
        $width = floatval($customer['width']);
        $height = floatval($customer['height']);
        $min_width = ($customer['min_width']) ? floatval($customer['min_width']) : $width - 5;
        $max_width = ($customer['max_width']) ? floatval($customer['max_width']) : $width;
        $min_height = ($customer['min_height']) ? floatval($customer['min_height']) : $height - 5;
        $max_height = ($customer['max_height']) ? floatval($customer['max_height']) : $height;

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 40,
        );

        if (!array_key_exists('date_override', $customer)) {

            $args['date_query'] = array(
                'after'     => date('F jS Y', strtotime('-3 day')),
            );
        }

        if($type != '') {
            $args['product_cat'] = $type;
        }
        
        if($width) {
            $args['meta_query'][] = array(
                array(
                    'key' => '_width',
                    'value' => array($min_width, $max_width),
                    'compare' => 'BETWEEN',
                    'type' => 'DECIMAL(10,4)'
                ),
            );
        }

        if($height) {
            $args['meta_query'][0][] = array(
                array(
                    'key' => '_height',
                    'value' => array($min_height, $max_height),
                    'compare' => 'BETWEEN',
                    'type' => 'DECIMAL(10,4)'
                ),
            );
        }
    
        

        if(!empty($color) ) {
            $args['tax_query'][0]   = array(
                'taxonomy' => 'pa_colour',
                'field'    => 'slug',
                'terms'    => explode(',', $color)
              );
              
       }

    
        $args['meta_query'][] =
        array(
            'key' => '_stock_status',
            'value' => 'instock'
        );
        

        
        
        $product_info = new WP_Query( $args );
    

        

        $customer['product_ids'] = '';
        $customer['products_data'] = [];

        $products_already_asigned = explode(",", $customer['products']);
        $send_email = 0;

       
       

        if($product_info->found_posts) {
       
            
            $found = 0;


            if($customer['emailed'] == 1){

                while ( $product_info->have_posts() ) : 
                    $product_info->the_post();
                    global $product;

                    $customer['product_ids'] .= get_the_id() . ',';

                    

                    if (!in_array(get_the_id(), $products_already_asigned)) {
                        $found ++;

                        $customer['products'] .= get_the_id() . ',';

                        $send_email = 1;

                        $customer['products_data'][get_the_id()] = [
                            'title' => get_the_title(),
                            'width' => $product->get_width(),
                            'height' => $product->get_height(),
                            'image' => get_the_post_thumbnail_url(get_the_ID(), 'product_thumb'),
                            'url' => get_permalink()
                        ];
                    }
                endwhile;
                wp_reset_query();
                wp_reset_postdata();
             
               

               
                update_post_meta($id, 'found', $customer['found']+$found);
                update_post_meta($id, 'products', $customer['products']);
                    

                if($send_email){
                    $customer['site_url'] = site_url();
                    $customer['found'] = $found;
                    
                    $email = "sales@usedupvc.co.uk,".$email;
                    //$email = $email;
                    $this->send_custom_email($email, $customer);
                    
                   
                }
            }
        }
    }

    function send_custom_email($email, $customer) {
        $recipient = $email;
        $subject = 'You have a product!';
        $template_path = '';
        $default_path = untrailingslashit( CUSTOM_REQUEST_PLUGIN_DIR ) .'/';
        $template_html = 'views/email-template.php';
        $template_plain = 'emails/plain/customer-processing-order.php';

        $email_heading = "We found some products for you!";
        $email_content =  wc_get_template_html(
            $template_html,
            array(
                'customer' => $customer,
                'email' => $recipient,
                'email_heading' => $email_heading,
            ),
            $template_path,
            $default_path
        );


        // Load the WooCommerce email classes
        if ( ! class_exists( 'WC_Email' ) ) {
            include_once WC_ABSPATH . 'includes/emails/class-wc-email.php';
        }
        $email_object = new WC_Email();
        $email_content = $email_object->style_inline( $email_content );
        add_filter('wp_mail_content_type', function( $content_type ) {
            return 'text/html';
        });
        wp_mail( $recipient, $subject,   $email_content);
    }


    
    

    // checks all but restricts to date as its not defined
    function checkAll() {
        global $wpdb; 

        $sql = "SELECT ID
        FROM {$wpdb->prefix}posts 
        WHERE 1=1  AND post_type = 'gd_request_post' AND ((post_status = 'publish'))
        ORDER BY post_date DESC";
        $results = $wpdb->get_results($sql);
        $customer = array();
        $i = 0;
        foreach ( $results as $result ){
            
            $customer[$i]['id'] = $result->ID;
            $customer[$i]['name'] = get_post_meta($result->ID, 'name', true);
            $customer[$i]['email'] = get_post_meta($result->ID, 'email', true);
            $customer[$i]['phone'] = get_post_meta($result->ID, 'phone', true);
            $customer[$i]['type'] = get_post_meta($result->ID, 'type', true);
            $customer[$i]['color'] = get_post_meta($result->ID, 'color', true);
            $customer[$i]['width'] = get_post_meta($result->ID, 'width', true);
            $customer[$i]['min_width'] = get_post_meta($result->ID, 'min_width', true);
            $customer[$i]['max_width'] = get_post_meta($result->ID, 'max_width', true);
            $customer[$i]['height'] = get_post_meta($result->ID, 'height', true);
            $customer[$i]['min_height'] = get_post_meta($result->ID, 'min_height', true);
            $customer[$i]['max_height'] = get_post_meta($result->ID, 'max_height', true);
            $customer[$i]['emailed'] = get_post_meta($result->ID, 'emailed', true);
            $customer[$i]['products'] = get_post_meta($result->ID, 'products', true);
            $customer[$i]['found'] = get_post_meta($result->ID, 'found', true);
            if($customer[$i]['emailed'] == 1){
               
                (new gdSearchRequest)->check_for_products($customer[$i]);
               
             }
            $i++;
        }
        
        

        
       

    }
}


?>
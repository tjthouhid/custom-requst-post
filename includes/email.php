<?php

class pr_Email {
    public function __construct()
    {
    }


    function email_message($customer) {
        global $wpdb; 
    
    
        $id = $customer['id'];
        $name = $customer['name'];
        $type = $customer['type'];
        $amount = $customer['found'];
        $email =  $customer['email'];
        $phone =  $customer['phone'];
        $width =  $customer['width'];
        $height =  $customer['height'];
        $min_width =  $customer['min_width'];
        $max_width =  $customer['max_width'];
        $min_height =  $customer['min_height'];
        $max_height =  $customer['max_height'];
        $site_url =  $customer['site_url'];
    
        $message = 

        '<div style="background: #f0f0f1;">
        <div style="display: block; max-width: 1000px; margin: 0 auto">
        <div style="font-size: 45px; background: #638878; color: #fff; padding: 50px 25px;">We found some products for you!</div>' .

        '<div style="
        background: #fff;
        padding: 25px;
        color: #636363;
        font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
        font-size: 14px;
        line-height: 150%;
        text-align: left;">
        <div>Hi ' . $name . '</div><br/>' .
    
        'We found ' . $amount . ' Products that could work for you based on the sizes you requested. <br/> <br/>' .
    
        

        $message .= '<div style="display: block; width:100%">';

        if($customer['products']) {
            foreach ($customer['products_data'] as $product) {

                $message .= '<div style="width:50%; float: left;">
                    <img style="background: #365749; padding: 6px 12px; color: #fff; text-decoration: none display: block; width: auto; max-height: 260px;" src="' . $product['image'] . '" alt="Product image" />
                    <br/>' . 
                    $product['title'] . '<br/>' . 
                    'Width: ' . $product['width'] . 'cm Height: ' . $product['height'] . 'cm<br/>' .
                    '<a target="_blank" href="' . $product['url'] . '">View Product</a>
                </div>';
            }
        }

        $message .= '</div>';

        $message .= '<div style="margin-top: 10px; display:block; width:100%;"><a style="display: inline-block; background: #e3e3e3; padding: 6px 12px; color: #000; text-decoration: none" href="'.$site_url.'?removeemail=' . $id . '">Unsubscribe from these emails</a></div>';
        $message .= '</div>';
        $message .= '</div>';
        $message .= '</div>';
    
        return $message;
    }
    

}
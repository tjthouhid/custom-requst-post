<?php 
function gd_request_form_shortcode() {
    ob_start();
    ?>
   
    <?php
    include "form.php";
    //echo get_template_part('form');
    return ob_get_clean();
  }
  add_shortcode('gd-request-form', 'gd_request_form_shortcode');
  
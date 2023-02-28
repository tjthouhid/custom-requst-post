<?php 


// here's the function we'd like to call with our cron job
function gd_check_request_product() {
    gdSearchRequest::checkAll();
}

// hook that function onto our scheduled event:
add_action ('gd_check_request_product', 'gd_check_request_product'); 



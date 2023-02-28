jQuery(function($){
    $('.do-check').on('click', function(e){
        e.preventDefault();

        $id = $(this).data('id');
        
        var data = {
            'action': 'gd_product_request_check',
            'id': $id,
        };

        jQuery.ajax({
            type : "post",
            dataType : "html",
            url : gdAjax.ajaxurl,
            data : data,
            success: function(response) {
                console.log("response");
                location.reload();
                return false;
            }
        });
    });
});
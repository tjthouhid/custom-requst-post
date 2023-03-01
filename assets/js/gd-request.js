jQuery(function($){
    $("body").on("click","#gd_widthHelpBlock",function(e){
        e.preventDefault();
        $(".hide-gd-width").slideToggle();

    });
    $("body").on("click","#gd_heightHelpBlock",function(e){
        e.preventDefault();
        $(".hide-gd-height").slideToggle();

    });
    $("body").on("click","#submit_request",function(e){
        e.preventDefault();
    
        var $button = $(this);
        var name = $("#gd_name");
        var email = $("#gd_email");
        var phone = $("#gd_phone");
        var type = $("#gd_type");
        var color = $("#gd_color");
        var width = $("#gd_width");
        var min_width = $("#gd_width_min");
        var max_width = $("#gd_width_max");
        var height = $("#gd_height");
        var min_height = $("#gd_height_min");
        var max_height = $("#gd_height_max");
        if(name.val() == "" || email.val() == "" || phone.val() == ""){
            $(".error_gd_r_msg").html("<span class='bg-danger text-white text-center d-block p-1'>Please Fillup Required Feilds.</span>");
            $(".error_gd_r_msg").fadeIn();
            return false;
        }else{
            $(".error_gd_r_msg").fadeOut();
        }
        //return false;
        var data = {
            action: "gd_add_request_post", 
            name : name.val(),
            email : email.val(),
            phone : phone.val(),
            type : type.val(),
            color : color.val(),
            width : width.val(),
            min_width : min_width.val(),
            max_width : max_width.val(),
            height : height.val(),
            min_height : min_height.val(),
            max_height : max_height.val()

        };

        
        $button.attr('disabled','disabled');
        //return false
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : gdAjax.ajaxurl,
            data : data,
            success: function(response) {
                $button.removeAttr('disabled');
                //console.log(response);
                $(".gd_request_thankyou").fadeIn();
                $('.request-form .container').fadeOut();
                $('form#gd_product_request_form')[0].reset();
            }
        });

     
    });

    $("body").on("click",".clear-gd-form",function(e){
        e.preventDefault();
        $(".error_gd_r_msg").fadeOut();
        $(".gd_request_thankyou").fadeOut();
        $('form#gd_product_request_form')[0].reset();
        $('.request-form .container').fadeIn();
    });

    if (window.location.href.indexOf('?removeemail=') > 0) {

        $url = new URL(window.location.href);

        var data = {
            action: "gd_product_request_remove_email", 
            id : $url.searchParams.get("removeemail"),
        }
      

        $.ajax({
            url: gdAjax.ajaxurl,
            type: 'post',
            // action: 'product_request_remove_email'
            data: data,
            success: function(data) {
                $('#remove_Modal').modal('show');
            }
        });
    }
});
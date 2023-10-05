function send_message(){
    jQuery(".field_error").html("");
    var contact_us_form_token = jQuery("#contact_us_form_token").val();
    var name = jQuery("#name").val();
    var mobile = jQuery("#mobile").val();
    var email = jQuery("#email").val();
    var message = jQuery("#message").val();
    var is_error = '';
    
    if(name==''){
        jQuery("#field_final_alert_in_contact_us").hide();
        jQuery("#name_error").html("Please enter your name.");
        is_error = "yes";
    }
    if(mobile==''){
        jQuery("#field_final_alert_in_contact_us").hide();
        jQuery("#mobile_error").html("Please enter your mobile number.");
        is_error = "yes";
    }
    if(email==''){
        jQuery("#field_final_alert_in_contact_us").hide();
        jQuery("#email_error").html("Please enter your email address.");
        is_error = "yes";
    }
    if(message==''){
        jQuery("#field_final_alert_in_contact_us").hide();
        jQuery("#message_error").html("Please write your message.");
        is_error = "yes";
    }
    if(is_error==''){
    jQuery.ajax({
    url: 'send_message.php',
    type: 'post',
    data: 'contact_us_form_token='+contact_us_form_token+ '&name='+name+ '&mobile='+mobile+ '&email='+email+ '&message='+message,
    success: function(result){
        if(result=='Error: Multiple tabs are open/token expired/invalid token'){
            alert("Error: Multiple tabs are open/token expired/invalid token");
            window.location.href = "index.php";
            // jQuery("#field_final_alert_in_contact_us").show();
            // jQuery("#field_final_alert_in_contact_us").html("Invalid token.").addClass("alert-danger").css("padding", "1rem 1.5rem");
        }
        else if(result=='send_message_data_empty'){
            jQuery("#field_final_alert_in_contact_us").show();
            jQuery("#field_final_alert_in_contact_us").html("Please fillup all the required details.").addClass("alert-danger").css("padding", "1rem 1.5rem");
        }
        else if(result=='invalid_name'){
            jQuery("#field_final_alert_in_contact_us").hide();
            jQuery("#name_error").html("Invalid name.");
        }
        else if(result=='invalid_email_address'){
            jQuery("#field_final_alert_in_contact_us").hide();
            jQuery("#email_error").html("Invalid email address.");
        }
        else if(result=='invalid_mobile_number'){
            jQuery("#field_final_alert_in_contact_us").hide();
            jQuery("#mobile_error").html("Invalid mobile number.");
        }
        else if(result=='message_length_insufficient'){
            jQuery("#field_final_alert_in_contact_us").hide();
            jQuery("#message_error").html("Message length insufficient to send message.");
        }
        else if(result=='sent'){
            jQuery("#field_final_alert_in_contact_us").show();
            jQuery("#field_final_alert_in_contact_us").html("Message sent. We will get back to you soon.").removeClass("alert-danger").addClass("alert-success").css("padding", "1rem 1.5rem");
            jQuery("#contact_us_form")[0].reset();
        }
        // else{
        //     jQuery(".alert").html("Something went wrong. Please try again later.").addClass("alert-danger");
        //     jQuery("#contact_us_form")[0].reset();
        // }
    }
    });
    }
    }
    
    
    
    function user_register(){
        jQuery("#name_error").html("");
        jQuery("#email_error").html("");
        jQuery("#mobile_error").html("");
        jQuery("#password_error").html("");
        var registration_form_token = jQuery("#registration_form_token").val();
        var name = jQuery("#name").val();
        var email = jQuery("#email").val();
        var mobile = jQuery("#mobile").val();
        var password = jQuery("#password").val();
        var is_error = '';
        if(name==''){
            jQuery("#field_final_alert_in_register").hide();
            // jQuery("#name_field_error_alert").html("Please enter your name.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 0.5rem 0"});
            jQuery("#name_error").html("Please enter your name.");
            is_error = "yes";
        }
        if(email==''){
            jQuery("#field_final_alert_in_register").hide();
            // jQuery("#field_error_alert_email_send_otp").show();
            // jQuery("#field_verified_alert_email_verify_otp").hide();
            // jQuery("#field_error_alert_email_send_otp").html("Please enter your email address.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#email_error").html("Please enter you email address.");
            is_error = "yes";
        }
        if(mobile==''){
            jQuery("#field_final_alert_in_register").hide();
            // jQuery("#field_error_alert_mobile_send_otp").show();
            // jQuery("#field_verified_alert_mobile_verify_otp").hide();
            // jQuery("#field_error_alert_mobile_send_otp").html("Please enter your mobile number.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#mobile_error").html("Please enter your mobile number.");
             is_error = "yes";
        }
        if(password==''){
            jQuery("#field_final_alert_in_register").hide();
            // jQuery("#password_field_error_alert").html("Please enter your password.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 0.5rem 0"});
            jQuery("#password_error").html("Please enter your password.");
             is_error = "yes";
        }
        
        if(is_error==''){
            jQuery.ajax({
                url: 'register_submit.php',
                type: 'post',
                data: 'registration_form_token='+registration_form_token+ '&name='+name+ '&email='+email+ '&mobile='+mobile+ '&password='+password,
                success: function(result){
                    if(result=='Error: Multiple tabs are open/token expired/invalid token'){
                        alert("Error: Multiple tabs are open/token expired/invalid token");
                        window.location.href = "index.php";
                        // jQuery("#field_final_alert_in_register").show();
                        // jQuery("#field_final_alert_in_register").html("Invalid token.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin-top": "1rem"});
                        // jQuery("#field_error_alert_email_send_otp").hide();
                        // jQuery("#field_error_alert_mobile_send_otp").hide();
                        // jQuery("#field_verified_alert_email_verify_otp").hide();
                        // jQuery("#field_verified_alert_mobile_verify_otp").hide();
                        // jQuery("#name_field_error_alert").hide();
                        // jQuery("#password_field_error_alert").hide();
                    }
                    else if(result=='email_present'){
                        jQuery("#email_error").html("Email id already exists.");
                    }
                    else if(result=='mobile_present'){
                        jQuery("#mobile_error").html("Mobile number already exists.");
                    }
                    else if(result=='register_submit_data_empty'){
                        jQuery("#field_final_alert_in_register").show();
                        jQuery("#field_final_alert_in_register").html("Please fillup all the required details.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin-top": "1rem"});
                        // jQuery("#field_error_alert_email_send_otp").hide();
                        // jQuery("#field_error_alert_mobile_send_otp").hide();
                        // jQuery("#field_verified_alert_email_verify_otp").hide();
                        // jQuery("#field_verified_alert_mobile_verify_otp").hide();
                        // jQuery("#name_field_error_alert").hide();
                        // jQuery("#password_field_error_alert").hide();
                    }
                    else if(result=='invalid_email_address'){
                        // jQuery("#field_final_alert_in_register").hide();
                        jQuery("#email_error").html("Invalid email address.");
                    }
                    else if(result=='invalid_mobile_number'){
                        // jQuery("#field_final_alert_in_register").hide();
                        jQuery("#mobile_error").html("Invalid mobile number.");
                    }
                    else if(result=='invalid_name'){
                        jQuery("#field_final_alert_in_register").hide();
                        jQuery("#name_error").html("Please use letters only.");
                    }
                    else if(result=='invalid_password_pattern'){
                        jQuery("#field_final_alert_in_register").hide();
                        jQuery("#password_error").html("Password must be at least 6 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.");
                    }
                    else if(result=='email_address_or_mobile_number_change_not_allowed'){
                        jQuery("#field_final_alert_in_register").show();
                        jQuery("#field_final_alert_in_register").html("Email address or mobile number cannot be changed after verification. Please register again.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin-top": "1rem"});
                        // jQuery("#field_error_alert_email_send_otp").hide();
                        // jQuery("#field_error_alert_mobile_send_otp").hide();
                        // jQuery("#field_verified_alert_email_verify_otp").hide();
                        // jQuery("#field_verified_alert_mobile_verify_otp").hide();
                        // jQuery("#name_field_error_alert").hide();
                        // jQuery("#password_field_error_alert").hide();
                        // jQuery(".email_otp_result").html("");
                        // jQuery(".mobile_otp_result").html("");
                        // jQuery("#register_form")[0].reset();
                    }
                    else if(result=='insert'){
                        jQuery("#field_final_alert_in_register").show();
                        jQuery("#field_final_alert_in_register").html("Thank you for registration.").removeClass("alert-danger").addClass("alert-success").css({"padding": "1rem 1.5rem", "margin-top": "1rem"});
                        // jQuery("#field_error_alert_email_send_otp").hide();
                        // jQuery("#field_error_alert_mobile_send_otp").hide();
                        // jQuery("#field_verified_alert_email_verify_otp").hide();
                        // jQuery("#field_verified_alert_mobile_verify_otp").hide();
                        // jQuery("#name_field_error_alert").hide();
                        // jQuery("#password_field_error_alert").hide();
                        jQuery(".email_otp_result").html("");
                        jQuery(".mobile_otp_result").html("");
                        jQuery("#register_form")[0].reset();
                    }
                }
                });
        }
    }
    
    
    
    function user_login(){
        jQuery(".field_error").html("");
        var login_form_token = jQuery("#login_form_token").val();
        var email = jQuery("#login_email").val();
        var password = jQuery("#login_password").val();
        var is_error = '';
        if(email==''){
            jQuery("#field_final_alert_in_login").hide();
            // jQuery("#field_error_alert_login_email").show();
            // jQuery("#field_error_alert_login_email").html("Please enter your email address.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin-top": "0.5rem", "margin-bottom": "0.6rem"});
            jQuery("#login_email_error").html("Please enter your email address.");
            is_error = "yes";
        }
        if(password==''){
            jQuery("#field_final_alert_in_login").hide();
            // jQuery("#field_error_alert_login_password").show();
            // jQuery("#field_error_alert_login_password").html("Please enter your password.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin-top": "0.5rem", "margin-bottom": "0.6rem"});
             jQuery("#login_password_error").html("Please enter your password.");
             is_error = "yes";
        }
        
        if(is_error==''){
            jQuery.ajax({
                url: 'login_submit.php',
                type: 'post',
                data: 'login_form_token='+login_form_token+ '&email='+email+ '&password='+password,
                success: function(result){
                    if(result=='Error: Multiple tabs are open/token expired/invalid token'){
                        alert("Error: Multiple tabs are open/token expired/invalid token");
                        window.location.href = "index.php";
                        // jQuery("#field_final_alert_in_login").show();
                        // jQuery("#field_final_alert_in_login").html("Invalid token.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin-top": "0.5rem", "margin-bottom": "0.6rem"});
                        // jQuery("#field_error_alert_login_email").hide();
                        // jQuery("#field_error_alert_login_password").hide();
                    }
                    else if(result=='login_submit_data_empty'){
                        jQuery("#field_final_alert_in_login").show();
                        jQuery("#field_final_alert_in_login").html("Please enter your email address and password.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin-top": "0.5rem", "margin-bottom": "0.6rem"});
                        // jQuery("#field_error_alert_login_email").hide();
                        // jQuery("#field_error_alert_login_password").hide();
                    }
                    else if(result=='wrong_email'){
                        jQuery("#field_final_alert_in_login").show();
                        jQuery("#field_final_alert_in_login").html("Please enter valid email address.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin-top": "0.5rem", "margin-bottom": "0.6rem"});
                        // jQuery(".login_msg p").html("Please enter valid login details");
                        // jQuery("#field_error_alert_login_email").hide();
                        // jQuery("#field_error_alert_login_password").hide();
                    }
                    else if(result=='wrong_password'){
                        jQuery("#field_final_alert_in_login").show();
                        jQuery("#field_final_alert_in_login").html("Please enter valid password.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin-top": "0.5rem", "margin-bottom": "0.6rem"});
                        // jQuery(".login_msg p").html("Please enter valid login details");
                        // jQuery("#field_error_alert_login_email").hide();
                        // jQuery("#field_error_alert_login_password").hide();
                    }
                    else if(result=='valid'){
                        window.location.href=window.location.href;
                    }
                }
                });
        }
    }
    
    function user_logout(){
        var logout_form_token = jQuery("#logout_form_token").val();
        jQuery.ajax({
            url: 'logout.php',
            type: 'post',
            data: 'logout_form_token='+logout_form_token,
            success: function(result){
                if(result=='Error: Multiple tabs are open/token expired/invalid token'){
                    alert("Error: Multiple tabs are open/token expired/invalid token");
                    window.location.href = "index.php";
                }
                else if(result=='logged_out'){
                    window.location.href = "index.php";
                }
            }
        });
    }
    
    function manage_cart(pid, type){
        if(type=='update'){
            var qty = jQuery("#"+pid+"qty").val();
        }
        else{
            var qty = jQuery("#qty").val();
            var token = jQuery("#add_or_remove_product_token").val();
        }
            jQuery.ajax({
                url: 'manage_cart.php',
                type: 'post',
                data: 'pid='+pid+ '&qty='+qty+ '&type='+type+ '&token='+token,
                success: function(result){
                    if(result=='Error: Multiple tabs are open/token expired/invalid token'){
                        alert("Error: Multiple tabs are open/token expired/invalid token");
                        window.location.href = "index.php";
                    }
                    else if(result=='quantity_not_available'){
                        alert("Quantity not available.");
                    }
                    else if(result=='minimum_quantity_is_one'){
                        alert("Minimum quantity is 1.");
                    }
                    else if(result=='invalid_product_id'){
                        alert("Invalid product ID.");
                    }
                    else if(result=='invalid_qty_value'){
                        alert("Invalid qty value.");
                    }
                    else if(result=='invalid_type'){
                        alert("Invalid type.");
                    }
                    else if(result=='quantity_cannot_be_changed_during_remove'){
                        alert("Quantity cannot be changed while removing an item.");
                    }
                    else if(type=='remove'){
                        window.location.href = window.location.href;
                    }
                    jQuery(".cart-count").html(result);
                    if(type=='add' && result>0){
                    var swal_text_div = document.createElement("div");
                    swal_text_div.innerHTML = "Total items: "+result+"<br>Go to <a href='cart.php' class='go_to_my_cart_a_tag_in_added_to_cart_popup'>My Cart</a>";
                    swal({
                        title: "Added to cart!",
                        content: swal_text_div,
                        html: true,
                        icon: "success",
                        buttons: [false, "CLOSE"],
                        closeOnClickOutside: false
                      });
                    }
                }
                });
    }
    
    
    // $(document).ready(function () {
    
    // $(document).on('click', '.updateCartItem', function(){
    // if($(this).hasClass('plus-a')){
    // var quantity = $(this).data('qty');
    // new_qty = parseInt(quantity) + 1;
    // }
    
    // if($(this).hasClass('minus-a')){
    //     var quantity = $(this).data('qty');
    //     if(quantity<=1){
    //     alert("Item quantity must be 1 or greater!");
    //     return false;
    //     }
    //     new_qty = parseInt(quantity) - 1;
    // }
    
    // var cart_id = $(this).data('cartid');
    
    // $.ajax({
    // data:{pid: cart_id, qty:new_qty, type:'update'},
    // url: 'manage_cart.php',
    // type: 'post',
    // success:function(result){
    //     window.location.href = window.location.href;
    //     // location.reload(true);
    // }
    // });
    // });
    
    
    // });
    
    
//Increment/decrement in cart page   
$(document).ready(function () {
    $('.increment-btn').click(function (e){
    e.preventDefault();

    var qty = $(this).closest('.product-quantity').find('.input-qty').val();
    var value = parseInt(qty, 10);
    value = isNaN(value)? 0 : value;
        value++;
        var qty = $(this).closest('.product-quantity').find('.input-qty').val(value);
    });

    $('.decrement-btn').click(function (e){
        e.preventDefault();
    
        var qty = $(this).closest('.product-quantity').find('.input-qty').val();
        var value = parseInt(qty, 10);
        value = isNaN(value)? 0 : value;
        if(value > 1) {
            value--;
            var qty = $(this).closest('.product-quantity').find('.input-qty').val(value);
        }
    });
});

//Update quantity in cart page   
$(document).ready(function () {
        $(document).on('click', '.updateQty', function () {
            var qty = $(this).closest('.product-quantity').find('.input-qty').val();
            var pid = $(this).closest('.product-quantity').find('.productId').val();
            var token = $(this).closest('.product-quantity').find('.update_product_token').val();
            
           $.ajax({
            data:{pid: pid, qty:qty, type:'update', token:token},
            url: 'manage_cart.php',
            method: 'post',
            success: function(response){
                if(response=='Error: Multiple tabs are open/token expired/invalid token'){
                    alert("Error: Multiple tabs are open/token expired/invalid token");
                    window.location = "index.php";
                }
                else if(response=='quantity_not_available'){
                    alert("Quantity not available.");
                    location.reload(true);
                }
                else if(response=='minimum_quantity_is_one'){
                    alert("Minimum quantity is 1.");
                    location.reload(true);
                }
                else if(response=='invalid_product_id'){
                    alert("Invalid product ID.");
                    location.reload(true);
                }
                else if(response=='invalid_qty_value'){
                    alert("Invalid qty value.");
                    location.reload(true);
                }
                else if(response=='invalid_type'){
                    alert("Invalid type.");
                    location.reload(true);
                }
                // $("#reload-div").load("cart.php");
                // alert(response);
                else{
                    location.reload(true);
                }
                // window.location.href = window.location.href;
            }
        });
    });
});

//Increment in products page
function increment(){
    document.getElementById("qty").stepUp();
}

//Decrement in products page
function decrement(){
    document.getElementById("qty").stepDown();
}

// Email Verification
function email_send_otp(){
    jQuery("#email_error").html("");
    var email_and_mobile_verification_form_token = jQuery("#email_and_mobile_verification_form_token").val();
    var email = jQuery("#email").val();
    if(email==''){
        // jQuery("#field_error_alert_email_send_otp").html("Please enter your email address.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
        jQuery("#email_error").html("Please enter your email address.");
    }
    else{
        jQuery(".email_send_otp span").html("Please Wait...");
        jQuery(".email_send_otp").attr('disabled', true);
        jQuery.ajax({
        url: 'send_otp.php',
        type: 'post',
        data: 'email_and_mobile_verification_form_token='+email_and_mobile_verification_form_token+ '&email='+email+ '&type=email',
        success: function(result){
        if(result=='Error: Multiple tabs are open/token expired/invalid token'){
            alert("Error: Multiple tabs are open/token expired/invalid token");
            window.location.href = "index.php";
            // jQuery(".email_send_otp span").html("REQUEST OTP");
            // jQuery(".email_send_otp").attr('disabled', false);
            // // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            // jQuery("#email_error").html("Invalid token.");
        }
        else if(result=='send_otp_email_data_empty'){
            jQuery(".email_send_otp span").html("REQUEST OTP");
            jQuery(".email_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#email_error").html("Please enter your email address.");
        }
        else if(result=='invalid_type'){
            jQuery(".email_send_otp span").html("REQUEST OTP");
            jQuery(".email_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#email_error").html("Invalid type.");
        }
        else if(result=='invalid_email_address'){
            jQuery(".email_send_otp span").html("REQUEST OTP");
            jQuery(".email_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#email_error").html("Invalid email address.");
        }
        else if(result=='done'){
            jQuery('#email').attr('disabled', true);
            jQuery(".email_verify_otp").show();
             jQuery(".resend_otp_for_email").show();
            jQuery(".email_verify_otp_div").show();
            jQuery(".email_send_otp").hide();
            // jQuery("#field_error_alert_email_send_otp").hide();
        }
        else if(result=='email_present'){
            jQuery(".email_send_otp span").html("REQUEST OTP");
            jQuery(".email_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#email_error").html("Email id already exists.");
        }
        else{
            jQuery(".email_send_otp span").html("REQUEST OTP");
            jQuery(".email_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_email_send_otp").html("Error occured. Please try again after sometime.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#email_error").html("Error occured. Please try again after sometime.");
        }
        }
        });

    }

}

// Email Verification
function email_resend_otp(){
    jQuery("#email_error").html("");
    var email_and_mobile_verification_form_token = jQuery("#email_and_mobile_verification_form_token").val();
    var email = jQuery("#email").val();
    if(email==''){
        // jQuery("#field_error_alert_email_send_otp").html("Please enter your email address.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
        jQuery("#email_error").html("Please enter your email address.");
    }
    else{
        jQuery(".resend_otp_for_email").html("[Please Wait...]");
        jQuery(".resend_otp_for_email").css("pointer-events", "none");
        jQuery.ajax({
        url: 'send_otp.php',
        type: 'post',
        data: 'email_and_mobile_verification_form_token='+email_and_mobile_verification_form_token+ '&email='+email+ '&type=email',
        success: function(result){
        if(result=='Error: Multiple tabs are open/token expired/invalid token'){
            alert("Error: Multiple tabs are open/token expired/invalid token");
            window.location.href = "index.php";
            // jQuery(".resend_otp_for_email").html("[Resend Code]");
            // jQuery(".resend_otp_for_email").css("pointer-events", "");
            // // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            // jQuery("#email_error").html("Invalid token.");
        }
        else if(result=='send_otp_email_data_empty'){
            jQuery(".resend_otp_for_email").html("[Resend Code]");
            jQuery(".resend_otp_for_email").css("pointer-events", "");
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#email_error").html("Please enter your email address.");
        }
        else if(result=='invalid_type'){
            jQuery(".resend_otp_for_email").html("[Resend Code]");
            jQuery(".resend_otp_for_email").css("pointer-events", "");
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#email_error").html("Invalid type.");
        }
        else if(result=='invalid_email_address'){
            jQuery(".resend_otp_for_email").html("[Resend Code]");
            jQuery(".resend_otp_for_email").css("pointer-events", "");
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#email_error").html("Invalid email address.");
        }
        else if(result=='done'){
            jQuery(".resend_otp_for_email").html("[Resend Code]");
            jQuery(".resend_otp_for_email").css("pointer-events", "");
            // jQuery("#field_error_alert_email_send_otp").hide();
        }
        else if(result=='email_present'){
            jQuery(".resend_otp_for_email").html("[Resend Code]");
            jQuery(".resend_otp_for_email").css("pointer-events", "");
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#email_error").html("Email id already exists.");
        }
        else{
            jQuery(".resend_otp_for_email").html("[Resend Code]");
            jQuery(".resend_otp_for_email").css("pointer-events", "");
            // jQuery("#field_error_alert_email_send_otp").html("Error occured. Please try again after sometime.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#email_error").html("Error occured. Please try again after sometime.");
        }
        }
        });

    }

}

// Email Verification
function email_verify_otp(){
    jQuery("#email_otp_error").html("");
    jQuery(".email_otp_result").html("");
    var email_and_mobile_verification_form_token = jQuery("#email_and_mobile_verification_form_token").val();
    var email_otp = jQuery("#email_otp").val();
    if(email_otp==''){
        // jQuery("#field_error_alert_email_verify_otp").html("Please enter OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
        jQuery("#email_otp_error").html("Please enter OTP.");
    }
    else{
        jQuery.ajax({
            url: 'verify_otp.php',
            type: 'post',
            data: 'email_and_mobile_verification_form_token='+email_and_mobile_verification_form_token+ '&otp='+email_otp+ '&type=email',
            success: function(result){
            if(result=='Error: Multiple tabs are open/token expired/invalid token'){
                alert("Error: Multiple tabs are open/token expired/invalid token");
                window.location.href = "index.php";
                // jQuery("#email_otp_error").html("Invalid token.");
            }
            else if(result=='verify_otp_data_empty'){
                jQuery("#email_otp_error").html("Please enter OTP.");
            }
            else if(result=='invalid_type'){
                jQuery("#email_otp_error").html("Invalid type.");
            }
            else if(result=='verified'){
                jQuery(".email_verify_otp").hide();
                jQuery(".resend_otp_for_email").hide();
                jQuery(".email_verify_otp_div").hide();
                // jQuery("#field_error_alert_email_verify_otp").hide();
                // jQuery("#field_verified_alert_email_verify_otp").show();
                // jQuery("#field_verified_alert_email_verify_otp").html("Email address is verified.").addClass("alert-success").css({"padding": "1rem 1.5rem", "margin": "1rem 0"});
                jQuery('#email').attr('disabled', true);
                jQuery(".email_otp_result").html("Email address is verified.");
                jQuery("#is_email_verified").val("1");
                if(jQuery("#is_mobile_verified").val()==1){
                    jQuery(".btn_register").attr('disabled', false);
                }
            }
            else if(result=='not_verified'){
                // jQuery("#field_error_alert_email_verify_otp").html("Please enter valid OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
                jQuery("#email_otp_error").html("Please enter valid OTP.");
            }
            }
            });

    }

}



// Mobile Verification
function mobile_send_otp(){
    jQuery("#mobile_error").html("");
    var email_and_mobile_verification_form_token = jQuery("#email_and_mobile_verification_form_token").val();
    var mobile = jQuery("#mobile").val();
    if(mobile==''){
        // jQuery("#field_error_alert_mobile_send_otp").html("Please enter your mobile number.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
        jQuery("#mobile_error").html("Please enter your mobile number.");
    }
    else{
        jQuery(".mobile_send_otp span").html("Please Wait...");
        jQuery(".mobile_send_otp").attr('disabled', true);
        jQuery.ajax({
        url: 'send_otp.php',
        type: 'post',
        data: 'email_and_mobile_verification_form_token='+email_and_mobile_verification_form_token+ '&mobile='+mobile+ '&type=mobile',
        success: function(result){
        if(result=='Error: Multiple tabs are open/token expired/invalid token'){
            alert("Error: Multiple tabs are open/token expired/invalid token");
            window.location.href = "index.php";
            // jQuery(".mobile_send_otp span").html("REQUEST OTP");
            // jQuery(".mobile_send_otp").attr('disabled', false);
            // // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            // jQuery("#mobile_error").html("Invalid token.");
        }
        else if(result=='send_otp_mobile_data_empty'){
            jQuery(".mobile_send_otp span").html("REQUEST OTP");
            jQuery(".mobile_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#mobile_error").html("Please enter your mobile number.");
        }
        else if(result=='invalid_type'){
            jQuery(".mobile_send_otp span").html("REQUEST OTP");
            jQuery(".mobile_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#mobile_error").html("Invalid type.");
        }
        else if(result=='invalid_mobile_number'){
            jQuery(".mobile_send_otp span").html("REQUEST OTP");
            jQuery(".mobile_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#mobile_error").html("Invalid mobile number.");
        }
        else if(result=='done'){
            jQuery('#mobile').attr('disabled', true);
            jQuery(".mobile_verify_otp").show();
            jQuery(".resend_otp_for_mobile").show();
            jQuery(".mobile_verify_otp_div").show();
            jQuery(".mobile_send_otp").hide();
            // jQuery("#field_error_alert_mobile_send_otp").hide();
        }
        else if(result=='mobile_present'){
            jQuery(".mobile_send_otp span").html("REQUEST OTP");
            jQuery(".mobile_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#mobile_error").html("Mobile number already exists.");
        }
        else{
            jQuery(".mobile_send_otp span").html("REQUEST OTP");
            jQuery(".mobile_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_mobile_send_otp").html("Error occured. Please try again after sometime.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#mobile_error").html("Error occured. Please try again after sometime.");
        }
        }
        });

    }

}

// Mobile Verification
function mobile_resend_otp(){
    jQuery("#mobile_error").html("");
    var email_and_mobile_verification_form_token = jQuery("#email_and_mobile_verification_form_token").val();
    var mobile = jQuery("#mobile").val();
    if(mobile==''){
        // jQuery("#field_error_alert_mobile_send_otp").html("Please enter your mobile number.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
        jQuery("#mobile_error").html("Please enter your mobile number.");
    }
    else{
        jQuery(".resend_otp_for_mobile").html("[Please Wait...]");
        jQuery(".resend_otp_for_mobile").css("pointer-events", "none");
        jQuery.ajax({
        url: 'send_otp.php',
        type: 'post',
        data: 'email_and_mobile_verification_form_token='+email_and_mobile_verification_form_token+ '&mobile='+mobile+ '&type=mobile',
        success: function(result){
        if(result=='Error: Multiple tabs are open/token expired/invalid token'){
            alert("Error: Multiple tabs are open/token expired/invalid token");
            window.location.href = "index.php";
            // jQuery(".resend_otp_for_mobile").html("[Resend Code]");
            // jQuery(".resend_otp_for_mobile").css("pointer-events", "");
            // // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            // jQuery("#mobile_error").html("Invalid token.");
        }
        else if(result=='send_otp_mobile_data_empty'){
            jQuery(".resend_otp_for_mobile").html("[Resend Code]");
            jQuery(".resend_otp_for_mobile").css("pointer-events", "");
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#mobile_error").html("Please enter your mobile number.");
        }
        else if(result=='invalid_type'){
            jQuery(".resend_otp_for_mobile").html("[Resend Code]");
            jQuery(".resend_otp_for_mobile").css("pointer-events", "");
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#mobile_error").html("Invalid type.");
        }
        else if(result=='invalid_mobile_number'){
            jQuery(".resend_otp_for_mobile").html("[Resend Code]");
            jQuery(".resend_otp_for_mobile").css("pointer-events", "");
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#mobile_error").html("Invalid mobile number.");
        }
        else if(result=='done'){
            jQuery(".resend_otp_for_mobile").html("[Resend Code]");
            jQuery(".resend_otp_for_mobile").css("pointer-events", "");
            // jQuery("#field_error_alert_mobile_send_otp").hide();
        }
        else if(result=='mobile_present'){
            jQuery(".resend_otp_for_mobile").html("[Resend Code]");
            jQuery(".resend_otp_for_mobile").css("pointer-events", "");
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#mobile_error").html("Mobile number already exists.");
        }
        else{
            jQuery(".resend_otp_for_mobile").html("[Resend Code]");
            jQuery(".resend_otp_for_mobile").css("pointer-events", "");
            // jQuery("#field_error_alert_mobile_send_otp").html("Error occured. Please try again after sometime.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#mobile_error").html("Error occured. Please try again after sometime.");
        }
        }
        });

    }

}

// Mobile Verification
function mobile_verify_otp(){
    jQuery("#mobile_otp_error").html("");
    jQuery(".mobile_otp_result").html("");
    var email_and_mobile_verification_form_token = jQuery("#email_and_mobile_verification_form_token").val();
    var mobile_otp = jQuery("#mobile_otp").val();
    if(mobile_otp==''){
        // jQuery("#field_error_alert_mobile_verify_otp").html("Please enter OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
        jQuery("#mobile_otp_error").html("Please enter OTP.");
    }
    else{
        jQuery.ajax({
            url: 'verify_otp.php',
            type: 'post',
            data: 'email_and_mobile_verification_form_token='+email_and_mobile_verification_form_token+ '&otp='+mobile_otp+ '&type=mobile',
            success: function(result){
            if(result=='Error: Multiple tabs are open/token expired/invalid token'){
                alert("Error: Multiple tabs are open/token expired/invalid token");
                window.location.href = "index.php";
                // jQuery("#mobile_otp_error").html("Invalid token.");
            }
            else if(result=='verify_otp_data_empty'){
                jQuery("#mobile_otp_error").html("Please enter OTP.");
            }
            else if(result=='invalid_type'){
                jQuery("#mobile_otp_error").html("Invalid type.");
            }
            else if(result=='verified'){
                jQuery(".mobile_verify_otp").hide();
                jQuery(".resend_otp_for_mobile").hide();
                jQuery(".mobile_verify_otp_div").hide();
                // jQuery("#field_error_alert_mobile_verify_otp").hide();
                // jQuery("#field_verified_alert_mobile_verify_otp").show();
                // jQuery("#field_verified_alert_mobile_verify_otp").html("Mobile number is verified.").addClass("alert-success").css({"padding": "1rem 1.5rem", "margin": "1rem 0"});
                jQuery('#mobile').attr('disabled', true);
                jQuery(".mobile_otp_result").html("Mobile number is verified.");
                jQuery("#is_mobile_verified").val("1");
                if(jQuery("#is_email_verified").val()==1){
                    jQuery(".btn_register").attr('disabled', false);
                }
            }
            else if(result=='not_verified'){
                // jQuery("#field_error_alert_mobile_verify_otp").html("Please enter valid OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
                jQuery("#mobile_otp_error").html("Please enter valid OTP.");
            }
            }
            });

    }

}

//Sort product in categories page
function sort_product_drop(cat_id, site_path){
var sort_product_id = jQuery("#sort_product_id").val();
window.location.href = site_path+"categories.php?id="+cat_id+"&sort="+sort_product_id;
}

//Sort product in all products page
function sort_all_products_drop(site_path){
    var sort_product_id = jQuery("#sort_product_id").val();
    window.location.href = site_path+"all_products.php?sort="+sort_product_id;
}

//Sort product in search page
function sort_search_products_drop(str, site_path){
    var sort_product_id = jQuery("#sort_product_id").val();
    window.location.href = site_path+"search.php?str="+str+"&sort="+sort_product_id;
}

function send_career_application(){
    jQuery(".field_error").html("");
    var career_form_token = jQuery("#career_form_token").val();
    var post_name = jQuery("#post_name").val();
    var name = jQuery("#name").val();
    var email = jQuery("#email").val();
    var mobile = jQuery("#mobile").val();
    var address = jQuery("#address").val();
    var pincode = jQuery("#pincode").val();
    var state = jQuery("#state").val();
    var gender = jQuery("#gender").val();
    var resume = jQuery("#resume").val();
    var is_error = '';
    
    if(post_name==''){
        jQuery("#field_final_alert_in_career").hide();
        jQuery("#post_name_error").html("Please enter the post name you are applying for.");
        is_error = "yes";
    }
    if(name==''){
        jQuery("#field_final_alert_in_career").hide();
        jQuery("#name_error").html("Please enter your name.");
        is_error = "yes";
    }
    if(email==''){
        jQuery("#field_final_alert_in_career").hide();
        jQuery("#field_final_alert_in_career").hide();
        jQuery("#email_error").html("Please enter your email address.");
        is_error = "yes";
    }
    if(mobile==''){
        jQuery("#field_final_alert_in_career").hide();
        jQuery("#mobile_error").html("Please enter your mobile number.");
        is_error = "yes";
    }
    if(address==''){
        jQuery("#field_final_alert_in_career").hide();
        jQuery("#address_error").html("Please write your proper address.");
        is_error = "yes";
    }
    if(pincode==''){
        jQuery("#field_final_alert_in_career").hide();
        jQuery("#pincode_error").html("Please enter your pincode.");
        is_error = "yes";
    }
    if(state==''){
        jQuery("#field_final_alert_in_career").hide();
        jQuery("#state_error").html("Please write your state name.");
        is_error = "yes";
    }
    if(gender==''){
        jQuery("#field_final_alert_in_career").hide();
        jQuery("#gender_error").html("Please specify your gender.");
        is_error = "yes";
    }
    if(resume==''){
        jQuery("#field_final_alert_in_career").hide();
        jQuery("#resume_error").html("Please upload your updated resume.");
        is_error = "yes";
    }
    if(is_error==''){
        var data = new FormData();
        data.append("career_form_token", career_form_token);
        var resume1 = $("#resume")[0].files;
        data.append("resume", resume1[0]);
        data.append("post_name", post_name);
        data.append("name",name);
        data.append("email", email);
        data.append("mobile", mobile);
        data.append("address", address);
        data.append("pincode", pincode);
        data.append("state", state);
        data.append("gender", gender);
        // console.log(data);
        jQuery.ajax({
            type: 'post',
            url: 'career_application.php',
            contentType: false,
            processData: false,
            data: data,
            success: function(result){
            if(result=='Error: Multiple tabs are open/token expired/invalid token'){
                alert("Error: Multiple tabs are open/token expired/invalid token");
                window.location.href = "index.php";
                // jQuery("#field_final_alert_in_career").show();
                // jQuery("#field_final_alert_in_career").html("Invalid token.").addClass("alert-danger").css("padding", "1rem 1.5rem");
            }
            else if(result=='career_application_data_empty'){
                jQuery("#field_final_alert_in_career").show();
                jQuery("#field_final_alert_in_career").html("Please fillup all the required details.").addClass("alert-danger").css("padding", "1rem 1.5rem");
            }
            else if(result=='invalid_post_name'){
                jQuery("#field_final_alert_in_career").hide();
                jQuery("#post_name_error").html("Invalid post name.");
            }
            else if(result=='invalid_name'){
                jQuery("#field_final_alert_in_career").hide();
                jQuery("#name_error").html("Invalid name.");
            }
            else if(result=='invalid_email_address'){
                jQuery("#field_final_alert_in_career").hide();
                jQuery("#email_error").html("Invalid email address.");
            }
            else if(result=='invalid_mobile_number'){
                jQuery("#field_final_alert_in_career").hide();
                jQuery("#mobile_error").html("Invalid mobile number.");
            }
                else if(result=='address_length_insufficient'){
                jQuery("#field_final_alert_in_career").hide();
                jQuery("#address_error").html("Address details insufficient.");
            }
            else if(result=='invalid_pincode'){
                jQuery("#field_final_alert_in_career").hide();
                jQuery("#pincode_error").html("Invalid pincode.");
            }
            else if(result=='invalid_state_name'){
                jQuery("#field_final_alert_in_career").hide();
                jQuery("#state_error").html("State name not matching with pincode.");
            }
            else if(result=='submitted'){
                jQuery("#field_final_alert_in_career").show();
                jQuery("#field_final_alert_in_career").html("Your application has been submitted successfully. We will get back to you soon.").removeClass("alert-danger").addClass("alert-success").css("padding", "1rem 1.5rem");
                jQuery("#career_application_form")[0].reset();
            }
            else if(result=='resume_size_error'){
                jQuery("#field_final_alert_in_career").hide();
                jQuery("#resume_error").html("Please upload resume of size less than 8MB.");
            }
            else if(result=='resume_type_error'){
                jQuery("#field_final_alert_in_career").hide();
                jQuery("#resume_error").html("Please upload only pdf or docx type resume.");
            }

            else if(result=='invalid_gender_error'){
                jQuery("#field_final_alert_in_career").hide();
                jQuery("#gender_error").html("Invalid gender option.");
            }
            // else{
            //     jQuery("#field_final_alert_in_career").html("Something went wrong. Please try again later.").addClass("alert-danger");
            //     jQuery("#career_application_form")[0].reset();
            // }
            }
        });
    }
}

function send_password_reset_link(){
    jQuery(".field_error").html("");
    var send_password_reset_link_form_token = jQuery("#send_password_reset_link_form_token").val();
    var email = jQuery("#email").val();
    var is_error = '';
    if(email==''){
        jQuery("#field_final_alert_in_recover_password").hide();
        // jQuery("#field_error_alert_email_in_recover_password").show();
        // jQuery("#field_error_alert_email_in_recover_password").html("Please enter your email address.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin-bottom": "0.7rem"});
        jQuery("#reset_email_error").html("Please enter your email address.");
        is_error = "yes";
    }
    if(is_error==''){
        jQuery(".reset_password_link span").html("Please Wait...");
        jQuery(".reset_password_link").attr('disabled', true);
        jQuery.ajax({
        url: 'send_password_reset_link_submit.php',
        type: 'post',
        data: 'send_password_reset_link_form_token='+send_password_reset_link_form_token+ '&email='+email,
        success: function(result){
            if(result=='Error: Multiple tabs are open/token expired/invalid token'){
                alert("Error: Multiple tabs are open/token expired/invalid token");
                window.location.href = "index.php";
                // jQuery(".reset_password_link").html("SEND PASSWORD RESET LINK");
                // jQuery(".reset_password_link").attr('disabled', false);
                // jQuery("#field_final_alert_in_recover_password").show();
                // jQuery("#field_final_alert_in_recover_password").html("Invalid token.").addClass("alert-danger").css({"padding": "1rem 1.5rem"});
            }
            else if(result=='password_reset_link_data_empty'){
                // jQuery(".reset_password_link").html("SEND PASSWORD RESET LINK");
                // jQuery(".reset_password_link").attr('disabled', false);
                jQuery("#field_final_alert_in_recover_password").show();
                jQuery("#field_final_alert_in_recover_password").html("Please enter your email address.").addClass("alert-danger").css({"padding": "1rem 1.5rem"});
            }
            else if(result=='invalid_email_address'){
                jQuery(".reset_password_link span").html("SEND PASSWORD RESET LINK");
                jQuery(".reset_password_link").attr('disabled', false);
                // jQuery("#field_final_alert_in_recover_password").show();
                jQuery("#field_final_alert_in_recover_password").hide();
                // jQuery("#field_final_alert_in_recover_password").html("Email address doesnot exist.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin-bottom": "0.7rem"});
                jQuery("#reset_email_error").html("Invalid email address.");
                // jQuery("#field_final_alert_email_in_recover_password").hide();
            }
            else if(result=='password_reset_mailed'){
                jQuery(".reset_password_link span").html("SEND PASSWORD RESET LINK");
                jQuery(".reset_password_link").attr('disabled', false);
                jQuery("#field_final_alert_in_recover_password").show();
                jQuery("#field_final_alert_in_recover_password").html("Please check your email for password reset link.").removeClass("alert-danger").addClass("alert-success").css({"padding": "1rem 1.5rem"});
                // jQuery(".reset_msg p").html("Please check your email for password reset link");
                // jQuery("#field_error_alert_email_in_recover_password").hide();
            }
            else if(result=='password_reset_not_mailed'){
                jQuery(".reset_password_link span").html("SEND PASSWORD RESET LINK");
                jQuery(".reset_password_link").attr('disabled', false);
                // jQuery("#field_final_alert_in_recover_password").show();
                jQuery("#field_final_alert_in_recover_password").hide();
                // jQuery("#field_final_alert_in_recover_password").html("Email address doesnot exist.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin-bottom": "0.7rem"});
                jQuery("#reset_email_error").html("Email address doesnot exist.");
                // jQuery("#field_final_alert_email_in_recover_password").hide();
            }
            else{
                jQuery(".reset_password_link span").html("SEND PASSWORD RESET LINK");
                // jQuery(".reset_password_link").html("SEND PASSWORD RESET LINK");
                jQuery(".reset_password_link").attr('disabled', false);
                // jQuery("#field_final_alert_in_recover_password").show();
                 jQuery("#field_final_alert_in_recover_password").hide();
                // jQuery("#field_final_alert_in_recover_password").html("Error occured. Please try again after sometime.").addClass("alert-danger").css({"padding": "1rem 1.5rem"});
                jQuery("#reset_email_error").html("Error occured. Please try again after sometime.");
                // jQuery("#field_final_alert_email_in_recover_password").hide();
            }
        }
        })
    }
}

function reset_password(){
    jQuery(".field_error").html("");
    var reset_password_form_token = jQuery("#reset_password_form_token").val();
    var new_password = jQuery("#new_password").val();
    var confirm_password = jQuery("#confirm_password").val();
    var token = jQuery("#token").val();
    var is_error = '';
    if(new_password==''){
        jQuery("#field_final_alert_in_reset_password").hide();
        jQuery("#new_password_error").html("Please enter new password.");
        is_error = "yes";
    }
    if(confirm_password==''){
        jQuery("#field_final_alert_in_reset_password").hide();
        jQuery("#confirm_password_error").html("Please confirm the password again.");
        is_error = "yes";
    }
    if(is_error==''){
        jQuery.ajax({
            url: 'reset_password_submit.php',
            type: 'post',
            data: 'reset_password_form_token='+reset_password_form_token+ '&new_password='+new_password+ '&confirm_password='+confirm_password+ '&token='+token,
            success: function(result){
                if(result=='Error: Multiple tabs are open/token expired/invalid token'){
                    alert("Error: Multiple tabs are open/token expired/invalid token");
                    window.location.href = "index.php";
                    // jQuery("#field_final_alert_in_reset_password").show();
                    // jQuery("#field_final_alert_in_reset_password").html("Invalid token.").addClass("alert-danger").css({"padding": "1rem 1.5rem"});
                }
                else if(result=='change_password_submit_data_empty'){
                    // jQuery("#field_final_alert_in_reset_password").show();
                    // jQuery("#field_final_alert_in_reset_password").html("Please enter new password and confirm password.").addClass("alert-danger").css({"padding": "1rem 1.5rem"});
                    jQuery("#field_final_alert_in_reset_password").hide();
                    jQuery("#confirm_password_error").html("Please enter new password and confirm password.");
                }
                else if(result=='invalid_password_pattern'){
                    // jQuery("#field_final_alert_in_reset_password").show();
                    // jQuery("#field_final_alert_in_reset_password").html("Passwords are not matching.").addClass("alert-danger").css({"padding": "1rem 1.5rem"});
                    // jQuery(".change_msg p").html("Passwords are not matching").css("color", "red");
                    jQuery("#field_final_alert_in_reset_password").hide();
                    jQuery("#confirm_password_error").html("Password must be at least 6 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.");
                }
                else if(result=='new_password_and_confirm_password_not_matching'){
                    // jQuery("#field_final_alert_in_reset_password").show();
                    // jQuery("#field_final_alert_in_reset_password").html("Passwords are not matching.").addClass("alert-danger").css({"padding": "1rem 1.5rem"});
                    // jQuery(".change_msg p").html("Passwords are not matching").css("color", "red");
                    jQuery("#field_final_alert_in_reset_password").hide();
                    jQuery("#confirm_password_error").html("Please enter same password.");
                }
                else if(result=='invalid_token_or_token_expired'){
                    jQuery("#field_final_alert_in_reset_password").show();
                    jQuery("#field_final_alert_in_reset_password").html("Invalid token or token expired.<br><p class='invalid_token_go_to_link_p_tag'>Go to&nbsp;<a href='forgot_password.php' class='forgot-link invalid_token_forgot_your_password'>Forgot Your Password?</a>&nbsp;to reset your password.</p>").addClass("alert-danger").css({"padding": "1rem 1.5rem"});
                }
                else if(result=='matching'){
                    jQuery("#field_final_alert_in_reset_password").show();
                    var a = (function() {
                        var i = 0;
                        var interval = setInterval(function() {
                        i = i + 1;
                        var counter = 6 - i;
                        jQuery("#field_final_alert_in_reset_password").html("Password has been reset successfully. You will be redirected to login page after: "+ counter+".").removeClass("alert-danger").addClass("alert-success").css({"padding": "1rem 1.5rem"});
                        // jQuery(".change_msg p").html("Password has been reset successfully").css("color", "#53ad44");
                        jQuery("#reset_password_form")[0].reset();
                        if (counter === 0) {
                          clearInterval(interval);
                          window.location.href = "login.php";
                        }
                      }, 1000);
                    })();
                    a();
                }
            }
            })
    }
}

//Update Profile
// function update_profile(){
//     jQuery(".field_error").html("");
//     var name = jQuery("#name").val();
//     var is_error = '';
//     if(name==''){
//         jQuery('#field_final_alert_in_profile_name').hide();
//         jQuery("#name_error").html("Please enter your name.");
//         is_error = "yes";
//     }
//     if(is_error==''){
//         jQuery.ajax({
//         url: 'update_profile.php',
//         type: 'post',
//         data: 'name='+name,
//         success: function(result){
//             if(result=='update_profile_data_empty'){
//                 jQuery('#field_final_alert_in_profile_name').show();
//                 jQuery('#field_final_alert_in_profile_name').html("Please enter your name.").addClass("alert-danger").css({"padding": "1rem 1.5rem"});
//             }
//             else if(result=='profile_updated'){
//                 jQuery('#field_final_alert_in_profile_name').show();
//                 jQuery('#field_final_alert_in_profile_name').html("Profile has been updated successfully.").removeClass("alert-danger").addClass("alert-success").css({"padding": "1rem 1.5rem"});
//             }
//         }
//         });

//     }

// }

//Update Password
function update_password(){
    jQuery(".field_error").html("");
    var edit_profile_form_token = jQuery("#edit_profile_form_token").val();
    var current_password = jQuery("#current_password").val();
    var new_password = jQuery("#new_password").val();
    var confirm_password = jQuery("#confirm_password").val();
    var is_error = '';
    if(current_password==''){
        // jQuery('#field_final_alert_in_profile_password').hide();
        jQuery("#current_password_error").html("Please enter current password.");
        is_error = "yes";
    }
    if(new_password==''){
        // jQuery('#field_final_alert_in_profile_password').hide();
        jQuery("#new_password_error").html("Please enter new password.");
        is_error = "yes";
    }
    if(confirm_password==''){
        // jQuery('#field_final_alert_in_profile_password').hide();
        jQuery("#confirm_password_error").html("Please enter new password again.");
        is_error = "yes";
    }
    if(is_error==''){
        jQuery.ajax({
        url: 'update_password.php',
        type: 'post',
        data: 'edit_profile_form_token='+edit_profile_form_token+ '&current_password='+current_password+ '&new_password='+new_password+ '&confirm_password='+confirm_password,
        success: function(result){
            if(result=='Error: Multiple tabs are open/token expired/invalid token'){
                alert("Error: Multiple tabs are open/token expired/invalid token");
                window.location.href = "index.php";
                // jQuery('#field_final_alert_in_profile_password').show();
                // jQuery('#confirm_password_error').html("Invalid token.");
            }
            else if(result=='update_password_date_empty'){
                // jQuery('#field_final_alert_in_profile_password').show();
                jQuery('#confirm_password_error').html("Please enter current password, new password and confirm password.");
            }
            else if(result=='invalid_password_pattern'){
                // jQuery('#field_final_alert_in_profile_password').hide();
                jQuery("#confirm_password_error").html("Password must be at least 6 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.");
            }
            else if(result=='invalid_current_password'){
                // jQuery('#field_final_alert_in_profile_password').hide();
                jQuery("#current_password_error").html("Invalid current password.");
                // jQuery('.update_password_success').html("Invalid current password").css("color", "red");
            }
            else if(result=='new_password_and_confirm_password_not_matching'){
                // jQuery('#field_final_alert_in_profile_password').hide();
                jQuery("#confirm_password_error").html("Please enter same password.");
            }
            else if(result=='password_updated'){
                window.location.href = window.location.href;
                // jQuery('#field_final_alert_in_profile_password').show();
                // jQuery('#field_final_alert_in_profile_password').html("Password has been changed successfully.").removeClass("alert-danger").addClass("alert-success").css("padding", "1rem 1.5rem");
                // jQuery("#profiles_change_password_form")[0].reset();
            }
        }
        });

    }

}

function gst_pan_card_check(that){
    if(that.value=='GST'){
        document.getElementsByName("gst_pan_card_number")[0].placeholder= "Enter GST Number";
    }
    if(that.value=='Pan Card'){
        document.getElementsByName("gst_pan_card_number")[0].placeholder= "Enter Pan Card Number";
    }
    if(that.value==''){
        document.getElementsByName("gst_pan_card_number")[0].placeholder= "";
    }
}

function license_check(that){
    if(that.value=='FSSAI License'){
        document.getElementsByName("license_number")[0].placeholder= "Enter FSSAI License Number";
    }
    if(that.value=='Trade License'){
        document.getElementsByName("license_number")[0].placeholder= "Enter Trade License Number";
    }
    if(that.value=='Other License'){
        document.getElementsByName("license_number")[0].placeholder= "Enter License Name and Number";
    }
    if(that.value==''){
        document.getElementsByName("license_number")[0].placeholder= "";
    }
}

function request_partner_with_us(){
    jQuery(".field_error").html("");
    var partner_with_us_form_token = jQuery("#partner_with_us_form_token").val();
    var name = jQuery("#name").val();
    var email = jQuery("#email").val();
    var mobile = jQuery("#mobile").val();
    var address = jQuery("#address").val();
    var pincode = jQuery("#pincode").val();
    var state = jQuery("#state").val();
    var gst_pan_card = jQuery("#gst_pan_card").val();
    var gst_pan_card_number = jQuery("#gst_pan_card_number").val();
    var license = jQuery("#license").val();
    var license_number = jQuery("#license_number").val();
    var applied_for = jQuery("#applied_for").val();
    var referred_by = jQuery("#referred_by").val();
    var business_start_date = jQuery("#business_start_date").val();
    var declared = jQuery("#declared_checkbox").val();
    var is_error = '';
    
    if(name==''){
        jQuery("#field_final_alert_in_partner_with_us").hide();
        jQuery("#name_error").html("Please enter name.");
        is_error = "yes";
    }
    if(email==''){
        jQuery("#field_final_alert_in_partner_with_us").hide();
        jQuery("#email_error").html("Please enter email address.");
        is_error = "yes";
    }
    if(mobile==''){
        jQuery("#field_final_alert_in_partner_with_us").hide();
        jQuery("#mobile_error").html("Please enter mobile number.");
        is_error = "yes";
    }
    if(address==''){
        jQuery("#field_final_alert_in_partner_with_us").hide();
        jQuery("#address_error").html("Please enter proper address.");
        is_error = "yes";
    }
    if(pincode==''){
        jQuery("#field_final_alert_in_partner_with_us").hide();
        jQuery("#pincode_error").html("Please enter pincode.");
        is_error = "yes";
    }
    if(state==''){
        jQuery("#field_final_alert_in_partner_with_us").hide();
        jQuery("#state_error").html("Please enter state name.");
        is_error = "yes";
    }
    if(gst_pan_card==''){
        jQuery("#field_final_alert_in_partner_with_us").hide();
        jQuery("#gst_pan_card_error").html("Please choose any one option.");
        is_error = "yes";
    }
    if(gst_pan_card_number==''){
        jQuery("#field_final_alert_in_partner_with_us").hide();
        jQuery("#gst_pan_card_number_error").html("Please enter GST / Pan Card number.");
        is_error = "yes";
    }
    if(license==''){
        jQuery("#field_final_alert_in_partner_with_us").hide();
        jQuery("#license_error").html("Please choose any one option.");
        is_error = "yes";
    }
    if(license_number==''){
        jQuery("#field_final_alert_in_partner_with_us").hide();
        jQuery("#license_number_error").html("Please enter License number.");
        is_error = "yes";
    }
    if(applied_for==''){
        jQuery("#field_final_alert_in_partner_with_us").hide();
        jQuery("#applied_for_error").html("Please choose any one option.");
        is_error = "yes";
    }
    if(referred_by==''){
        jQuery("#field_final_alert_in_partner_with_us").hide();
        jQuery("#referred_by_error").html("Please enter name who recommended us.");
        is_error = "yes";
    }
    if(business_start_date==''){
        jQuery("#field_final_alert_in_partner_with_us").hide();
        jQuery("#business_start_date_error").html("Please select a date.");
        is_error = "yes";
    }
    if(!document.getElementById('declared_checkbox').checked){
        jQuery("#field_final_alert_in_partner_with_us").hide();
        jQuery("#declaration_error").html("Please tick the declaration statement.");
        is_error = "yes";
    }
    if(is_error==''){
        jQuery.ajax({
            url: 'request_partner_with_us.php',
            type: 'post',
            data: 'partner_with_us_form_token='+partner_with_us_form_token+ '&name='+name+ '&email='+email+ '&mobile='+mobile+ '&address='+address+ '&pincode='+pincode+ '&state='+state+ '&gst_pan_card='+gst_pan_card+ '&gst_pan_card_number='+gst_pan_card_number+ '&license='+license+ '&license_number='+license_number+ '&applied_for='+applied_for+ '&referred_by='+referred_by+ '&business_start_date='+business_start_date+ '&declared='+declared,
            success: function(result){
                if(result=='Error: Multiple tabs are open/token expired/invalid token'){
                    alert("Error: Multiple tabs are open/token expired/invalid token");
                    window.location.href = "index.php";
                    // jQuery("#field_final_alert_in_partner_with_us").show();
                    // jQuery("#field_final_alert_in_partner_with_us").html("Invalid token.").addClass("alert-danger").css("padding", "1rem 1.5rem");
                }
                else if(result=='partner_with_us_data_empty'){
                    jQuery("#field_final_alert_in_partner_with_us").show();
                    jQuery("#field_final_alert_in_partner_with_us").html("Please fillup all the required details.").addClass("alert-danger").css("padding", "1rem 1.5rem");
                }
                else if(result=='invalid_name'){
                    jQuery("#field_final_alert_in_partner_with_us").hide();
                    jQuery("#name_error").html("Invalid name.");
                }
                else if(result=='invalid_email_address'){
                    jQuery("#field_final_alert_in_partner_with_us").hide();
                    jQuery("#email_error").html("Invalid email address.");
                }
                else if(result=='invalid_mobile_number'){
                    jQuery("#field_final_alert_in_partner_with_us").hide();
                    jQuery("#mobile_error").html("Invalid mobile number.");
                }
                else if(result=='address_length_insufficient'){
                    jQuery("#field_final_alert_in_partner_with_us").hide();
                    jQuery("#address_error").html("Address details insufficient.");
                }
                else if(result=='invalid_pincode'){
                    jQuery("#field_final_alert_in_partner_with_us").hide();
                    jQuery("#pincode_error").html("Invalid pincode.");
                }
                else if(result=='invalid_state_name'){
                    jQuery("#field_final_alert_in_partner_with_us").hide();
                    jQuery("#state_error").html("State name not matching with pincode.");
                }
                else if(result=='invalid_referred_by_name'){
                    jQuery("#field_final_alert_in_partner_with_us").hide();
                    jQuery("#referred_by_error").html("Invalid name.");
                }
                else if(result=='invalid_date'){
                    jQuery("#field_final_alert_in_partner_with_us").hide();
                    jQuery("#business_start_date_error").html("Invalid date.");
                }
                else if(result=='declared_value_cannot_be_changed'){
                    jQuery("#field_final_alert_in_partner_with_us").hide();
                    jQuery("#declaration_error").html("Declared value cannot be changed.");
                }
                else if(result=='submitted'){
                    jQuery("#field_final_alert_in_partner_with_us").show();
                    jQuery("#field_final_alert_in_partner_with_us").html("Your partnership request has been submitted. We will get back to you soon.").removeClass("alert-danger").addClass("alert-success").css("padding", "1rem 1.5rem");
                    jQuery("#partnership_form")[0].reset();
                }

                else if(result=='invalid_gst_pan_card_error'){
                    jQuery("#field_final_alert_in_partner_with_us").hide();
                    jQuery("#gst_pan_card_error").html("Invalid GST / Pan Card option.");
                }
                else if(result=='invalid_license_error'){
                    jQuery("#field_final_alert_in_partner_with_us").hide();
                    jQuery("#license_error").html("Invalid license option.");
                }
                else if(result=='invalid_applied_for_error'){
                    jQuery("#field_final_alert_in_partner_with_us").hide();
                    jQuery("#applied_for_error").html("Invalid applied for option.");
                }
                // else{
                //     jQuery(".alert").html("Something went wrong. Please try again later.").addClass("alert-danger");
                //     jQuery("#partnership_form")[0].reset();
                // }
            }
        });
    }
}

//Autocomplete search(For large screen)
$(document).ready(function(){
    $("#q").keyup(function(){
    jQuery("#show-list").show();
    var searchText = $(this).val();
    if(searchText!=''){
    $.ajax({
        url: 'suggestion.php',
        method: 'post',
        data:{query: searchText},
        success: function(result){
        $("#show-list").html(result);
        }
    });
    }
    else{
        $("#show-list").html("");
    }
    })
    });

//Hide the autocomplete div when clicked outside autocomplete div(For large screen)
document.addEventListener('click', function clickOutside(event) {
let get = document.getElementById('show-list');
if (!get.contains(event.target)) {
get.style.display = "none";
}
});

//Show div when clicked on input search field(For large screen)
function showdiv(){
document.getElementById('show-list').style.display = "block";
}

//Autocomplete search(For mobile type screen)
$(document).ready(function(){
    $("#qr").keyup(function(){
    var searchText = $(this).val();
    if(searchText!=''){
    $.ajax({
        url: 'suggestion_for_mobile.php',
        method: 'post',
        data:{query: searchText},
        success: function(result){
        $("#show-list-mobile").html(result);
        }
    });
    }
    else{
        $("#show-list-mobile").html("");
    }
    })
    });

//Hide the autocomplete div when clicked outside autocomplete div(For mobile type screen)
function hide_mobile_suggestion_box(){
    $("#show-list-mobile").slideUp(0o0);
    $("#show-list-mobile").on('mousedown',  ev => ev.preventDefault());
}

//Show div when clicked on input search field(For mobile type screen)
function show_mobile_suggestion_box(){
    $("#show-list-mobile").slideDown(0o0);
    $("#show-list-mobile").on('mousedown',  ev => ev.preventDefault());
}

// Mobile Menu toggle children menu for category section
$('.category_click').on('click', function (e) {
    var $parent = $(this).closest('li'),
        $targetUl = $parent.find('ul').eq(0);

        if ( !$parent.hasClass('open') ) {
            $targetUl.slideDown(300, function () {
                $parent.addClass('open');
            });
        } else {
            $targetUl.slideUp(300, function () {
                $parent.removeClass('open');
            });
        }

    e.stopPropagation();
    e.preventDefault();
});

// Mobile Menu toggle children menu for account section
$('.account_click').on('click', function (e) {
    var $parent = $(this).closest('li'),
        $targetUl = $parent.find('ul').eq(0);

        if ( !$parent.hasClass('open') ) {
            $targetUl.slideDown(300, function () {
                $parent.addClass('open');
            });
        } else {
            $targetUl.slideUp(300, function () {
                $parent.removeClass('open');
            });
        }

    e.stopPropagation();
    e.preventDefault();
});

$('#notification_click').on("click",function(){
    var user_id = jQuery("#user_id").val();
    jQuery.ajax({
        url: 'notifications_seen.php',
        type: 'post',
        success: function(result){
            // if(result=='submitted'){
            //     jQuery(".request_partner_with_us_msg p").html("Your partnership request has been submitted. We will get back to you soon.").css("color", "#53ad44");
            //     jQuery("#partnership_form")[0].reset();
            // }
            // else{
            //     jQuery(".request_partner_with_us_msg p").html("Something went wrong. Please try again later.").css("color", "red");
            //     jQuery("#partnership_form")[0].reset();
            // }
        }
    });
  })

  $('#notification_click_mobile').on("click",function(){
    var user_id = jQuery("#user_id").val();
    jQuery.ajax({
        url: 'notifications_seen.php',
        type: 'post',
        data: 'user_id='+user_id,
        success: function(result){
            // if(result=='submitted'){
            //     jQuery(".request_partner_with_us_msg p").html("Your partnership request has been submitted. We will get back to you soon.").css("color", "#53ad44");
            //     jQuery("#partnership_form")[0].reset();
            // }
            // else{
            //     jQuery(".request_partner_with_us_msg p").html("Something went wrong. Please try again later.").css("color", "red");
            //     jQuery("#partnership_form")[0].reset();
            // }
        }
    });
  })

function check_pincode(){
    jQuery(".field_error").html("");
    jQuery("#state").val("");
    pincode = jQuery("#pincode").val();
    if(pincode==''){
        jQuery("#check_pincode_error").html("Please enter pincode.");
    }
    else{
        jQuery("#check_pincode_text").html("Please wait...");
        $.ajax({
            type: "post",
            url: "check_pincode.php",
            data: 'pincode='+pincode,
            success: function(result){
            if(result=='no_pincode_data_found'){
                jQuery("#check_pincode_text").html("Check pincode");
                jQuery("#check_pincode_error").html("Invalid pincode.");
            }
            else{
                jQuery("#state").val(result);
                jQuery("#check_pincode_text").html("Check pincode");
            }
            }
        });
    }
}

// New name
function update_new_name(){
    // jQuery(".field_error").html("");
    jQuery("#new_name_error").html("");
    var edit_profile_form_token = jQuery("#edit_profile_form_token").val();
    var new_name = jQuery("#new_name").val();
    var is_error = '';
    if(new_name==''){
        // jQuery('#field_final_alert_in_profile_name').hide();
        jQuery("#new_name_error").html("Please enter your name.");
        is_error = "yes";
    }
    if(is_error==''){
        jQuery.ajax({
        url: 'edit_profile_name.php',
        type: 'post',
        data: 'edit_profile_form_token='+edit_profile_form_token+ '&new_name='+new_name,
        success: function(result){
            if(result=='Error: Multiple tabs are open/token expired/invalid token'){
                alert("Error: Multiple tabs are open/token expired/invalid token");
                window.location.href = "index.php";
                // jQuery('#field_final_alert_in_profile_name').show();
                // jQuery('#new_name_error').html("Invalid token.");
            }
            else if(result=='edit_profile_name_data_empty'){
                // jQuery('#field_final_alert_in_profile_name').show();
                jQuery('#new_name_error').html("Please enter your name.");
            }
            else if(result=='invalid_name'){
                jQuery('#new_name_error').html("Please use letters only.");
            }
            else if(result=='current_name_present'){
                // jQuery('#new_name_error').html("Name already in use.");
                jQuery('#new_name_error').html("");
            }
            else if(result=='name_updated'){
                // jQuery('#field_final_alert_in_profile_name').show();
                // jQuery('#field_final_alert_in_profile_name').html("Profile has been updated successfully.").removeClass("alert-danger").addClass("alert-success").css({"padding": "1rem 1.5rem"});
                window.location.href = window.location.href;
            }
        }
        });

    }

}

// New email address verification
function new_email_send_otp(){
    jQuery("#new_email_error").html("");
    var edit_profile_form_token = jQuery("#edit_profile_form_token").val();
    var new_email = jQuery("#new_email").val();
    if(new_email==''){
        // jQuery("#field_error_alert_email_send_otp").html("Please enter your email address.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
        jQuery("#new_email_error").html("Please enter your email address.");
    }
    else{
        jQuery(".new_email_send_otp span").html("Please Wait...");
        jQuery(".new_email_send_otp").attr('disabled', true);
        jQuery.ajax({
        url: 'edit_profile_send_otp.php',
        type: 'post',
        data: 'edit_profile_form_token='+edit_profile_form_token+ '&new_email='+new_email+ '&type=email',
        success: function(result){
        if(result=='Error: Multiple tabs are open/token expired/invalid token'){
            alert("Error: Multiple tabs are open/token expired/invalid token");
            window.location.href = "index.php";
            // jQuery(".new_email_send_otp span").html("REQUEST OTP");
            // jQuery(".new_email_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            // jQuery("#new_email_error").html("Invalid token.");
        }
        else if(result=='edit_profile_send_otp_email_data_empty'){
            jQuery(".new_email_send_otp span").html("REQUEST OTP");
            jQuery(".new_email_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_email_error").html("Please enter your email address.");
        }
        else if(result=='invalid_type'){
            jQuery(".new_email_send_otp span").html("REQUEST OTP");
            jQuery(".new_email_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_email_error").html("Invalid type.");
        }
        else if(result=='invalid_email_address'){
            jQuery(".new_email_send_otp span").html("REQUEST OTP");
            jQuery(".new_email_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_email_error").html("Invalid email address.");
        }
        else if(result=='done'){
            jQuery('#new_email').attr('disabled', true);
            jQuery('#new_email').attr("style", "background-color: #f9f9f9 !important");
            jQuery(".new_email_verify_otp").show();
             jQuery(".resend_otp_for_new_email").show();
            jQuery(".new_email_verify_otp_div").show();
            jQuery(".new_email_send_otp").hide();
            // jQuery("#field_error_alert_email_send_otp").hide();
        }
        else if(result=='email_present'){
            jQuery(".new_email_send_otp span").html("REQUEST OTP");
            jQuery(".new_email_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_email_error").html("Email id already exists.");
        }
        else if(result=='current_email_present'){
            jQuery(".new_email_send_otp span").html("REQUEST OTP");
            jQuery(".new_email_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            // jQuery("#new_email_error").html("Email id already in use.");
            jQuery("#new_email_error").html("");
        }
        else{
            jQuery(".new_email_send_otp span").html("REQUEST OTP");
            jQuery(".new_email_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_email_send_otp").html("Error occured. Please try again after sometime.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_email_error").html("Error occured. Please try again after sometime.");
        }
        }
        });

    }

}

// New email address verification
function new_email_resend_otp(){
    jQuery("#new_email_error").html("");
    var edit_profile_form_token = jQuery("#edit_profile_form_token").val();
    var new_email = jQuery("#new_email").val();
    if(new_email==''){
        // jQuery("#field_error_alert_email_send_otp").html("Please enter your email address.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
        jQuery("#new_email_error").html("Please enter your email address.");
    }
    else{
        jQuery(".resend_otp_for_new_email").html("[Please Wait...]");
        jQuery(".resend_otp_for_new_email").css("pointer-events", "none");
        jQuery.ajax({
        url: 'edit_profile_send_otp.php',
        type: 'post',
        data: 'edit_profile_form_token='+edit_profile_form_token+ '&new_email='+new_email+ '&type=email',
        success: function(result){
        if(result=='Error: Multiple tabs are open/token expired/invalid token'){
            alert("Error: Multiple tabs are open/token expired/invalid token");
            window.location.href = "index.php";
            // jQuery(".resend_otp_for_new_email").html("[Resend Code]");
            // jQuery(".resend_otp_for_new_email").css("pointer-events", "");
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            // jQuery("#new_email_error").html("Invalid token.");
        }
        else if(result=='edit_profile_send_otp_email_data_empty'){
            jQuery(".resend_otp_for_new_email").html("[Resend Code]");
            jQuery(".resend_otp_for_new_email").css("pointer-events", "");
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_email_error").html("Please enter your email address.");
        }
        else if(result=='invalid_type'){
            jQuery(".resend_otp_for_new_email").html("[Resend Code]");
            jQuery(".resend_otp_for_new_email").css("pointer-events", "");
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_email_error").html("Invalid type.");
        }
        else if(result=='invalid_email_address'){
            jQuery(".resend_otp_for_new_email").html("[Resend Code]");
            jQuery(".resend_otp_for_new_email").css("pointer-events", "");
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_email_error").html("Invalid email address.");
        }
        else if(result=='done'){
            jQuery(".resend_otp_for_new_email").html("[Resend Code]");
            jQuery(".resend_otp_for_new_email").css("pointer-events", "");
            // jQuery("#field_error_alert_email_send_otp").hide();
        }
        else if(result=='email_present'){
            jQuery(".resend_otp_for_new_email").html("[Resend Code]");
            jQuery(".resend_otp_for_new_email").css("pointer-events", "");
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_email_error").html("Email id already exists.");
        }
        else if(result=='current_email_present'){
            jQuery(".resend_otp_for_new_email").html("[Resend Code]");
            jQuery(".resend_otp_for_new_email").css("pointer-events", "");
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            // jQuery("#new_email_error").html("Email id already in use.");
            jQuery("#new_email_error").html("");
        }
        else{
            jQuery(".resend_otp_for_new_email").html("[Resend Code]");
            jQuery(".resend_otp_for_new_email").css("pointer-events", "");
            // jQuery("#field_error_alert_email_send_otp").html("Error occured. Please try again after sometime.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_email_error").html("Error occured. Please try again after sometime.");
        }
        }
        });

    }

}

// New email address verification
function new_email_verify_otp(){
    jQuery("#new_email_otp_error").html("");
    // jQuery(".email_otp_result").html("");
    var edit_profile_form_token = jQuery("#edit_profile_form_token").val();
    var new_email_otp = jQuery("#new_email_otp").val();
    if(new_email_otp==''){
        // jQuery("#field_error_alert_email_verify_otp").html("Please enter OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
        jQuery("#new_email_otp_error").html("Please enter OTP.");
    }
    else{
        jQuery.ajax({
            url: 'edit_profile_verify_otp.php',
            type: 'post',
            data: 'edit_profile_form_token='+edit_profile_form_token+ '&otp='+new_email_otp+ '&type=email',
            success: function(result){
            if(result=='Error: Multiple tabs are open/token expired/invalid token'){
                alert("Error: Multiple tabs are open/token expired/invalid token");
                window.location.href = "index.php";
                // jQuery("#field_error_alert_email_verify_otp").html("Please enter valid OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
                // jQuery("#new_email_otp_error").html("Invalid token.");
            }
            else if(result=='edit_profile_verify_otp_data_empty'){
                // jQuery("#field_error_alert_email_verify_otp").html("Please enter valid OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
                jQuery("#new_email_otp_error").html("Please enter OTP.");
            }
            else if(result=='invalid_type'){
                // jQuery("#field_error_alert_email_verify_otp").html("Please enter valid OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
                jQuery("#new_email_otp_error").html("Invalid type.");
            }
            // else if(result=='otp_is_not_number'){
            //     // jQuery("#field_error_alert_email_verify_otp").html("Please enter valid OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            //     jQuery("#new_email_otp_error").html("Please enter numbers only.");
            // }
            else if(result=='verified'){
                // jQuery(".new_email_verify_otp").hide();
                // jQuery(".resend_otp_for_new_email").hide();
                // jQuery(".new_email_verify_otp_div").hide();
                // jQuery("#field_error_alert_email_verify_otp").hide();
                // jQuery("#field_verified_alert_email_verify_otp").show();
                // jQuery("#field_verified_alert_email_verify_otp").html("Email address is verified.").addClass("alert-success").css({"padding": "1rem 1.5rem", "margin": "1rem 0"});
                // jQuery(".email_otp_result").html("Email address is verified.");
                // jQuery("#is_email_verified").val("1");
                // if(jQuery("#is_mobile_verified").val()==1){
                //     jQuery(".btn_register").attr('disabled', false);
                // }
                window.location.href = window.location.href;
            }
            else if(result=='not_verified'){
                // jQuery("#field_error_alert_email_verify_otp").html("Please enter valid OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
                jQuery("#new_email_otp_error").html("Please enter valid OTP.");
            }
            }
            });

    }

}

// New mobile number verification
function new_mobile_send_otp(){
    jQuery("#new_mobile_error").html("");
    var edit_profile_form_token = jQuery("#edit_profile_form_token").val();
    var new_mobile = jQuery("#new_mobile").val();
    if(new_mobile==''){
        // jQuery("#field_error_alert_mobile_send_otp").html("Please enter your mobile number.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
        jQuery("#new_mobile_error").html("Please enter your mobile number.");
    }
    else{
        jQuery(".new_mobile_send_otp span").html("Please Wait...");
        jQuery(".new_mobile_send_otp").attr('disabled', true);
        jQuery.ajax({
        url: 'edit_profile_send_otp.php',
        type: 'post',
        data: 'edit_profile_form_token='+edit_profile_form_token+ '&new_mobile='+new_mobile+ '&type=mobile',
        success: function(result){
        if(result=='Error: Multiple tabs are open/token expired/invalid token'){
            alert("Error: Multiple tabs are open/token expired/invalid token");
            window.location.href = "index.php";
            // jQuery(".new_mobile_send_otp span").html("REQUEST OTP");
            // jQuery(".new_mobile_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            // jQuery("#new_mobile_error").html("Invalid token.");
        }
        else if(result=='edit_profile_send_otp_mobile_data_empty'){
            jQuery(".new_mobile_send_otp span").html("REQUEST OTP");
            jQuery(".new_mobile_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_mobile_error").html("Please enter your mobile number.");
        }
        else if(result=='invalid_type'){
            jQuery(".new_mobile_send_otp span").html("REQUEST OTP");
            jQuery(".new_mobile_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_mobile_error").html("Invalid type.");
        }
        else if(result=='invalid_mobile_number'){
            jQuery(".new_mobile_send_otp span").html("REQUEST OTP");
            jQuery(".new_mobile_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_mobile_error").html("Invalid mobile number.");
        }
        else if(result=='done'){
            jQuery('#new_mobile').attr('disabled', true);
            jQuery(".new_mobile_verify_otp").show();
            jQuery(".resend_otp_for_new_mobile").show();
            jQuery(".new_mobile_verify_otp_div").show();
            jQuery(".new_mobile_send_otp").hide();
            // jQuery("#field_error_alert_mobile_send_otp").hide();
        }
        else if(result=='mobile_present'){
            jQuery(".new_mobile_send_otp span").html("REQUEST OTP");
            jQuery(".new_mobile_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_mobile_error").html("Mobile number already exists.");
        }
        else if(result=='current_mobile_present'){
            jQuery(".new_mobile_send_otp span").html("REQUEST OTP");
            jQuery(".new_mobile_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_email_send_otp").html("Email id already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            // jQuery("#new_mobile_error").html("Mobile number already in use.");
            jQuery("#new_mobile_error").html("");
        }
        else{
            jQuery(".new_mobile_send_otp span").html("REQUEST OTP");
            jQuery(".new_mobile_send_otp").attr('disabled', false);
            // jQuery("#field_error_alert_mobile_send_otp").html("Error occured. Please try again after sometime.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_mobile_error").html("Error occured. Please try again after sometime.");
        }
        }
        });

    }

}

// New mobile number verification
function new_mobile_resend_otp(){
    jQuery("#new_mobile_error").html("");
    var edit_profile_form_token = jQuery("#edit_profile_form_token").val();
    var new_mobile = jQuery("#new_mobile").val();
    if(new_mobile==''){
        // jQuery("#field_error_alert_mobile_send_otp").html("Please enter your mobile number.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
        jQuery("#new_mobile_error").html("Please enter your mobile number.");
    }
    else{
        jQuery(".resend_otp_for_new_mobile").html("[Please Wait...]");
        jQuery(".resend_otp_for_new_mobile").css("pointer-events", "none");
        jQuery.ajax({
        url: 'edit_profile_send_otp.php',
        type: 'post',
        data: 'edit_profile_form_token='+edit_profile_form_token+ '&new_mobile='+new_mobile+ '&type=mobile',
        success: function(result){
        if(result=='Error: Multiple tabs are open/token expired/invalid token'){
            alert("Error: Multiple tabs are open/token expired/invalid token");
            window.location.href = "index.php";
            // jQuery(".resend_otp_for_new_mobile").html("[Resend Code]");
            // jQuery(".resend_otp_for_new_mobile").css("pointer-events", "");
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            // jQuery("#new_mobile_error").html("Invalid token.");
        }
        else if(result=='edit_profile_send_otp_mobile_data_empty'){
            jQuery(".resend_otp_for_new_mobile").html("[Resend Code]");
            jQuery(".resend_otp_for_new_mobile").css("pointer-events", "");
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_mobile_error").html("Please enter your mobile number.");
        }
        else if(result=='invalid_type'){
            jQuery(".resend_otp_for_new_mobile").html("[Resend Code]");
            jQuery(".resend_otp_for_new_mobile").css("pointer-events", "");
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_mobile_error").html("Invalid type.");
        }
        else if(result=='invalid_mobile_number'){
            jQuery(".resend_otp_for_new_mobile").html("[Resend Code]");
            jQuery(".resend_otp_for_new_mobile").css("pointer-events", "");
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_mobile_error").html("Invalid mobile number.");
        }
        else if(result=='done'){
            jQuery(".resend_otp_for_new_mobile").html("[Resend Code]");
            jQuery(".resend_otp_for_new_mobile").css("pointer-events", "");
            // jQuery("#field_error_alert_mobile_send_otp").hide();
        }
        else if(result=='mobile_present'){
            jQuery(".resend_otp_for_new_mobile").html("[Resend Code]");
            jQuery(".resend_otp_for_new_mobile").css("pointer-events", "");
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_mobile_error").html("Mobile number already exists.");
        }
        else if(result=='current_mobile_present'){
            jQuery(".resend_otp_for_new_mobile").html("[Resend Code]");
            jQuery(".resend_otp_for_new_mobile").css("pointer-events", "");
            // jQuery("#field_error_alert_mobile_send_otp").html("Mobile number already exists.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            // jQuery("#new_mobile_error").html("Mobile number already in use.");
            jQuery("#new_mobile_error").html("");
        }
        else{
            jQuery(".resend_otp_for_new_mobile").html("[Resend Code]");
            jQuery(".resend_otp_for_new_mobile").css("pointer-events", "");
            // jQuery("#field_error_alert_mobile_send_otp").html("Error occured. Please try again after sometime.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            jQuery("#new_mobile_error").html("Error occured. Please try again after sometime.");
        }
        }
        });

    }

}

// New mobile number verification
function new_mobile_verify_otp(){
    jQuery("#new_mobile_otp_error").html("");
    // jQuery(".mobile_otp_result").html("");
    var edit_profile_form_token = jQuery("#edit_profile_form_token").val();
    var new_mobile_otp = jQuery("#new_mobile_otp").val();
    if(new_mobile_otp==''){
        // jQuery("#field_error_alert_mobile_verify_otp").html("Please enter OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
        jQuery("#new_mobile_otp_error").html("Please enter OTP.");
    }
    else{
        jQuery.ajax({
            url: 'edit_profile_verify_otp.php',
            type: 'post',
            data: 'edit_profile_form_token='+edit_profile_form_token+ '&otp='+new_mobile_otp+ '&type=mobile',
            success: function(result){
            if(result=='Error: Multiple tabs are open/token expired/invalid token'){
                alert("Error: Multiple tabs are open/token expired/invalid token");
                window.location.href = "index.php";
                // jQuery("#field_error_alert_mobile_verify_otp").html("Please enter valid OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
                // jQuery("#new_mobile_otp_error").html("Invalid token.");
            }
            else if(result=='edit_profile_verify_otp_data_empty'){
                // jQuery("#field_error_alert_mobile_verify_otp").html("Please enter valid OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
                jQuery("#new_mobile_otp_error").html("Please enter OTP.");
            }
            else if(result=='invalid_type'){
                // jQuery("#field_error_alert_mobile_verify_otp").html("Please enter valid OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
                jQuery("#new_mobile_otp_error").html("Invalid type.");
            }
            // else if(result=='otp_is_not_number'){
            //     // jQuery("#field_error_alert_mobile_verify_otp").html("Please enter valid OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
            //     jQuery("#new_mobile_otp_error").html("Please enter numbers only.");
            // }
            else if(result=='verified'){
                // jQuery(".mobile_verify_otp").hide();
                // jQuery(".resend_otp_for_mobile").hide();
                // jQuery(".mobile_verify_otp_div").hide();
                // jQuery("#field_error_alert_mobile_verify_otp").hide();
                // jQuery("#field_verified_alert_mobile_verify_otp").show();
                // jQuery("#field_verified_alert_mobile_verify_otp").html("Mobile number is verified.").addClass("alert-success").css({"padding": "1rem 1.5rem", "margin": "1rem 0"});
                // jQuery(".mobile_otp_result").html("Mobile number is verified.");
                // jQuery("#is_mobile_verified").val("1");
                // if(jQuery("#is_email_verified").val()==1){
                //     jQuery(".btn_register").attr('disabled', false);
                // }
                window.location.href = window.location.href;
            }
            else if(result=='not_verified'){
                // jQuery("#field_error_alert_mobile_verify_otp").html("Please enter valid OTP.").addClass("alert-danger").css({"padding": "1rem 1.5rem", "margin": "1rem 0 1.3rem 0"});
                jQuery("#new_mobile_otp_error").html("Please enter valid OTP.");
            }
            }
            });

    }

}

$('.bootstrap_modal').on('hidden.bs.modal', function () {
    location.reload();
    });
//   function checkout_data_submit(){
//     jQuery(".checkout_field_error").html("");
//     var address = jQuery("#address").val();
//     var house_no = jQuery("#house_no").val();
//     var state = jQuery("#state").val();
//     var pincode = jQuery("#pincode").val();
//     var payment_type = jQuery("input:radio[name=payment_type]:checked").val();
    // var is_error = '';

    // if(address==''){
    //     jQuery("#address_error").html("Please write your proper address").css("color", "red");
    //     is_error = "yes";
    // }

    // if(house_no==''){
    //     jQuery("#house_no_error").html("Please write your house number").css("color", "red");
    //     is_error = "yes";
    // }

    // if(state==''){
    //     jQuery("#state_error").html("Please write your state name").css("color", "red");
    //     is_error = "yes";
    // }

    // if(pincode==''){
    //     jQuery("#pincode_error").html("Please enter your pincode").css("color", "red");
    //     is_error = "yes";
    // }

    // if(payment_type=='' || payment_type=='undefined'){
    //     jQuery("#payment_type_error").html("Please select any one payment mode").css("color", "red");
    //     is_error = "yes";
    // }
    
   
        // if(is_error==''){
            // jQuery.ajax({
            //     url: 'checkout_submit.php',
            //     type: 'post',
            //     data: 'address='+address+'&house_no='+house_no+'&state='+state+'&pincode='+pincode+'&payment_type='+payment_type,
            //     success: function(result){
            //         if(result=='data_empty'){
            //             jQuery(".checkout_field_error").html("Please fillup all the required details");
            //         }
            //         else if(result=='payment_mode_invalid'){
            //             jQuery(".checkout_field_error").html("Please select valid payment mode");
            //         }
            //         else if(result=='invoice_mailed'){
            //             window.location.href = "payment_complete.php";
            //         }
            //         else if(result=='payment_payu'){
            //             window.location.href = "payment_gateway_payment_catch.php";
            //         }
                    // if(result=='submitted'){
                    //     jQuery(".request_partner_with_us_msg p").html("Your partnership request has been submitted. We will get back to you soon.").css("color", "#53ad44");
                    //     jQuery("#partnership_form")[0].reset();
                    // }
                    // else{
                    //     jQuery(".request_partner_with_us_msg p").html("Something went wrong. Please try again later.").css("color", "red");
                    //     jQuery("#partnership_form")[0].reset();
                    // }
            //     }
            // });
        // }
   
// }
// function fetch_data(){
//     $.ajax({
//     url: "pagination.php",
//     method: "post",
//     data: {
//     page: page
//     },
//     success: function(data){
//     $("get_data").html(data);
//     }
//     });
// }
// fetch_data();

//Table for website visitors
if ($('.website_visitor_table').length > 0) {
    $.fn.DataTable.ext.pager.numbers_length = 3;
    $('.website_visitor_table').DataTable({
        "bLengthChange": false,
        "info": false,
        'pagingType': 'simple_numbers',
        "pageLength": 5,
        "bFilter": true,
        "sDom": 'fBtlpi',
        "ordering": false,
        "language": {
            search: ' ',
            sLengthMenu: '_MENU_',
            searchPlaceholder: "Search...",
            info: "_START_ - _END_ of _TOTAL_ items",
        },
        initComplete: (settings, json) => {
            $('.dataTables_filter').appendTo('#tableSearch');
            $('.dataTables_filter').appendTo('.search-input');
        },
    });
}

$(document).ready(function() {
  $('select').niceSelect();
});

function check_delete_category(){
    return confirm('Delete category?');
}

function check_delete_product(){
    return confirm('Delete product?');
}

function check_delete_user(){
    return confirm('Delete user?');
}

function check_delete_career_application(){
    return confirm('Delete career application?');
}

function check_delete_customer_query(){
    return confirm('Delete customer query?');
}

function check_delete_partnership_request(){
    return confirm('Delete partnership request?');
}

function check_delete_notification(){
    return confirm('Delete notification?');
}

$('#user_select').on('change',function(){
    if( $(this).val()==="One User"){
    $(".notification_user_id_div").show();
    $("#enter_user_id").attr("required", true);
    }
    else{
    $(".notification_user_id_div").hide();
    }
});

// function send_notification(){
//     jQuery(".field_error").html("");
//     var user_select = jQuery("#user_select").val();
//     var enter_user_id = jQuery("#enter_user_id").val();
//     var subject = jQuery("#subject").val();
//     var message = jQuery("#message").val();
//     var is_error = '';

//     if(user_select==''){
//         jQuery("#user_select_error").html("Please select one option");
//         is_error = "yes";
//     }
//     if(enter_user_id=='' && user_select=='One User'){
//         jQuery("#enter_user_id_error").html("Please enter the user ID");
//         is_error = "yes";
//     }
//     if(subject==''){
//         jQuery("#subject_error").html("Please write the subject");
//         is_error = "yes";
//     }
//     if(message==''){
//         jQuery("#message_error").html("Please write the message");
//         is_error = "yes";
//     }
//     if(is_error==''){
//         jQuery.ajax({
//         url: 'send_notification.php',
//         type: 'post',
//         data: 'user_select='+user_select+ '&enter_user_id='+enter_user_id+ '&subject='+subject+ '&message='+message,
//         success: function(result){
//             if(result=='submitted'){
//                 jQuery("#notification_form")[0].reset();
//                 window.location.href="notifications.php";
//             }
//             else if(result=='not_found'){
//                 jQuery("#enter_user_id_error").html("No user ID found for ID: "+enter_user_id);
//             }
//             else{
//                 jQuery("#send_notification_error").html("Something went wrong. Please try again later.").css("color", "red");
//                 jQuery("#notification_form")[0].reset();
//             }
//         }
//         });
//         }
// }

function showPreview(event){
    if(event.target.files.length > 0){
     var fileName = event.target.files[0].name;
     const positionOfDot = fileName.lastIndexOf('.');
     // const fileName = name.substring(0, lastDot);
     const fileExtension = fileName.substring(positionOfDot + 1);
     var validExtension = ["jpg", "jpeg", "png"];
     var checkFileExtension = validExtension.includes(fileExtension);
     // alert(event.target.files[0]);
     if(checkFileExtension==true){
      var src = URL.createObjectURL(event.target.files[0]);
      var preview = document.getElementById("upload_image_file_preview");
      preview.src = src;
      preview.style.display = "block";
     }
     else if(checkFileExtension==false){
        alert("Please select only jpg, jpeg or png type image.");
     }
    }
    else if(event.target.files.length < 1){
     var preview = document.getElementById("upload_image_file_preview");
     preview.style.display = "none";
  }
}
// //Link clicks will be activated and the color will remain blue
// $('.links').on('click', function(){
// //   $('.links').removeClass('active');
// //   $(this).addClass('active');
// const currentLocation = location.href;
// const menuItem = document.querySelectorAll('a');
// const menuLength = menuItem.length;
// for(let i=1; i<=menuLength; i++){
// if(menuItem[i].location === currentLocation){
//     menuItem[i].className = "active";
// }
// }
// });

// window.addEventListener('load', function(){      
// });
// function checkDelete(){
//     swal({
//       title: "Are you sure?",
//       text: "Once deleted, you will not be able to recover this imaginary file!",
//       icon: "warning",
//       buttons: true,
//       dangerMode: true,
//     })
//     .then((willDelete) => {
//       if (willDelete) {
//         swal("Poof! Your imaginary file has been deleted!", {
//           icon: "success",
//         });
//         return willDelete;
//       } else {
//         return willDelete;
//       }
//     });
// }
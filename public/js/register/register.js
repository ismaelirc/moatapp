$(function() {
    
    $("#account_form").validate({
        rules: {
            full_name:{
                required: true,
                minlength: 3
            },
            username:{
                required: true,
                minlength: 3
            },
            password:{
                required: true
            }
        },
        submitHandler: function(form) {
            let data = $(form).serialize();
           
            $.ajax({
                url: $(form).attr('action'),
                type: "POST",
                dataType: 'json',
                data: data,
                beforeSend: function(){
                    $.LoadingOverlay("show");
                }
            }).done(function(data) {
                
                Swal.fire({
                    icon: 'success',
                    title: 'Done!',
                    text: data.success,
                    footer: '<a href="'+data.login_page+'">Login Page</a>'
                });
                
            }).fail(function(data) {
                
                let ul_errors = '';
                
                $.each(data.responseJSON.error, function( key, value ) {
                    ul_errors += value+'<br />';
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...Check the errors bellow!',
                    html: ul_errors
                });

            }).always(function(){
                $.LoadingOverlay("hide");
                
            });
            return;
        }
    });
});
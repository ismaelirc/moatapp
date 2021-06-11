$(function() {
    
    $("#login_form").validate({
        rules: {
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
               
                window.location.href = data.url_location+'?token='+data.token;
                
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
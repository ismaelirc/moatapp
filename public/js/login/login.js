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
                
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...Check the errors bellow!',
                    text: data.responseJSON.message
                });

            }).always(function(){
                $.LoadingOverlay("hide");
                
            });
            return;
        }
    });
});
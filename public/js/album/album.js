$(function() {
    $(function() {
        $("#year").mask('9999');

        $("#album_form").validate({
            rules: {
                artist:{
                    required: true
                },
                album_name:{
                    required: true,
                    minlength: 3
                },
                year:{
                    required: true
                }
            },
            submitHandler: function(form) {
                let data = $(form).serialize();
                let token = $("#token").val();
                let action = $(form).attr('action')+'?token='+token;
                //let album = $("#album").val();

                $.ajax({
                    url: action,
                    type: $(form).attr('method'),
                    dataType: 'json',
                    data: data,
                    beforeSend: function(){
                        $.LoadingOverlay("show");
                    }
                }).done(function(data) {
                   
                    $("#album").val(data.album_id);
                    $(form).attr('action','/album/update');
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Done!',
                        text: data.success
                    });

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

});
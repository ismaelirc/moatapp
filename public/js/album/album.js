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
            let album = $("#album").val();
            
            if(album){

                $(form).attr('action','/album/update/'+album+'/'+token);
                action = $(form).attr('action');
                
            }

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
                let errorMsg = '';
                $.each(data.responseJSON.errors,function(k, v){
                    errorMsg += v[0]+"<br />";
                })
                
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...Check the errors bellow!',
                    html: errorMsg
                });

            }).always(function(){
                $.LoadingOverlay("hide");
                
            });
            return;
        }
    });

    $("#delete_album").on('click',function(){
        Swal.fire({
            title: 'Do you want to delete this album?',
            showCancelButton: true,
            confirmButtonText: `Yes DELETE`,
            denyButtonText: `No`,
          }).then((result) => {
            
            if (result.isConfirmed) {
                let token = $("#token").val();
                let album = $("#album").val();
                
                $.ajax({
                    url: '/album/delete/'+album+'/'+token,
                    type:'Delete',
                    dataType: 'json',
                    data: {"_token": $('input:hidden[name=_token]').val()}
                }).done(function(data) {
                  
                    window.location.href = data.page+'?token='+token;
                  
                }).fail(function(data) {
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...Check the errors bellow!',
                        text: data.responseJSON.error
                    });

                }).always(function(){
                    $.LoadingOverlay("hide");
                    
                });
                return;
            }
          })
    });

});
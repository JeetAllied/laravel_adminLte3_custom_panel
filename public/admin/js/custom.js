$( document ).ready(function() {
    //check current password is correct or not
    $("#current_password").focusout(function(){
        let currentPwd = $("#current_password").val();
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            url: "checkCurrentPassword",
            data: {currentPwd:currentPwd},
            success: function (response) {
                console.log(response);
            },
            error: function (error, errorThrown) {
                if(error.status == 422)
                {
                    toastr.error(error.responseJSON.currentPwd[0]);
                }
                else
                {
                    toastr.error(error.responseJSON.message);
                }
            }
        });
    });
});

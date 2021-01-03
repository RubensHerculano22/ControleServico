$(document).ready(function(){

    const regex = /[0-9]/

    $("#submit").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        data = new FormData($("#submit").get(0));
        var email = $("#email").val();
        var senha = $("#senha").val();
        
        if(email.search("@") > 0 && email.search(".com") > 0)
        {
            if(senha.length >= 8 && regex.test(senha))
            {
                $.ajax({
                    type: "post",
                    url: BASE_URL+"Usuario/autentifica",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    data: data,
                    success: function(data)
                    {
                        if(data.logged === true)
                        {
                            window.location.href = BASE_URL+data.local;
                        }
                        else if(data.logged === false)
                        {
                            showNotification("error", "Problema ao realizar a autentificação", data.error, "toast-top-center");
                        }
                    }
                });
            }
            else
            {
                showNotification("error", "Problema ao realizar a autentificação", "A senha digitada não é uma senha valida", "toast-top-center");
            }
        }
        else
        {
            showNotification("error", "Problema ao realizar a autentificação", "Email digitado não é um email valido", "toast-top-center");
        }
    });
});
$(document).ready(function(){
    $("#submit").submit(function(e){
        e.preventDefault();

        var data = $(this).serialize();
        data = new FormData($("#submit").get(0));

        email = $("#email").val();

        if(email == "")
        {
            showNotification("error", "Erro no Esqueci a senha", "O campo 'Email' deve ser preechido.", "toast-top-center");
        }
        else
        {
            $.ajax({
                type: "post",
                url: BASE_URL+"Usuario/troca_senha",
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                data: data,
                success: function(data)
                {
                    if(data.rst == true)
                    {
                        Swal.fire({
                            title: 'Sucesso',
                            text: data.msg,
                            icon: 'success',
                            confirmButtonText: `Ok`,
                            }).then((result) => {
                            if (result.isConfirmed)
                                window.location.href = BASE_URL+"Usuario/nova_senha";
                        })
                    }
                    else if(data.rst == false)
                    {
                        showNotification("warning", "Erro na recuperação", data.msg, "toast-top-center");
                    }
                }
            });
        }
    })
})
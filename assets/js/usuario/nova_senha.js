$(document).ready(function(){
    $("#submit").submit(function(e){
        e.preventDefault();

        const regex = /[0-9]/

        var data = $(this).serialize();
        data = new FormData($("#submit").get(0));

        codigo = $("#codigo").val();
        id_usuario = $("#id_usuario").val();
        senha = $("#senha").val();
        conf_senha = $("#conf_senha").val();

        if(codigo == "")
        {
            showNotification("error", "Erro no codigo de recuperação", "O campo 'Codigo' deve ser preechido.", "toast-top-center");
        }
        if(id_usuario != "" && (senha == "" || senha.length < 8))
        {
            showNotification("error", "Erro no cadastrar", "A senha necessita conter no minimo 8 caracteres", "toast-top-center");
        }
        else if(id_usuario != "" && (senha == "" || !regex.test(senha)))
        {
            showNotification("error", "Erro no cadastrar", "A senha precisa ter ao menos 1 numero.", "toast-top-center");
        }
        else if(senha != conf_senha)
        {
            showNotification("error", "Erro no cadastrar", "As senhas não coincidem", "toast-top-center");
        }
        else
        {
            $.ajax({
                type: "post",
                url: BASE_URL+"Usuario/verifica_codigo",
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                data: data,
                success: function(data)
                {
                    console.log(data);
                    if(data != null && data.rst != null)
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
                                    window.location.href = BASE_URL+"Usuario/login";
                            });
                        }
                        else
                        {
                            showNotification("warning", data.msg, "tente novamente em alguns minutos", "toast-top-center");
                        }
                    }
                    else if(data != null && data.rst == null)
                    {
                        $("#codigo").attr("disabled", true);
                        $("#id_usuario").val(data.id_usuario);
                        $("#troca_senha").removeClass("d-none");
                    }
                    else if(data == null)
                    {
                        showNotification("error", "Erro na recuperação", "Este codigo é invalido", "toast-top-center");
                    }
                }
            });
        }
    })
});
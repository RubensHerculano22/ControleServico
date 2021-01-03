$(document).ready(function(){

    $("#perguntar").on("click", function(e){
        e.preventDefault();

        if(LOGGED == 0)
        {
            Swal.fire({
                title: 'Aviso',
                text: "Para realizar uma pergunta é necessário estar autentificado. Deseja ir para a pagina de Autentificação?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: `Sim`,
                denyButtonText: `Não`,
                }).then((result) => {
                if (result.isConfirmed)
                {
                    window.location.href = BASE_URL+"Usuario/login";
                }
                    
            })
        }
        else
        {
            var pergunta = $("#pergunta").val();
            var id_servico = $("#id_servico").val();
            var id_usuario = $("#id_usuario").val();
            var data = {"pergunta": pergunta, "id_servico": id_servico, "id_usuario": id_usuario};
            $.ajax({
                type: "post",
                url: BASE_URL+"Home/perguntar/",
                dataType: "json",
                data:  data,
                success: function(data)
                {
                    if(data.rst === true)
                    {
                        Swal.fire({
                            title: 'Sucesso',
                            text: data.msg,
                            icon: 'success',
                            confirmButtonText: `Ok`,
                            }).then((result) => {
                            if (result.isConfirmed)
                            {
                                var html = '<h6 class="text-justify">'+pergunta+'.</h6>'+
                                '<ul>'+
                                '<li><span class="text-muted">Sem resposta ainda!</span</li>'+
                                '</ul>';

                                $(".mensagem_pergunta").remove();
                                $(".pergunta").append(html);
                            }
                                
                        })
                    }
                    else if(data.rst === false)
                    {
                        showNotification("error", "Problema ao realizar a pergunta", data.msg, "toast-top-center");
                    }
                }
            });
        }
    })

});
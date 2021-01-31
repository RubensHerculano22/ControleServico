$(document).ready(function(){

    $('#hora_servico').inputmask({
        mask: ['99:99'],
        keepStatic: true    
    });
    $('[data-mask]').inputmask();

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
                cancelButtonText: `Não`,
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
            if(pergunta)
            {
                $.ajax({
                    type: "post",
                    url: BASE_URL+"Servico/cadastrar_pergunta/",
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
            else
            {
                showNotification("error", "Problema ao realizar a pergunta", "Nenhum pergunta foi digitada", "toast-top-center");
            }
        }
    });

    $("#endereco_cadastrado").on("click", function(){
        checked = $("#endereco_cadastrado")[0].checked;
        if(checked == true)
        {
            $("#endereco").attr("disabled", true);
        }
        else
        {
            $("#endereco").attr("disabled", false);
        }
    });

    $("#modal_contratacao").on("show.bs.modal", function(){

        var id = $("#id_servico").val();
        $.ajax({
            type: "post",
            url: BASE_URL+"Servico/datas_disponiveis/"+id,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            // data: data,
            success: function(data)
            {
                //montar função para colocar as datas que serão utilizadas.
            }
        });
    })

    $("#submit").submit(function(e){
        e.preventDefault();
        if(LOGGED == 0)
        {
            Swal.fire({
                title: 'Aviso',
                text: "Para realizar a contratação de um serviço é necessário estar autentificado. Deseja ir para a pagina de Autentificação?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: `Sim`,
                cancelButtonText: `Não`,
                }).then((result) => {
                if (result.isConfirmed)
                {
                    window.location.href = BASE_URL+"Usuario/login";
                }
                    
            })
        }
        else
        {
            var data = $(this).serialize();
            data = new FormData($("#submit").get(0));
    
            $.ajax({
                type: "post",
                url: BASE_URL+"Servico/contrata_servico",
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                data: data,
                success: function(data)
                {
                    console.log(data);
                    if(data.rst === true)
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso',
                            text: 'Pedido de contratação enviado para o Prestador, você será notificado quando houver retorno'
                        });
                        $("#modal_contratacao").modal("hide");
                    }
                    else if(data.rst === false)
                    {
                        showNotification("warning", "Erro ao pedir contratação ", data.msg, "toast-top-center");
                    }
                }
            });
        }
    });

    $("#modal_contratacao").on('hidden.bs.modal', function (e) {
        $("#data_servico").val("");
        $("#hora_servico").val("");
        $("#descricao").val("");
        $("#endereco_cadastrado")[0].checked = false;
        $("#endereco").val("");
        $("#endereco").attr("disabled", false);
    });

});
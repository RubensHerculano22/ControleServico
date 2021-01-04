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

    $("#submit").submit(function(e){
        e.preventDefault();
        console.log("veio");
        var data = $(this).serialize();
        data = new FormData($("#submit").get(0));

        $.ajax({
            type: "post",
            url: BASE_URL+"Home/contrata_servico",
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: data,
            success: function(data)
            {
                if(data.rst === 1)
                {
                    window.location.href = BASE_URL+"Home";
                }
                else if(data.rst === 2)
                {
                    Swal.fire({
                        title: 'Erro',
                        text: data.msg,
                        icon: 'info',
                        confirmButtonText: `Ok`,
                        }).then((result) => {
                        if (result.isConfirmed)
                            window.location.href = BASE_URL+"Usuario/login";
                    })
                }
                else if(data.rst === 0)
                {
                    showNotification("warning", "Erro ao cadastrar", data.msg, "toast-top-center");
                }
                else if(data.rst === 4)
                {
                    showNotification("success", "Sucesso", data.msg, "toast-top-center");
                }
            }
        });
    });

});
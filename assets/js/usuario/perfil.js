$(document).ready(function(){

    var id_orcamento = 0;

    $(".bloc_eye").on("click", function(){

        var classe = $(".bloc_eye")[0].lastElementChild.className;
        if(classe.search("fa-eye-slash") > -1)
        {
            $("#cpf").val("");
            $("#data_nascimento").val("");
            $(".icon_eyes").remove();
            $(".bloc_eye").html('<i class="fas fa-eye float-right icon_eyes"></i>');
        }
        else
        {
            cpf = $("#cpf_hidden").val();
            nascimento = $("#data_nascimento_hidden").val();
            $("#cpf").val(cpf);
            $("#data_nascimento").val(nascimento);
            $(".icon_eyes").remove();
            $(".bloc_eye").html('<i class="fas fa-eye-slash float-right icon_eyes"></i>');
        }
        
        // $(".icon_eyes").remove();
        // $(".bloc_eye").html("<i class=''");
    });

    $(".tabs").on("click", function(e){
        e.preventDefault();
        var id = $(this)[0].id;

        $.post(BASE_URL+"Usuario/troca_local/"+id, null, function(result){

        }, "json");

        $("#dados_tab").removeClass("show active");
        $("#favoritos_tab").removeClass("show active");
        $("#pedidos_tab").removeClass("show active");
        $("#cadastrado_tab").removeClass("show active");
        $("#suporte_tab").removeClass("show active");

        $("#"+id+"_tab").addClass("show active");
    });

    $(".orcamento_m").on("click", function(){
        id_orcamento = $(this).data("id");
    });

    $("#ativar_conta").on("click", function(){
        $.ajax({
            type: "post",
            url: BASE_URL+"Usuario/reeviar_email",
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: data,
            success: function(data)
            {
                if(data.rst === true)
                {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: data.msg
                    });
                }
                else if(data.rst === false)
                {
                    showNotification("warning", data.msg, "Tente novamente daqui a alguns minutos", "toast-top-center");
                }
            }
        });
    });

    $(".cancela_servico").on("click", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        Swal.fire({
            title: 'Aviso',
            text: "Deseja realmente cancelar esse serviço?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `Sim`,
            cancelButtonText: `Não`,
            }).then((result) => {
            if (result.isConfirmed)
            {
                $.ajax({
                    type: "post",
                    url: BASE_URL+"Usuario/cancela_servico/"+id,
                    dataType: "json",
                    success: function(data)
                    {
                        if(data === true)
                        {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: "Serviço cancelado com sucesso!"
                            }).then((result) => {
                                window.location.href = BASE_URL+"Usuario/perfil/pedidos";
                            });
                        }
                        else if(data.rst === false)
                        {
                            showNotification("warning", "Erro ao tentar cancelar o serviço", "Tente novamente daqui a alguns minutos", "toast-top-center");
                        }
                    }
                });
            }
        });
    });

    $(".remove_favorito").on("click", function(){
        var id =  $(".remove_favorito").data("id");

        Swal.fire({
            title: 'Aviso',
            text: "Deseja realmente desfavoritar esse serviço?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `Sim`,
            cancelButtonText: `Não`,
            }).then((result) => {
            if (result.isConfirmed)
            {
                $.ajax({
                    type: "post",
                    url: BASE_URL+"Usuario/desfavoritar/"+id,
                    dataType: "json",
                    success: function(data)
                    {
                        if(data === true)
                        {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: "Serviço retirado dos favoritos!"
                            }).then((result) => {
                                window.location.href = BASE_URL+"Usuario/perfil/favoritos";
                            });
                        }
                        else if(data.rst === false)
                        {
                            showNotification("warning", "Erro ao tentar remover do favoritos", "Tente novamente daqui a alguns minutos", "toast-top-center");
                        }
                    }
                });
            }
        });
    });
});
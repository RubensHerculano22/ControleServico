$(document).ready(function(){

    $('#hora_servico').inputmask({
        mask: ['99:99'],
        keepStatic: true    
    });

    // $("#data_servico").on("change", function(){
    //     console.log(isValidDate($("#data_servico").val()))
    // })

    var negativos = $("#vert-tabs-negativos");
    var positivos = $("#vert-tabs-positivos");
    var todos = $("#vert-tabs-todos");
    if(negativos[0].children.length <= 0)
    {
        
        html = '<div class="alert mt-3" style="background-color: #254B59; color: #F0F2F0">' +
                    '<p>Nenhum feedback negativo cadastrado a este serviço!</p>' +
                '</div>';

        $(negativos).append(html);
    }

    if(positivos[0].children.length <= 0)
    {
        html = '<div class="alert mt-3" style="background-color: #254B59; color: #F0F2F0">'+
                    '<p>Nenhum feedback positivos cadastrado a este serviço!</p>'+
                '</div>';

        $(positivos).append(html);
    }

    if(todos[0].children.length <= 0)
    {
        html = '<div class="alert mt-3" style="background-color: #254B59; color: #F0F2F0">'+
                    '<p>Nenhum feedback cadastrado a este serviço!</p>'+
                '</div>';

        $(todos).append(html);
    }

    //Cadastra uma pergunta.
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

    //realiza a ativação e desativação do campo de endereço
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
                console.log(data);
                $('#data_servico').daterangepicker({
                    singleDatePicker: true,
                    minDate: "21/06/2021",
                    "locale": {
                        "format": "DD/MM/YYYY",
                        "applyLabel": "Selecionar",
                        "cancelLabel": "Cancelar",
                        "daysOfWeek": [
                            "Dom",
                            "Seg",
                            "Ter",
                            "Qua",
                            "Qui",
                            "Sex",
                            "Sab"
                        ],
                        "monthNames": [
                            "Janeiro",
                            "Fevereiro",
                            "Março",
                            "Abril",
                            "Maio",
                            "Junho",
                            "Julho",
                            "Agosto",
                            "Setembro",
                            "Outubro",
                            "Novembro",
                            "Decembro"
                        ],
                        "firstDay": 1
                    },
                    isInvalidDate: function(date) {
                        var rst = false;
                        $.each(data, function(index, value) {
                            if(date.day() == 0 && value.dia_semana == 1)
                                rst = false;
                            else if(date.day() == 1 && value.dia_semana == 2)
                                rst =  false;
                            else if(date.day() == 2 && value.dia_semana == 3)
                                rst =  false;
                            else if(date.day() == 3 && value.dia_semana == 4)
                                rst = false;
                            else if(date.day() == 4 && value.dia_semana == 5)
                                rst =  false;
                            else if(date.day() == 5 && value.dia_semana == 6)
                                rst = false;
                            else if(date.day() == 6 && value.dia_semana == 7)
                                rst = false;
                            else
                                rst = true;
                        });

                        return rst;
                    }
                });
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

    $("#submit_avise_me").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        data = new FormData($("#submit_avise_me").get(0));

        $.ajax({
            type: "post",
            url: BASE_URL+"Servico/avise_me",
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
                        text: 'Email salvo com sucesso, quando o serviço estiver disponivel você será notificado.'
                    });
                    $("#modal_avise_me").modal("hide");
                }
                else if(data.rst === false)
                {
                    showNotification("error", data.msg, "Tente novamente mais tarde", "toast-top-center");
                }
            }
        });
    });

    $("#modal_avise_me").on('hidden.bs.modal', function (e) {
        $("#email").val("");
    });

});
$(document).ready(function(){

    $('#cep').inputmask({
        mask: ['99999-999'],
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
            $('#data_servico').daterangepicker({
                singleDatePicker: true,
                minDate: get_data_atual(),
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
                    for(i=0;i<data.length;i++)
                    {
                        if(date.day() == 0 && data[i].dia_semana == 1)
                        {
                            return false;
                        }   
                        else if(date.day() == 1 && data[i].dia_semana == 2)
                        {
                            return false;
                        }
                        else if(date.day() == 2 && data[i].dia_semana == 3)
                        {
                            return false;
                        }
                        else if(date.day() == 3 && data[i].dia_semana == 4)
                        {
                            return false;
                        }
                        else if(date.day() == 4 && data[i].dia_semana == 5)
                        {
                            return false;
                        }
                        else if(date.day() == 5 && data[i].dia_semana == 6)
                        {
                            return false;
                        }
                        else if(date.day() == 6 && data[i].dia_semana == 7)
                        {
                            return false;
                        }
                    }

                    return true;
                }
            });
        }
    });
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
        
        else if(ATIVACAO == 0)
        {
            showNotification("error", "Erro", "É necessário realizar a ativação da conta.", "toast-top-center", "15000");
        }
        else
        {
            var pergunta = $("#pergunta").val();
            var id_servico = $("#id_servico").val();
            var id_usuario = $("#id_usuario").val();
            var data = {"pergunta": pergunta, "id_servico": id_servico, "id_usuario": id_usuario};
            if(pergunta)
            {
                Swal.fire({
                    title: 'Aguarde enquanto processamos a requisição',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });

                $.ajax({
                    type: "post",
                    url: BASE_URL+"Servico/cadastrar_pergunta/",
                    dataType: "json",
                    data:  data,
                    success: function(data)
                    {
                        swal.close();
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
            $(".local_especifico").removeClass("d-none");
            $(".endereco_cadastro").addClass("d-none");
        }
        else
        {
            $(".endereco_cadastro").removeClass("d-none");
            $(".local_especifico").addClass("d-none");
        }
    });

    $("#data_servico").on("apply.daterangepicker", function(){

        var data_string = $("#data_servico").val();
        data = data_string.split("/");
        date = new Date(data[2], data[1], data[0]);

        var post = {"data": data_string, "dia_semana": trocaDiaSemana(date.getDay()), "id_servico": $("#id_servico").val()};

        $.ajax({
            type: "post",
            url: BASE_URL+"Servico/get_horarios_disponiveis/",
            dataType: "json",
            data: post,
            success: function(data)
            {
                $(".item_horario").remove();
                if(data != null)
                {
                    var html = "";
                    $.each(data, function(index, value) {
                        $("#horario_servico").append("<option class='item_horario' value='"+value.horario+"'>"+value.horario+"</option>");
                    });
                }
                else
                {
                    showNotification("error", "Nenhum horario encontrado", "Tente novamente em outra data", "toast-top-center");
                }
            }
        });
    });

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
        else if(ATIVACAO == 0)
        {
            showNotification("error", "Erro", "É necessário realizar a ativação da conta.", "toast-top-center", "15000");
        }
        else
        {
            var data_servico = $("#data_servico").val();
            var hora_servico = $("#horario_servico").val();
            var descricao = $("#descricao").val();
            var endereco = $("#endereco").val();
            var cep = $("#cep").val();
            var estado = $("#estado_input").val();

            var verif = 0;
            if(data_servico != null)
            {
                if(hora_servico != null)
                {
                    if(descricao != "")
                    {
                        if($("#endereco_cadastrado")[0].checked == false && endereco != "")
                        {
                            verif = 1;
                        }
                        else if($("#endereco_cadastrado")[0].checked == true  && cep != "" && estado != "")
                        {
                            verif = 1;
                        }
                        else
                        {
                            showNotification("error", "Erro", "Um endereço deve ser selecionado", "toast-top-center", "15000");    
                        }
                    }
                    else
                    {
                        showNotification("error", "Erro", "O campo 'Descrição' deve ser preenchido", "toast-top-center", "15000");        
                    }
                }
                else
                {
                    showNotification("error", "Erro", "O campo 'Hora para o Serviço' deve ser preenchido", "toast-top-center", "15000");    
                }
            }
            else
            {
                showNotification("error", "Erro", "O campo 'Data para o Serviço' deve ser preenchido", "toast-top-center", "15000");
            }

            if(verif == 1)
            {
                var data = $(this).serialize();
                data = new FormData($("#submit").get(0));
        
                Swal.fire({
                    title: 'Aguarde enquanto processamos a requisição',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });

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
                        swal.close();
                        if(data.rst === true)
                        {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: 'Pedido de contratação enviado para o Prestador, você será notificado quando houver retorno'
                            }).then((result) => {
                                if (result.isConfirmed)
                                {
                                    window.location.reload();
                                };
                            });
                        }
                        else if(data.rst === false)
                        {
                            showNotification("warning", "Erro ao pedir contratação ", data.msg, "toast-top-center");
                        }
                    }
                });
            }
        }
    });

    $("#modal_contratacao").on('hidden.bs.modal', function (e) {
        $("#data_servico").val("");
        $("#hora_servico").val("");
        $("#descricao").val("");
        $("#endereco_cadastrado")[0].checked = false;
        $(".local_especifico").addClass("d-none");
        $(".endereco_cadastro").removeClass("d-none");
        $("#endereco").val("");
        $("#cep").val("");
        $("#estado_input").val("");
        $("#cidade_input").val("");
        $("#bairro_input").val("");
        $("#endereco_input").val("");
        $("#numero_input").val("");
        $("#complemento_input").val("");
    });

    $("#submit_avise_me").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        data = new FormData($("#submit_avise_me").get(0));

        Swal.fire({
            title: 'Aguarde enquanto processamos a requisição',
            showConfirmButton: false,
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });

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
                swal.close();
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

function pesquisa_cep()
{
    var cep = $("#cep").val();
    if(cep.length > 8)
    {
            $(".bloc_pesquisa").replaceWith('<div class="bloc_pesquisa"><br/><button type="button" class="btn mt-2" style="background-color: #254B59; color: #F0F2F0"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;Carregando</button></div>');
            setTimeout(() => {        
                
                cep_tratado = cep.split("").filter(n => (Number(n) || n == 0)).join("");

                var data = {"cep": cep_tratado};
                $.post(BASE_URL+"Servico/get_cep", data, function(data) {
                    if(data.estado == null)
                    {
                        showNotification("error", "Erro no campo CEP", "Valores invalidos foram cadastrados no campo CEP.", "toast-top-center");                
                    }
                    else
                    {
                        $("#endereco_input").val(data.logradouro)
                        $("#bairro_input").val(data.bairro)
                        $("#cidade_input").val(data.localidade)
                        $("#estado_input").val(data.estado.nome)
                    }

                    $(".bloc_pesquisa").replaceWith('<div class="bloc_pesquisa"><br/><button type="button" onclick="pesquisa_cep()" class="btn mt-2" style="background-color: #254B59; color: #F0F2F0"><i class="fas fa-search-location"></i> Pesquisar</button></div>');
                }, "json");

            }, 1000);
    }
    else
    {
        showNotification("error", "Erro no campo CEP", "Valores invalidos foram cadastrados no campo CEP.", "toast-top-center");
    }
}

function get_data_atual()
{
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    return dd+"/"+mm+"/"+yyyy;
}

function trocaDiaSemana(semana)
{
    if(semana == "0")
        valor =  6
    else if(semana == "1")
        valor =  7    
    else if(semana == "2")
        valor =  1
    else if(semana == "3")
        valor =  2
    else if(semana == "4")
        valor =  3
    else if(semana == "5")
        valor =  4
    else if(semana == "6")
        valor =  5
    
    return valor;
}
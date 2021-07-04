var tableOrcamento, tableTodasPergunta;
var contPergunta = 0;

$(document).ready(function(){

    var verifVisivel = 1;
    var id = $("#id_servico").val();    
    atualiza_perguntas(id);

    $(".preco").inputmask('decimal', {
        'alias': 'numeric',
        'groupSeparator': ',',
        'autoGroup': true,
        'digits': 2,
        'radixPoint': ".",
        'digitsOptional': false,
        'allowMinus': false,
        'prefix': 'R$ ',
    });

    $("input[data-bootstrap-switch]").each(function(){
        $.post( BASE_URL+"Servico/get_visibilidade/"+id, function( data ) {
            if(data == 1)
            {
                $("input[data-bootstrap-switch]").bootstrapSwitch('state', $("input[data-bootstrap-switch]").prop('checked'));
                verifVisivel = 0;
            }
            else
            {
                $("input[data-bootstrap-switch]").bootstrapSwitch('state', false);
            }
        });
    });

    $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function (event, state) {
        if(verifVisivel == 1)
        {
            verifVisivel = 0;
        }
        else
        {
            var visivel = $('input[name="my-checkbox"]').bootstrapSwitch('state');
            tipo = visivel == true ? 1 : 0;
            var post = {"servico": id, "visivel": tipo};
            $.ajax({
                type: "post",
                url: BASE_URL+"Servico/visibilidade",
                dataType: "json",
                data: post,
                success: function(data)
                {
                    if(data === true)
                    {
                        showNotification("success", "Sucesso!", "Estado do Serviço atualizado.", "toast-top-center");
                    }
                    else if(data === false)
                    {
                        showNotification("warning", "Erro ao alterar o estado do Servico", "Tente novamente daqui a alguns minutos", "toast-top-center");
                    }
                }
            });
        }
    });

    $(".tabs_link").on("click", function(){
        $(".tabs_link").removeClass("text-dark").addClass("text-white");
        $(this).removeClass("text-white").addClass("text-dark");
    });

    tableTodasPergunta = $("#lista_pergunta_completa").DataTable({
        language: {
            url: BASE_URL+"assets/plugins/datatables/portugues-brasil.json",
            select: { rows: { _: "%d linhas selecionadas", 1: "1 linha selecionada", 0: "" } }
        },
        ajax: {
            url: BASE_URL+"Servico/get_perguntas/"+id+"/"+true,
            dataSrc: "",
            type: "post",
            dataType: "json",
        },
        columns: [
            {data: "pergunta", title: "Perguntas"},
            {
                data:null,
                title: "Nome",
                render: function(data, x, row)
                {
                    return row.usuario_pergunta.nome + " " +row.usuario_pergunta.sobrenome
                }
            },
            {
                data: null, 
                title: "Data da Pergunta",
                render: function(data, x, row){
                    if(row.data_inclusao_br != false)
                        return row.data_inclusao_br;
                    else
                        return "-";
                }
            },
            {
                data: "resposta", 
                title: "Resposta",
                render: function(data, x, row){
                    if(row.resposta != null && row.resposta != "")
                        return row.resposta;
                    else
                        return "-";
                }
            },
            {
                data: null, 
                title: "Data da Resposta",
                render: function(data, x, row){
                    if(row.data_resposta_br != false)
                        return row.data_resposta_br;
                    else
                        return "-";
                }
            },
            {
                data:null,
                title: "Ação",
                render: function(data, x, row){
                    contPergunta++;
                    return '<button type="button" class="btn btn-outline-secondary" onclick="editaResposta('+contPergunta+')"><i class="fas fa-edit"></i></button>';
                }
            },
        ],
        "columnDefs": [
            {"className": "text-center", "targets": "_all"},
        ],
    });

    tableOrcamento = $("#lista_orcamentos").DataTable({
        language: {
            url: BASE_URL+"assets/plugins/datatables/portugues-brasil.json",
            select: { rows: { _: "%d linhas selecionadas", 1: "1 linha selecionada", 0: "" } }
        },
        ajax: {
            url: BASE_URL+"Servico/get_orcamentos/"+id,
            dataSrc: "",
            type: "post",
            dataType: "json",
        },
        order: [[4, "asc"]],
        columns: [
            {data: "usuario.nome", title: "Nome do Solicitante"},
            {
                data:null,
                title: "Descrição de Solicitação",
                render: function(data, x, row){
                    return row.descricao;
                }
            },
            {
                data:null,
                title: "Ultima Modificação",
                render: function(data, x, row){
                    return row.solicitacao.data_alteracao;
                }
            },
            {
                data:null,
                title: "Status do Orçamento",
                render: function(data, x, row){
                    return row.solicitacao.status.nome;
                }
            },
            {
                data:null,
                title: "Ação",
                render: function(data, x, row){
                    if(row.solicitacao.status.id == 1 || row.solicitacao.status.id == 5 || row.solicitacao.status.id == 4)
                        return '<span class="fade">1</span><a href="'+BASE_URL+"Servico/movimentacao/"+row.id+'" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></a>';
                    else
                        return '<span class="fade">2</span><a href="'+BASE_URL+"Servico/movimentacao/"+row.id+'" class="btn btn-outline-secondary"><i class="fas fa-info-circle"></i></a>';
                }
            },
            {
                data:null,
                title: "Cancelar",
                render: function(data, x, row){                    
                    if(row.solicitacao.status.id != 3 && row.solicitacao.status.id != 6 && row.solicitacao.status.id != 7)
                        return '<button type="button" class="btn btn-outline-danger" onclick="cancelaServico('+row.id+')"><i class="fas fa-times"></i></button>';
                    else
                        return '<button type="button" class="btn btn-outline-danger disabled"><i class="fas fa-times"></i></button>';                        
                }
            },
            
        ],
        "columnDefs": [
            {"className": "text-center", "targets": "_all"},
        ],
        rowCallback: function (row, data){
            if(data.solicitacao.status.id == 1 || data.solicitacao.status.id == 5 || data.solicitacao.status.id == 4)
                $(row).prop('style','background-color: #F0F2F0;');
        }
    });

    $("#submit_pergunta").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        data = new FormData($("#submit_pergunta").get(0));

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
            url: BASE_URL+"Servico/responder_pergunta",
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
                        text: data.msg
                    });
                    atualiza_perguntas(id)
                    contPergunta = 0;
                    tableTodasPergunta.ajax.reload();
                    $("#modal_resposta").modal("hide");
                }
                else if(data.rst === false)
                {
                    showNotification("warning", data.msg, "Tente novamente daqui a alguns minutos", "toast-top-center");
                }
            }
        });
    });

    $("#modal_resposta").on("hide.bs.modal", function(e){
        $("#resposta").val("");
    });

});

function abrirResposta(id)
{
    var pergunta = $("#pergunta"+id).val();
    var resposta = $("#resposta"+id);
    $("#id_pergunta").val(id);
    $("#pergunta_input").val(pergunta);
    if(resposta.length > 0)
        $("#resposta").val(resposta[0].innerHTML);
    $("#modal_resposta").modal("show");
}

function editaResposta(id)
{
    id--;
    var data = tableTodasPergunta.row(id).data();
    
    $("#id_pergunta").val(data.id);
    $("#pergunta_input").val(data.pergunta);
    $("#resposta").val(data.resposta);

    $("#modal_resposta").modal("show");
}

function atualiza_perguntas(id)
{
    $.ajax({
        type: "post",
        url: BASE_URL+"Servico/get_perguntas/"+id+"/"+false,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(data)
        {

            $(".item_pergunta").remove();

            if(data.length > 0)
            {
                $.each( data, function( key, value ) {
                    var html = '<tr class="item_pergunta">' +
                                    '<td>'+value.pergunta+'  <small>('+value.data_inclusao_br+')</small><input type="hidden" id="pergunta'+value.id+'" value="'+value.pergunta+'" /></td>' +
                                    '<td><button type="button" class="btn mr-4" style="background-color: #254B59; color: #F0F2F0;" onclick="abrirResposta('+value.id+')">Responder</button></td>' +
                                '</tr>';
                    $("#lista_pergunta").append(html);
                });
            }
            else
            {
                var html = '<tr class="item_pergunta">' +
                                '<td colspan="2" class="text-center">Nenhuma pergunta pendente</td>' +
                            '</tr>';
                        
                $("#lista_pergunta").append(html);
            }
        }
    });
}

function cancelaServico(id){
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
                url: BASE_URL+"Servico/cancela_servico/"+id,
                dataType: "json",
                success: function(data)
                {
                    swal.close()
                    if(data === true)
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso',
                            text: "Serviço cancelado com sucesso!"
                        }).then((result) => {
                            i=0;
                            tableOrcamento.ajax.reload();
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
}
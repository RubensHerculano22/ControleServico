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
                    if(row.solicitacao.status.id != 3 || row.solicitacao.status.id != 6 || row.solicitacao.status.id != 7)
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

    $("#submit_orcamento").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        data = new FormData($("#submit_orcamento").get(0));

        $.ajax({
            type: "post",
            url: BASE_URL+"Servico/resposta_orcamento",
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
                    i=0;
                    tableOrcamento.ajax.reload();
                    $("#modal_orcamento").modal("hide");
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
                                '<td colspan="2">Nenhuma pergunta pendente</td>' +
                            '</tr>';
                        
                $("#lista_pergunta").append(html);
            }
        }
    });
}

function abriOrcamento(id)
{
    id = id - 1;
    var value = tableOrcamento.row(id).data();
    $("#id_orcamento").val(value.id);
    
    $(".bloc_remove").remove();

    var html = "";
    var abre = 0;
    for(j=0;j<value.solicitacao.length;j++)
    {
        var data = value.solicitacao;
        if(j%2==0)
        {
            abre = j;
            html += '<tr class="bloc_remove">';
            html += '<td style="border-right: 1px solid #000;" width="50%">';
        }
        else
        {
            html += '<td width="50%">';
        }

        html += '<div class="row mr-3 ml-3">';

        if(data[j].status.id == 1)
        {

            html += '<div class="col-md-6 col-sm-3 col-xs-12">'+
                        '<div class="form-group">'+
                            '<label for="nome">Data para o Serviço</label>'+
                            '<input type="text" class="form-control" value="'+data[j].data_servico+'" readonly>'+
                        '</div>'+
                    '</div>';
            html += '<div class="col-md-6 col-sm-6 col-xs-12">'+
                        '<div class="form-group">'+
                            '<label for="nome">Hora para o Serviço</label>'+
                            '<input type="text" class="form-control" value="'+data[j].hora_servico+'" readonly>'+
                        '</div>'+
                    '</div>';
            html += '<div class="col-md-12 col-sm-12 col-xs-12">'+
                        '<div class="form-group">'+
                            '<label for="nome">Descrição</label>'+
                            '<textarea class="form-control" rows="3" readonly>'+data[j].descricao+'</textarea>'+
                        '</div>'+
                    '</div>';
            html += '<div class="col-md-12 col-sm-12 col-xs-12">'+
                        '<div class="form-group">'+
                            '<label for="nome">Endereço</label>'+
                            '<input type="text" class="form-control" value="'+data[j].endereco+'" readonly>'+
                        '</div>'+
                    '</div>';

            $(".orcamentoResposta").removeClass("d-none");
        }
        else if(data[j].status.id == 2)
        {
            html += '<div class="col-md-4 col-sm-4 col-xs-12">'+
                        '<div class="form-group">'+
                            '<label for="nome">Status do Pedido</label>'+
                            '<br/><i class="fas fa-chevron-right"></i> Orçamento Gerado'+
                        '</div>'+
                    '</div>';
            html += '<div class="col-md-8 col-sm-8 col-xs-12">'+
                        '<div class="form-group">'+
                            '<label for="nome">Orçamento</label>'+
                            '<input type="text" class="form-control" value="'+data[j].orcamento+'" readonly>'+
                        '</div>'+
                    '</div>';
            html += '<div class="col-md-12 col-sm-12 col-xs-12">'+
                        '<div class="form-group">'+
                            '<label for="nome">Descrição</label>'+
                            '<textarea class="form-control" rows="3" readonly>'+data[j].descricao+'</textarea>'+
                        '</div>'+
                    '</div>';
                    
            $(".orcamentoResposta").addClass("d-none");
        }
        else if(data[j].status.id == 3)
        {
            html += '<div class="col-md-4 col-sm-4 col-xs-12">'+
                        '<div class="form-group">'+
                            '<label for="nome">Status do Pedido</label>'+
                            '<i class="fas fa-chevron-right"></i> Serviço Recusado'+
                        '</div>'+
                    '</div>';
            html += '<div class="col-md-12 col-sm-12 col-xs-12">'+
                        '<div class="form-group">'+
                            '<label for="nome">Descrição</label>'+
                            '<textarea class="form-control" rows="3" readonly>'+(data[j].descricao != null ? data[j].descricao : "Sem descrição cadastrada")+'</textarea>'+
                        '</div>'+
                    '</div>';
            
            $(".orcamentoResposta").addClass("d-none");
        }
        else if(data[j].status.id == 4)
        {
            html += '<div class="col-md-12 col-sm-12 col-xs-12">'+
                        '<div class="alert alert-warning  alert-dismissible">'+
                            '<h5><i class="icon fas fa-check"></i> Confirmado</h5>'+
                            'O Serviço foi aceito por ambas as partes, e será realizado no dia: '+data[0].data_servico+' horário: '+data[0].hora_servico +
                        '</div>'
                    '</div>';

            $(".orcamentoResposta").addClass("d-none");
        }
        else if(data[j].status.id == 5)
                    {
            var small = "";

            if(data[j].descricao != null)
                descricao = '<textarea class="form-control" rows="2" readonly>'+(data[j].descricao != null ? data[j].descricao : "Sem descrição cadastrada")+'</textarea>';

            html += '<div class="col-md-12 col-sm-12 col-xs-12">' +
                        '<div class="form-group">' +
                            '<label for="nome">Status do Pedido</label>' +
                            '<br/><i class="fas fa-chevron-right"></i> O Cliente recusou o orçamento gerado.' +
                            '<small>'+small+'</small>'+
                            descricao +
                        '</div>'+
                    '</div>';

            $(".orcamentoResposta").removeClass("d-none");
        }
        else if(data[j].status.id == 6)
        {
            html += '<div class="col-md-12 col-sm-12 col-xs-12">'+
                        '<div class="alert alert-danger alert-dismissible">'+
                            '<h5><i class="icon fas fa-exclamation-circle"></i>Serviço Cancelado</h5>'+
                            'O serviço foi cancelado por: '+data[j].usuario.nome+', na data: '+data[j].data_alteracao +
                        '</div>'
                    '</div>';

            $(".orcamentoResposta").addClass("d-none");
        }
        else if(data[j].status.id == 7)
        {
            html += '<div class="col-md-12 col-sm-12 col-xs-12">'+
                        '<div class="alert alert-success  alert-dismissible">'+
                            '<h5><i class="icon fas fa-check"></i> Concluido</h5>'+
                            'O Serviço foi concluido na data: (colocar data)'+
                        '</div>'
                    '</div>';
        }

        html += '</div>';
        html += '</td>';

        if(j == abre + 2)
        {
            html += '</tr>';
        }
    }

    $("#bloco_orcamento").append(html);

    $("#modal_orcamento").modal("show");
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
            $.ajax({
                type: "post",
                url: BASE_URL+"Servico/cancela_servico/"+id,
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

function servicoRealizado(id)
{
    Swal.fire({
        title: 'Aviso',
        text: "Definir este serviço como realizado?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: `Sim`,
        cancelButtonText: `Não`,
        }).then((result) => {
        if (result.isConfirmed)
        {
            $.ajax({
                type: "post",
                url: BASE_URL+"Servico/servico_realizado/"+id,
                dataType: "json",
                success: function(data)
                {
                    if(data.rst === true)
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso',
                            text: data.msg
                        }).then((result) => {
                            i=0;
                            tableOrcamento.ajax.reload();
                        });
                    }
                    else if(data.rst === false)
                    {
                        showNotification("warning", data.msg, "Tente novamente daqui a alguns minutos", "toast-top-center");
                    }
                }
            });
        }
    });
}
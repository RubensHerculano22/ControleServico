var tableOrcamento;
var i = 0;

$(document).ready(function(){

    var verifVisivel = 1;

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

    var id = $("#id_servico").val();    
    atualiza_perguntas(id);

    $("input[data-bootstrap-switch]").each(function(){
        $.post( BASE_URL+"Servico/get_visibilidade/"+id, function( data ) {
            if(data == 1)
                $("input[data-bootstrap-switch]").bootstrapSwitch('state', $("input[data-bootstrap-switch]").prop('checked'));
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

    var tableMensagem = $("#lista_mensagem").DataTable({
        language: {
            url: BASE_URL+"assets/plugins/datatables/portugues-brasil.json",
            select: { rows: { _: "%d linhas selecionadas", 1: "1 linha selecionada", 0: "" } }
        },
        ajax: {
            url: BASE_URL+"Servico/get_mensangens/"+id,
            dataSrc: "",
            type: "post",
            dataType: "json",
        },
        order: [[5, "asc"],[4,"desc"],[3, "desc"]],
        columns: [
            {data: "id_tipo_movimentacao.nome", title: "Tipo de Movimentação"},
            {data: "id_emitente.nome", title: "Emitente"},
            {data: "status.nome", title: "Status"},
            {data: "data_movimentacao", title: "Data de Solicitação"},
            {data: "data_modificacao", title: "Ultima Modificação"},
            {
                data: null,
                title: "Opções",
                render: function(data, x, row){

                    var edita = '<a href="<?= base_url("Movimentacao/") ?>'+row.tipo_movimentacao+'/'+row.id+'" class="btn bg-amber waves-effect"><p class="hide">1</p><i class="material-icons">edit</i></a>';
                    var exibe = '<a href="<?= base_url("Movimentacao/exibeMovimentacao") ?>'+'/'+row.id+'" class="btn bg-indigo waves-effect"><p class="hide">3</p><i class="material-icons">info</i></a>';
                    var exibe_finalizada = '<a href="<?= base_url("Movimentacao/exibeMovimentacao") ?>'+'/'+row.id+'" class="btn bg-green waves-effect"><p class="hide">2</p><i class="material-icons">check</i></a>';
                    var responder = '<a href="<?= base_url("Movimentacao/exibeMovimentacao") ?>'+'/'+row.id+'" class="btn bg-red waves-effect"><p class="hide">1</p><i class="material-icons">create</i></a>';
                    if(row.depart.id_departamento === '13' || row.depart.id_departamento === '35')
                    {
                        if(row.id_empregado == '<?= $dados->user_id ?>')
                        {
                            if(row.status.id == '4')
                                return edita;
                            else if(row.status.id == '9')
                                return exibe_finalizada;
                            else
                                return exibe;
                        }
                        else
                        {
                            if(row.status.id == '2' || row.status.id == '4')
                                return responder;
                            else if(row.status.id == '9')
                                return exibe_finalizada;
                            else
                                return exibe;
                        }
                    }
                    else if(row.depart.id_departamento === '28')
                    {
                        if(row.status.id == '3')
                            return responder;
                        else
                            return exibe
                    }
                    else if(row.id_empregado == '<?= $dados->user_id ?>')
                    {
                        if(row.status.id == '5' || row.status.id == '6' || row.status.id == '12')
                            return edita;
                        else if(row.status.id == '1' || row.status.id == '7' || row.status.id == '8')
                            return exibe;
                        else
                            return exibe;
                    }
                    else if(row.status.id == '11')
                    {
                        if(row.p_logado === '434' || row.p_logado === '300')
                            return responder;
                        else
                            return exibe;
                    }
                    else if(row.id_supervisor == '<?= $dados->user_id ?>')
                    {
                        if(row.status.id == '1')
                            return responder;
                        else
                            return exibe;
                    }
                    else
                        return exibe;
                }
            }
        ],
        "columnDefs": [
            {"type": 'date-uk', "targets": [3, 4]},
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
        columns: [
            {
                data:null,
                title: "Ação",
                render: function(data, x, row){
                    i++;
                    return '<button type="button" class="btn btn-outline-info" onclick="abriOrcamento('+i+')"><i class="fas fa-info-circle"></i></button>';
                }
            },
            {data: "usuario.nome", title: "Nome do Solicitante"},
            {data: "solicitacao.descricao", title: "Horário de Solicitação"},
            {
                data: null, 
                title: "Ultima Modificação",
                render: function(data, x, row){
                    return row.solicitacao.data_servico + " " + row.solicitacao.hora_servico;
                }
            },
            {data: "status.nome", title: "Status do Orçamento"},
        ],
        "columnDefs": [
            {"className": "text-center", "targets": "_all"},
        ],
    });

    $("#ver_lista").on("click", function(e){
        e.preventDefault();
        if($(".lcp_bloc").hasClass('d-none'))
        {
            atualiza_perguntas(id, true);
            $(".lcp_bloc").removeClass("d-none");
        }
        else
        {
            $(".lcp_bloc").addClass("d-none");
        }
            
    })

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
                    atualiza_perguntas(id, true)
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
    var pergunta = $("#pergunta"+id)[0].innerHTML;
    var resposta = $("#resposta"+id);
    console.log(resposta.length)
    $("#id_pergunta").val(id);
    $("#pergunta_input").val(pergunta);
    if(resposta.length > 0)
        $("#resposta").val(resposta[0].innerHTML);
    $("#modal_resposta").modal("show");
}

function atualiza_perguntas(id, resposta = false)
{
    $.ajax({
        type: "post",
        url: BASE_URL+"Servico/get_perguntas/"+id+"/"+resposta,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(data)
        {
            if(resposta == true)
            {
                $(".lista_pergunta_completa").remove();

                if(data.length > 0)
                {
                    $.each( data, function( key, value ) {
                        var html = '<div class="col-md-12 col-sm-12 col-xs-12 lista_pergunta_completa">' +
                                        '<div class="callout callout-info">' +
                                            '<div class="row">' +
                                                '<div class="col-md-10 col-sm-12 col-xs-12">' +
                                                    '<p id="pergunta'+value.id+'">'+value.pergunta+'</p>' +
                                                    (value.resposta != null ? '<small id="resposta'+value.id+'">'+value.resposta+'</small>' : '')  +
                                                    '<small class="float-right">'+value.data_inclusao_br+'</small>' +
                                                '</div>' +
                                                '<div class="col-md-2 col-sm-12 col-xs-12 align-self-center text-center">' +
                                                    '<button type="button" class="btn btn-info mr-4" onclick="abrirResposta('+value.id+')">'+(value.resposta != null ? 'Editar Resposta' : 'Responder')+'</button>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>';    
                        
                        $("#lcp").append(html);
                    });
                }
                else
                {
                    var html = '<div class="col-md-12 col-sm-12 col-xs-12 lista_pergunta">' +
                                '<div class="callout callout-info">' +
                                    '<p>Este Serviço ainda não possui perguntas.</p>' +
                                '</div>' +
                            '</div>';
                            
                    $("#lcp").append(html);
                }
                
            }
            else
            {
                $(".lista_pergunta").remove();

                if(data.length > 0)
                {
                    $.each( data, function( key, value ) {
                        var html = '<div class="col-md-12 col-sm-12 col-xs-12 lista_pergunta">' +
                                        '<div class="callout callout-info">' +
                                            '<div class="row">' +
                                                '<div class="col-md-10 col-sm-12 col-xs-12">' +
                                                    '<p id="pergunta'+value.id+'">'+value.pergunta+'</p>' +
                                                    '<small class="float-right">'+value.data_inclusao_br+'</small>' +
                                                '</div>' +
                                                '<div class="col-md-2 col-sm-12 col-xs-12 align-self-center text-center">' +
                                                    '<button type="button" class="btn btn-info mr-4" onclick="abrirResposta('+value.id+')">Responder</button>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>';    

                        $("#lista_pergunta").append(html);
                    });
                }
                else
                {
                    var html = '<div class="col-md-12 col-sm-12 col-xs-12 lista_pergunta">' +
                                '<div class="callout callout-info">' +
                                    '<p>Este Serviço ainda não possui perguntas pedentes.</p>' +
                                '</div>' +
                            '</div>';
                            
                    $("#lista_pergunta").append(html);
                }
            }
        }
    });
}

function abriOrcamento(id)
{
    id = id - 1;
    var data = tableOrcamento.row(id).data();
    
    $("#data_servico").val(data.solicitacao.data_servico);
    $("#hora_servico").val(data.solicitacao.horario_servico);
    $("#descricao").val(data.solicitacao.descricao);
    $("#endereco").val(data.solicitacao.endereco);
    $("#id_orcamento").val(data.id);

    $("#modal_orcamento").modal("show");
}